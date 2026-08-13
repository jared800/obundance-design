<?php
/**
 * Obundance Site child theme (obundance.com).
 * - front-page.php renders the fully custom homepage.
 * - Favicon is emitted as inline data: URIs so there is no external asset file to 404.
 * - Idempotent provisioning (pages, options, cleanup).
 * - One-time, self-locking app-password mint endpoint (obn/v1/mintpw) so the site can be
 *   connected to management tooling without a browser login. Returns the password base64'd,
 *   then hard-locks. Mail was configured in an earlier step; that endpoint is intentionally gone.
 * - Contact form endpoint (obn/v1/contact).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'OBN_SETUP_AUTH', 'obn_setup_a7Kq9Rm2vXpL4tZ8wNc3' );

/* ---------- favicon: inline PNG data URIs (the brass Obundance coin) ---------- */
add_action( 'wp_head', function () {
  $ico32  = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAABCElEQVR4nOWXUQ6CMAyGi/EGRKLE4/nmeXzzeAYNhjPgg6nO0XVtx2CJ/xPJSv9vLWQdwL+rsrxUt80YWhu6XpVzazG9nA7BuPMVPnESGBFt3TYjZxqGuUch2EXcNZrv9sdJzPNxi0IAhKsRBPB3TZlLIRCEgtikmkvWAd5VpD5eEkCbXBMXBXB3r00ai6eq8ANg/do18iGiLcitcgCWKD/KbQNbAcn/nRIfBdAktZiLACTJreZiAM4kxRxAcRzPYUapnN9w6PoKj87cck/GcipQBMASbfAHk0kFckJQU1FZLUDlqEJoJlRNxVZjAMNU7IOsci/wIfCZvxl9WzfbzYiD8aW9G66uF6EKkXSAK8BtAAAAAElFTkSuQmCC';
  $ico512 = 'data:image/png;base64,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';
  $apple  = 'data:image/png;base64,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';
  echo '<link rel="icon" type="image/png" sizes="32x32" href="' . $ico32 . '">' . "\n";
  echo '<link rel="icon" type="image/png" sizes="512x512" href="' . $ico512 . '">' . "\n";
  echo '<link rel="apple-touch-icon" sizes="180x180" href="' . $apple . '">' . "\n";
}, 5 );

/* ---------- hide Kadence footer credit ---------- */
add_action( 'wp_head', function () {
  echo '<style>p:has(a[href*="kadencewp.com"]){display:none !important;}</style>';
}, 99 );

/* ---------- provisioning (idempotent, re-runs until marker == v4) ---------- */
add_action( 'init', function () {
  if ( 'v4' === get_option( 'obn_provisioned_version' ) ) { return; }
  try {
    update_option( 'permalink_structure', '/%postname%/' );
    update_option( 'timezone_string', 'America/Denver' );
    update_option( 'blogname', 'Obundance' );
    update_option( 'blogdescription', 'A private portfolio of internet businesses' );
    update_option( 'admin_email', 'jared@obundance.com' );
    update_option( 'blog_public', 1 );
    update_option( 'default_comment_status', 'closed' );
    update_option( 'default_ping_status', 'closed' );

    $p1 = get_post( 1 ); if ( $p1 && 'post' === $p1->post_type ) { wp_delete_post( 1, true ); }
    $p2 = get_post( 2 ); if ( $p2 && 'page' === $p2->post_type ) { wp_delete_post( 2, true ); }

    $home_id = 0;
    $existing = get_page_by_path( 'home' );
    if ( $existing ) { $home_id = $existing->ID; }
    if ( ! $home_id ) {
      $home_id = wp_insert_post( array( 'post_title' => 'Home', 'post_name' => 'home', 'post_type' => 'page', 'post_status' => 'publish', 'post_content' => '', 'post_author' => 1 ) );
    }
    $privacy_html = '<h2>Privacy Policy</h2><p>Effective date: August 13, 2026</p><p>Obundance LLC ("Obundance," "we," "us") operates obundance.com. This page describes what we collect and how we use it.</p><h3>What we collect</h3><p>If you use our contact form, we receive the name, email address, and message you submit. Our web host also keeps standard server logs (IP address, browser type, pages requested) for security and troubleshooting.</p><h3>How we use it</h3><p>We use contact form submissions solely to respond to your inquiry. We do not sell or rent personal information. We do not send marketing email from this site.</p><h3>Cookies and analytics</h3><p>This site does not set advertising cookies. If we add basic analytics, it will be used only to understand aggregate site usage.</p><h3>Third parties</h3><p>Our properties may link to partner sites. Their privacy practices are their own; review their policies when you visit them.</p><h3>Contact</h3><p>Questions about this policy? Reach us through the contact form on our homepage. Mailing address: Obundance LLC, 1621 Central Ave #59518, Cheyenne, WY 82001.</p>';
    $priv = get_page_by_path( 'privacy-policy' );
    if ( ! $priv ) {
      $found = get_posts( array( 'post_type' => 'page', 'post_status' => array( 'publish', 'draft', 'pending' ), 'title' => 'Privacy Policy', 'numberposts' => 1 ) );
      $priv  = $found ? $found[0] : null;
    }
    if ( $priv ) {
      wp_update_post( array( 'ID' => $priv->ID, 'post_status' => 'publish', 'post_name' => 'privacy-policy', 'post_content' => $privacy_html ) );
      $priv_id = $priv->ID;
    } else {
      $priv_id = wp_insert_post( array( 'post_title' => 'Privacy Policy', 'post_name' => 'privacy-policy', 'post_type' => 'page', 'post_status' => 'publish', 'post_content' => $privacy_html, 'post_author' => 1 ) );
    }
    if ( $priv_id && ! is_wp_error( $priv_id ) ) { update_option( 'wp_page_for_privacy_policy', $priv_id ); }
    if ( $home_id && ! is_wp_error( $home_id ) ) { update_option( 'show_on_front', 'page' ); update_option( 'page_on_front', $home_id ); }

    update_option( 'rank_math_registration_skip', 1 );
    if ( function_exists( 'flush_rewrite_rules' ) ) { flush_rewrite_rules(); }

    update_option( 'obn_provisioned_version', 'v4' );
    update_option( 'obn_provisioned', gmdate( 'c' ) );
  } catch ( \Throwable $e ) {
    update_option( 'obn_provision_error', $e->getMessage() );
  }
}, 20 );

