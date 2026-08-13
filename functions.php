<?php
/**
 * Obundance Design child theme.
 * - Front page is a fully custom template (front-page.php).
 * - Provisions the site on first activation (pages, options, cleanup).
 * - Registers the obn/v1 REST namespace: contact form endpoint + one-time boot endpoint.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- favicon ---------- */
add_action( 'wp_head', function () {
	$u = get_stylesheet_directory_uri() . '/assets';
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( $u . '/favicon-32.png' ) . '">' . "\n";
	echo '<link rel="icon" href="' . esc_url( $u . '/favicon.ico' ) . '" sizes="any">' . "\n";
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url( $u . '/apple-touch-icon.png' ) . '">' . "\n";
}, 5 );

/* ---------- hide Kadence footer credit anywhere it might render ---------- */
add_action( 'wp_head', function () {
	echo '<style>p:has(a[href*="kadencewp.com"]){display:none !important;}</style>';
}, 99 );

/* ---------- provisioning: runs once on activation ---------- */
add_action( 'after_switch_theme', function () {
	if ( get_option( 'obn_provisioned' ) ) { return; }
	try {
		// Permalinks
		update_option( 'permalink_structure', '/%postname%/' );
		// Timezone
		update_option( 'timezone_string', 'America/Denver' );
		// Site identity
		update_option( 'blogname', 'Obundance' );
		update_option( 'blogdescription', 'A private portfolio of internet businesses' );
		// Indexable
		update_option( 'blog_public', 1 );
		// Discussion: no comments on this site
		update_option( 'default_comment_status', 'closed' );
		update_option( 'default_ping_status', 'closed' );

		// Delete default content (Hello World post 1, Sample Page 2)
		$p1 = get_post( 1 ); if ( $p1 && 'post' === $p1->post_type ) { wp_delete_post( 1, true ); }
		$p2 = get_post( 2 ); if ( $p2 && 'page' === $p2->post_type ) { wp_delete_post( 2, true ); }

		// Home page (front-page.php renders it, but a real page keeps WP tidy)
		$home_id = 0;
		$existing = get_page_by_path( 'home' );
		if ( $existing ) { $home_id = $existing->ID; }
		if ( ! $home_id ) {
			$home_id = wp_insert_post( array(
				'post_title'   => 'Home',
				'post_name'    => 'home',
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_content' => '',
				'post_author'  => 1,
			) );
		}
		// Privacy page
		$priv = get_page_by_path( 'privacy-policy' );
		if ( ! $priv ) {
			$privacy_html = '<h2>Privacy Policy</h2><p>Effective date: August 13, 2026</p><p>Obundance LLC ("Obundance," "we," "us") operates obundance.com. This page describes what we collect and how we use it.</p><h3>What we collect</h3><p>If you use our contact form, we receive the name, email address, and message you submit. Our web host also keeps standard server logs (IP address, browser type, pages requested) for security and troubleshooting.</p><h3>How we use it</h3><p>We use contact form submissions solely to respond to your inquiry. We do not sell or rent personal information. We do not send marketing email from this site.</p><h3>Cookies and analytics</h3><p>This site does not set advertising cookies. If we add basic analytics, it will be used only to understand aggregate site usage.</p><h3>Third parties</h3><p>Our properties may link to partner sites. Their privacy practices are their own; review their policies when you visit them.</p><h3>Contact</h3><p>Questions about this policy? Reach us through the contact form on our homepage. Mailing address: Obundance LLC, 1621 Central Ave #59518, Cheyenne, WY 82001.</p>';
			$priv_id = wp_insert_post( array(
				'post_title'   => 'Privacy Policy',
				'post_name'    => 'privacy-policy',
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_content' => $privacy_html,
				'post_author'  => 1,
			) );
			if ( $priv_id && ! is_wp_error( $priv_id ) ) {
				update_option( 'wp_page_for_privacy_policy', $priv_id );
			}
		}
		if ( $home_id && ! is_wp_error( $home_id ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $home_id );
		}

		// Rank Math: skip registration wizard nag
		update_option( 'rank_math_registration_skip', 1 );

		// Flush permalinks
		if ( function_exists( 'flush_rewrite_rules' ) ) { flush_rewrite_rules(); }

		update_option( 'obn_provisioned', gmdate( 'c' ) );
	} catch ( \Throwable $e ) {
		update_option( 'obn_provision_error', $e->getMessage() );
	}
} );

/* ---------- REST: contact form ---------- */
add_action( 'rest_api_init', function () {

	register_rest_route( 'obn/v1', '/contact', array(
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => function ( WP_REST_Request $req ) {
			$hp = trim( (string) $req->get_param( 'website' ) ); // honeypot
			if ( '' !== $hp ) {
				return new WP_REST_Response( array( 'ok' => true ), 200 ); // silently drop bots
			}
			$name    = sanitize_text_field( (string) $req->get_param( 'name' ) );
			$email   = sanitize_email( (string) $req->get_param( 'email' ) );
			$topic   = sanitize_text_field( (string) $req->get_param( 'topic' ) );
			$message = sanitize_textarea_field( (string) $req->get_param( 'message' ) );
			if ( ! $name || ! is_email( $email ) || ! $message ) {
				return new WP_REST_Response( array( 'ok' => false, 'error' => 'missing_fields' ), 400 );
			}
			if ( strlen( $message ) > 5000 ) { $message = substr( $message, 0, 5000 ); }

			// Simple rate limit: 5 per hour per IP
			$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? preg_replace( '/[^0-9a-f\.:]/i', '', $_SERVER['REMOTE_ADDR'] ) : 'unknown';
			$key = 'obn_rl_' . md5( $ip );
			$n   = (int) get_transient( $key );
			if ( $n >= 5 ) {
				return new WP_REST_Response( array( 'ok' => false, 'error' => 'rate_limited' ), 429 );
			}
			set_transient( $key, $n + 1, HOUR_IN_SECONDS );

			$to      = get_option( 'admin_email' );
			$subject = '[Obundance.com] ' . ( $topic ? $topic : 'New inquiry' ) . ' — ' . $name;
			$body    = "Name: {$name}\nEmail: {$email}\nTopic: {$topic}\n\n{$message}\n\n—\nSent from the obundance.com contact form.";
			$sent    = wp_mail( $to, $subject, $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );

			// Always log the lead as a private post so nothing is lost if mail fails
			wp_insert_post( array(
				'post_type'    => 'obn_lead',
				'post_status'  => 'private',
				'post_title'   => $name . ' — ' . $topic,
				'post_content' => $body,
			) );

			return new WP_REST_Response( array( 'ok' => true, 'mailed' => (bool) $sent ), 200 );
		},
	) );

} );

/* ---------- private lead CPT (not public, admin-visible) ---------- */
add_action( 'init', function () {
	register_post_type( 'obn_lead', array(
		'label'    => 'Form Leads',
		'public'   => false,
		'show_ui'  => true,
		'supports' => array( 'title', 'editor' ),
		'menu_icon' => 'dashicons-email-alt',
	) );
} );