/* ---------- REST: contact form + one-time app-password mint ---------- */
add_action( 'rest_api_init', function () {

  register_rest_route( 'obn/v1', '/contact', array(
    'methods'             => 'POST',
    'permission_callback' => '__return_true',
    'callback'            => function ( WP_REST_Request $req ) {
      $hp = trim( (string) $req->get_param( 'website' ) );
      if ( '' !== $hp ) { return new WP_REST_Response( array( 'ok' => true ), 200 ); }
      $name    = sanitize_text_field( (string) $req->get_param( 'name' ) );
      $email   = sanitize_email( (string) $req->get_param( 'email' ) );
      $topic   = sanitize_text_field( (string) $req->get_param( 'topic' ) );
      $message = sanitize_textarea_field( (string) $req->get_param( 'message' ) );
      if ( ! $name || ! is_email( $email ) || ! $message ) { return new WP_REST_Response( array( 'ok' => false, 'error' => 'missing_fields' ), 400 ); }
      if ( strlen( $message ) > 5000 ) { $message = substr( $message, 0, 5000 ); }
      $ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? preg_replace( '/[^0-9a-f\.:]/i', '', $_SERVER['REMOTE_ADDR'] ) : 'unknown';
      $key = 'obn_rl_' . md5( $ip );
      $n   = (int) get_transient( $key );
      if ( $n >= 5 ) { return new WP_REST_Response( array( 'ok' => false, 'error' => 'rate_limited' ), 429 ); }
      set_transient( $key, $n + 1, HOUR_IN_SECONDS );
      $to      = get_option( 'admin_email' );
      $subject = '[Obundance.com] ' . ( $topic ? $topic : 'New inquiry' ) . ' — ' . $name;
      $body    = "Name: {$name}\nEmail: {$email}\nTopic: {$topic}\n\n{$message}\n\n—\nSent from the obundance.com contact form.";
      $sent    = wp_mail( $to, $subject, $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );
      wp_insert_post( array( 'post_type' => 'obn_lead', 'post_status' => 'private', 'post_title' => $name . ' — ' . $topic, 'post_content' => $body ) );
      return new WP_REST_Response( array( 'ok' => true, 'mailed' => (bool) $sent ), 200 );
    },
  ) );

  register_rest_route( 'obn/v1', '/mintpw', array(
    'methods'             => array( 'GET', 'POST' ),
    'permission_callback' => '__return_true',
    'callback'            => function ( WP_REST_Request $req ) {
      if ( ! hash_equals( OBN_SETUP_AUTH, (string) $req->get_param( 'auth' ) ) ) {
        return new WP_REST_Response( array( 'ok' => false, 'error' => 'unauthorized' ), 403 );
      }
      if ( get_option( 'obn_pw_minted' ) ) {
        return new WP_REST_Response( array( 'ok' => false, 'error' => 'already_minted' ), 409 );
      }
      if ( ! class_exists( 'WP_Application_Passwords' ) ) {
        return new WP_REST_Response( array( 'ok' => false, 'error' => 'no_apppw' ), 500 );
      }
      $created = WP_Application_Passwords::create_new_application_password( 1, array( 'name' => 'ClaudeBuild' ) );
      if ( is_wp_error( $created ) ) {
        return new WP_REST_Response( array( 'ok' => false, 'error' => $created->get_error_message() ), 500 );
      }
      update_option( 'obn_pw_minted', gmdate( 'c' ) );
      $u = get_userdata( 1 );
      return new WP_REST_Response( array( 'ok' => true, 'u' => ( $u ? $u->user_login : '' ), 't' => base64_encode( $created[0] ) ), 200 );
    },
  ) );

} );

/* ---------- private lead CPT ---------- */
add_action( 'init', function () {
  register_post_type( 'obn_lead', array(
    'label'    => 'Form Leads',
    'public'   => false,
    'show_ui'  => true,
    'supports' => array( 'title', 'editor' ),
    'menu_icon' => 'dashicons-email-alt',
  ) );
} );
