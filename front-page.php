<?php
/**
 * Front page — fully custom, standalone render (no Kadence header/footer).
 * Design: "quiet holding company" comp approved 2026-08-13.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,300..800&family=Newsreader:ital,opsz,wght@0,6..72,300..600;1,6..72,300..600&family=Spline+Sans+Mono:wght@300..600&display=swap" rel="stylesheet">
<style>
  :root{
    --paper:#F2F1EC;
    --paper-2:#EAE9E2;
    --ink:#131A16;
    --ink-2:#1B241F;
    --pine:#1C4634;
    --brass:#A87E2F;
    --brass-soft:#C9A45C;
    --slate:#4E564F;
    --hair:rgba(19,26,22,.14);
    --hair-inv:rgba(242,241,236,.16);
    --max:1200px;
  }
  html{scroll-behavior:smooth}
  body.home{
    margin:0;padding:0;
    background:var(--paper);
    color:var(--ink);
    font-family:'Archivo',sans-serif;
    font-variation-settings:'wdth' 100;
    font-weight:380;
    line-height:1.6;
    -webkit-font-smoothing:antialiased;
  }
  .obn *{margin:0;padding:0;box-sizing:border-box}
  .obn ::selection{background:var(--pine);color:var(--paper)}

  .obn .wrap{max-width:var(--max);margin:0 auto;padding:0 clamp(20px,4vw,48px)}

  /* ---------- header ---------- */
  .obn header.obn-top{
    position:sticky;top:0;z-index:50;
    background:color-mix(in srgb, var(--paper) 92%, transparent);
    backdrop-filter:blur(8px);
    border-bottom:1px solid var(--hair);
  }
  .obn .bar{display:flex;align-items:center;justify-content:space-between;height:72px}
  .obn .mark{display:flex;align-items:center;gap:12px;text-decoration:none;color:var(--ink)}
  .obn .coin{
    width:22px;height:22px;border-radius:50%;
    background:radial-gradient(circle at 35% 30%, var(--brass-soft), var(--brass) 70%);
    box-shadow:inset 0 0 0 1.5px rgba(19,26,22,.25);
    flex:none;
  }
  .obn .mark span.mk{
    font-weight:640;letter-spacing:.22em;font-size:14px;text-transform:uppercase;
    font-variation-settings:'wdth' 112;
  }
  .obn nav{display:flex;gap:clamp(18px,3vw,40px)}
  .obn nav a{
    color:var(--slate);text-decoration:none;font-size:13.5px;letter-spacing:.08em;
    text-transform:uppercase;font-weight:500;padding:6px 2px;
    border-bottom:1px solid transparent;transition:color .2s,border-color .2s;
  }
  .obn nav a:hover,.obn nav a:focus-visible{color:var(--ink);border-color:var(--brass)}
  .obn a:focus-visible,.obn button:focus-visible{outline:2px solid var(--pine);outline-offset:3px;border-radius:2px}

  /* ---------- hero ---------- */
  .obn .hero{position:relative;overflow:hidden;border-bottom:1px solid var(--hair)}
  .obn .hero .wrap{padding-top:clamp(72px,11vh,130px);padding-bottom:clamp(72px,11vh,130px);position:relative;z-index:2}
  .obn .eyebrow{
    font-size:12.5px;letter-spacing:.28em;text-transform:uppercase;color:var(--pine);
    font-weight:560;margin-bottom:28px;display:flex;align-items:center;gap:14px;
  }
  .obn .eyebrow::before{content:"";width:34px;height:1px;background:var(--brass)}
  .obn h1{
    font-variation-settings:'wdth' 108;
    font-weight:560;
    font-size:clamp(42px,6.6vw,88px);
    line-height:1.02;
    letter-spacing:-.015em;
    max-width:15ch;
  }
  .obn h1 em{
    font-family:'Newsreader',serif;font-style:italic;font-weight:400;
    letter-spacing:0;color:var(--pine);
  }
  .obn .hero p{
    max-width:52ch;margin-top:30px;font-size:clamp(16px,1.35vw,19px);color:var(--slate);
  }
  .obn .cta-row{display:flex;gap:16px;margin-top:44px;flex-wrap:wrap}
  .obn .btn{
    display:inline-block;text-decoration:none;font-size:13.5px;font-weight:560;
    letter-spacing:.12em;text-transform:uppercase;padding:16px 30px;
    transition:transform .2s ease, background .2s, color .2s;
  }
  .obn .btn-solid{background:var(--ink);color:var(--paper)}
  .obn .btn-solid:hover{background:var(--pine);transform:translateY(-2px)}
  .obn .btn-ghost{color:var(--ink);border:1px solid rgba(19,26,22,.3)}
  .obn .btn-ghost:hover{border-color:var(--brass);color:var(--pine);transform:translateY(-2px)}

  /* constellation of holdings — ambient, right side */
  .obn .field{position:absolute;inset:0;z-index:1;pointer-events:none}
  .obn .field svg{position:absolute;right:-4%;top:0;height:100%;width:min(58vw,760px);opacity:.5}

  /* ---------- ledger (signature) ---------- */
  .obn .ledger{background:var(--ink);color:var(--paper)}
  .obn .ledger .wrap{padding-top:clamp(70px,9vh,110px);padding-bottom:clamp(70px,9vh,110px)}
  .obn .sec-label{
    font-size:12.5px;letter-spacing:.28em;text-transform:uppercase;font-weight:560;
    color:var(--brass-soft);margin-bottom:14px;
  }
  .obn .ledger h2{
    font-variation-settings:'wdth' 108;font-weight:520;font-size:clamp(28px,3.4vw,44px);
    letter-spacing:-.01em;line-height:1.1;max-width:22ch;margin-bottom:56px;
  }
  .obn .ledger h2 em{font-family:'Newsreader',serif;font-style:italic;font-weight:400;color:var(--brass-soft)}
  .obn table.book{width:100%;border-collapse:collapse}
  .obn .book th{
    text-align:left;font-size:11.5px;letter-spacing:.24em;text-transform:uppercase;
    color:rgba(242,241,236,.55);font-weight:500;padding:0 0 16px;
    border-bottom:1px solid var(--hair-inv);
  }
  .obn .book td{
    padding:26px 0;border-bottom:1px solid var(--hair-inv);vertical-align:baseline;
  }
  .obn .h-name{font-size:clamp(17px,1.8vw,22px);font-weight:480;font-variation-settings:'wdth' 104}
  .obn .h-desc{color:rgba(242,241,236,.6);font-size:14.5px;max-width:44ch;padding-right:24px}
  .obn .h-num{
    font-family:'Spline Sans Mono',monospace;font-weight:460;
    font-size:clamp(26px,3vw,40px);letter-spacing:-.02em;text-align:right;white-space:nowrap;
  }
  .obn .h-num small{font-size:.5em;letter-spacing:.08em;color:rgba(242,241,236,.55);font-weight:400}
  .obn .h-status{text-align:right;white-space:nowrap}
  .obn .pill{
    display:inline-block;font-size:11px;letter-spacing:.2em;text-transform:uppercase;
    border:1px solid rgba(201,164,92,.5);color:var(--brass-soft);padding:6px 12px;border-radius:99px;
  }
  .obn .book-note{margin-top:26px;font-size:13px;color:rgba(242,241,236,.45);max-width:70ch}

  /* ---------- operate ---------- */
  .obn .operate .wrap{padding-top:clamp(70px,9vh,110px);padding-bottom:clamp(70px,9vh,110px)}
  .obn .operate h2{
    font-variation-settings:'wdth' 108;font-weight:520;font-size:clamp(28px,3.4vw,44px);
    letter-spacing:-.01em;line-height:1.12;max-width:24ch;margin-bottom:64px;
  }
  .obn .cols{display:grid;grid-template-columns:repeat(3,1fr);gap:clamp(28px,4vw,64px)}
  .obn .col{border-top:2px solid var(--ink);padding-top:26px}
  .obn .col .kicker{
    font-family:'Spline Sans Mono',monospace;font-size:12px;letter-spacing:.18em;
    color:var(--pine);margin-bottom:14px;display:block;
  }
  .obn .col h3{font-size:20px;font-weight:560;font-variation-settings:'wdth' 106;margin-bottom:12px}
  .obn .col p{color:var(--slate);font-size:15.5px}

  /* ---------- creed ---------- */
  .obn .creed{background:var(--paper-2);border-top:1px solid var(--hair);border-bottom:1px solid var(--hair)}
  .obn .creed .wrap{padding-top:clamp(80px,11vh,130px);padding-bottom:clamp(80px,11vh,130px);text-align:center}
  .obn .creed blockquote{
    font-family:'Newsreader',serif;font-weight:340;font-style:italic;
    font-size:clamp(28px,4vw,52px);line-height:1.25;letter-spacing:-.01em;
    max-width:24ch;margin:0 auto;
  }
  .obn .creed blockquote strong{color:var(--pine);font-weight:480}
  .obn .creed cite{
    display:block;margin-top:30px;font-family:'Archivo',sans-serif;font-style:normal;
    font-size:12.5px;letter-spacing:.28em;text-transform:uppercase;color:var(--slate);
  }

  /* ---------- verticals ---------- */
  .obn .verticals .wrap{padding-top:clamp(60px,8vh,96px);padding-bottom:clamp(60px,8vh,96px)}
  .obn .verticals h2{
    font-variation-settings:'wdth' 108;font-weight:520;
    font-size:clamp(28px,3.4vw,44px);letter-spacing:-.01em;
  }
  .obn .vlist{display:flex;flex-wrap:wrap;gap:12px;margin-top:34px}
  .obn .v{
    font-size:14px;letter-spacing:.04em;color:var(--ink);
    border:1px solid rgba(19,26,22,.25);padding:12px 20px;border-radius:99px;
    transition:border-color .2s, background .2s;
  }
  .obn .v:hover{border-color:var(--brass);background:#fff}

  /* ---------- contact ---------- */
  .obn .contact{background:var(--ink);color:var(--paper)}
  .obn .contact .wrap{padding-top:clamp(70px,9vh,110px);padding-bottom:clamp(70px,9vh,110px)}
  .obn .c-grid{display:grid;grid-template-columns:1fr 1.1fr;gap:clamp(40px,6vw,100px)}
  .obn .contact h2{
    font-variation-settings:'wdth' 108;font-weight:520;font-size:clamp(30px,3.6vw,48px);
    line-height:1.08;letter-spacing:-.01em;
  }
  .obn .contact h2 em{font-family:'Newsreader',serif;font-style:italic;font-weight:400;color:var(--brass-soft)}
  .obn .contact .lede{color:rgba(242,241,236,.65);margin-top:22px;font-size:16px;max-width:44ch}
  .obn form{display:grid;gap:20px;position:relative}
  .obn label{font-size:12px;letter-spacing:.2em;text-transform:uppercase;color:rgba(242,241,236,.6);display:block;margin-bottom:8px}
  .obn input,.obn select,.obn textarea{
    width:100%;background:transparent;border:none;border-bottom:1px solid var(--hair-inv);
    color:var(--paper);font-family:'Archivo',sans-serif;font-size:16px;padding:10px 2px 14px;
    transition:border-color .2s;border-radius:0;appearance:none;
  }
  .obn select{background-image:linear-gradient(45deg,transparent 50%,var(--brass-soft) 50%),linear-gradient(135deg,var(--brass-soft) 50%,transparent 50%);background-position:calc(100% - 16px) 50%,calc(100% - 10px) 50%;background-size:6px 6px;background-repeat:no-repeat}
  .obn select option{color:var(--ink)}
  .obn input:focus,.obn select:focus,.obn textarea:focus{outline:none;border-color:var(--brass)}
  .obn textarea{min-height:110px;resize:vertical}
  .obn .send{
    justify-self:start;background:var(--brass);color:var(--ink);border:none;cursor:pointer;
    font-family:'Archivo',sans-serif;font-size:13.5px;font-weight:600;letter-spacing:.12em;
    text-transform:uppercase;padding:16px 34px;transition:background .2s,transform .2s;
  }
  .obn .send:hover{background:var(--brass-soft);transform:translateY(-2px)}
  .obn .send:disabled{opacity:.6;cursor:wait;transform:none}

  /* ---------- footer ---------- */
  .obn footer.obn-bottom{background:var(--ink);color:rgba(242,241,236,.5);border-top:1px solid var(--hair-inv)}
  .obn footer.obn-bottom .wrap{display:flex;justify-content:space-between;align-items:center;padding-top:28px;padding-bottom:28px;gap:16px;flex-wrap:wrap}
  .obn footer.obn-bottom .fm{display:flex;align-items:center;gap:10px;font-size:12.5px;letter-spacing:.18em;text-transform:uppercase}
  .obn footer.obn-bottom .coin{width:14px;height:14px}
  .obn footer.obn-bottom small{font-size:12.5px;letter-spacing:.02em}

  /* ---------- reveal ---------- */
  .obn .rv{opacity:0;transform:translateY(22px);transition:opacity .7s ease,transform .7s ease}
  .obn .rv.on{opacity:1;transform:none}
  @media (prefers-reduced-motion:reduce){
    .obn .rv{opacity:1;transform:none;transition:none}
    html{scroll-behavior:auto}
  }

  /* ---------- responsive ---------- */
  @media (max-width:900px){
    .obn .cols{grid-template-columns:1fr;gap:36px}
    .obn .c-grid{grid-template-columns:1fr;gap:48px}
    .obn .field svg{opacity:.25}
    .obn .book th:nth-child(2),.obn .book td.h-desc{display:none}
  }
  @media (max-width:600px){
    .obn nav a:not(:last-child){display:none}
    .obn .book th:nth-child(4),.obn .book td.h-status{display:none}
  }

  /* keep the sticky header clear of the admin bar when logged in */
  body.home #wpadminbar ~ .obn header.obn-top{top:32px}
</style>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="obn">

<header class="obn-top">
  <div class="wrap bar">
    <a class="mark" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Obundance home">
      <span class="coin" aria-hidden="true"></span>
      <span class="mk">Obundance</span>
    </a>
    <nav aria-label="Primary">
      <a href="#portfolio">Portfolio</a>
      <a href="#approach">Approach</a>
      <a href="#contact">Contact</a>
    </nav>
  </div>
</header>

<section class="hero" id="top">
  <div class="field" aria-hidden="true">
    <svg viewBox="0 0 700 700" preserveAspectRatio="xMidYMid slice">
      <g id="dots"></g>
    </svg>
  </div>
  <div class="wrap">
    <div class="eyebrow rv">A private holding company · Utah</div>
    <h1 class="rv">A quiet portfolio of <em>internet businesses.</em></h1>
    <p class="rv">Obundance builds, acquires, and operates digital properties: consumer research sites, lead-generation platforms, and a deep bench of premium domains. We hold for the long term and grow them with patience.</p>
    <div class="cta-row rv">
      <a class="btn btn-solid" href="#contact">Work with us</a>
      <a class="btn btn-ghost" href="#portfolio">See the portfolio</a>
    </div>
  </div>
</section>

<section class="ledger" id="portfolio">
  <div class="wrap">
    <div class="sec-label rv">The book</div>
    <h2 class="rv">Holdings, <em>at a glance.</em></h2>
    <table class="book" aria-label="Portfolio holdings">
      <thead>
        <tr><th>Holding class</th><th>What it does</th><th style="text-align:right">Count</th><th style="text-align:right">Status</th></tr>
      </thead>
      <tbody>
        <tr class="rv">
          <td class="h-name">Consumer research sites</td>
          <td class="h-desc">Editorial properties that help readers compare providers and make confident buying decisions.</td>
          <td class="h-num" data-count="27">0</td>
          <td class="h-status"><span class="pill">Operating</span></td>
        </tr>
        <tr class="rv">
          <td class="h-name">Lead-generation platforms</td>
          <td class="h-desc">Purpose-built sites that connect qualified buyers with vetted local and national partners.</td>
          <td class="h-num" data-count="12">0</td>
          <td class="h-status"><span class="pill">Operating</span></td>
        </tr>
        <tr class="rv">
          <td class="h-name">Premium domains</td>
          <td class="h-desc">A curated portfolio of category-defining names, held and developed selectively.</td>
          <td class="h-num" data-count="430">0<small>+</small></td>
          <td class="h-status"><span class="pill">Held</span></td>
        </tr>
        <tr class="rv">
          <td class="h-name">Verticals covered</td>
          <td class="h-desc">Finance, home connectivity, legal, health, outdoor recreation, events, and more.</td>
          <td class="h-num" data-count="8">0</td>
          <td class="h-status"><span class="pill">Expanding</span></td>
        </tr>
      </tbody>
    </table>
    <p class="book-note rv">Obundance properties are independently operated. We are compensated by partners we refer; we never charge readers, and our editorial recommendations are our own.</p>
  </div>
</section>

<section class="operate" id="approach">
  <div class="wrap">
    <div class="sec-label rv" style="color:var(--pine)">What we do</div>
    <h2 class="rv">Three disciplines, one operating playbook.</h2>
    <div class="cols">
      <div class="col rv">
        <span class="kicker">BUILD</span>
        <h3>Build &amp; operate</h3>
        <p>We stand up focused properties in niches we understand, write for real buying decisions, and run them on one proven technical stack.</p>
      </div>
      <div class="col rv">
        <span class="kicker">HOLD</span>
        <h3>Acquire &amp; hold</h3>
        <p>We buy category-defining domains and underloved sites, then hold with a long horizon. The portfolio compounds; we don't flip.</p>
      </div>
      <div class="col rv">
        <span class="kicker">PARTNER</span>
        <h3>Partner &amp; refer</h3>
        <p>We send ready-to-buy audiences to partners we've vetted ourselves. Clean tracking, honest volume, and relationships measured in years.</p>
      </div>
    </div>
  </div>
</section>

<section class="creed">
  <div class="wrap">
    <blockquote class="rv">"Own the asset. <strong>Compound quietly.</strong> Stay useful to the reader."</blockquote>
    <cite class="rv">The Obundance operating creed</cite>
  </div>
</section>

<section class="verticals">
  <div class="wrap">
    <div class="sec-label rv" style="color:var(--pine)">Where we operate</div>
    <h2 class="rv">Durable niches, chosen deliberately.</h2>
    <div class="vlist rv">
      <span class="v">Consumer finance</span>
      <span class="v">Home connectivity</span>
      <span class="v">Legal services</span>
      <span class="v">Health &amp; wellness</span>
      <span class="v">Outdoor &amp; recreation</span>
      <span class="v">Events &amp; travel</span>
      <span class="v">Home services</span>
      <span class="v">Specialty retail</span>
    </div>
  </div>
</section>

<section class="contact" id="contact">
  <div class="wrap c-grid">
    <div>
      <div class="sec-label rv">Contact</div>
      <h2 class="rv">Let's talk about <em>working together.</em></h2>
      <p class="lede rv">Affiliate programs looking for a proven publisher, buyers with a domain inquiry, or operators exploring a partnership: we read everything and reply to the good ones.</p>
    </div>
    <form class="rv" id="obn-contact" method="post" novalidate>
      <div style="position:absolute;left:-9999px" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
      <div>
        <label for="f-name">Name</label>
        <input id="f-name" type="text" autocomplete="name" required>
      </div>
      <div>
        <label for="f-email">Email</label>
        <input id="f-email" type="email" autocomplete="email" required>
      </div>
      <div>
        <label for="f-topic">I'm reaching out about</label>
        <select id="f-topic">
          <option>An affiliate or referral partnership</option>
          <option>A domain inquiry</option>
          <option>Acquiring or selling a site</option>
          <option>Something else</option>
        </select>
      </div>
      <div>
        <label for="f-msg">Message</label>
        <textarea id="f-msg" required></textarea>
      </div>
      <button class="send" type="submit">Send message</button>
    </form>
  </div>
</section>

<footer class="obn-bottom">
  <div class="wrap">
    <div class="fm"><span class="coin" aria-hidden="true"></span> Obundance LLC</div>
    <small>&copy; 2026 Obundance LLC · Highland, Utah · Independently owned and operated. · <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" style="color:inherit">Privacy</a></small>
  </div>
</footer>

</div><!-- .obn -->

<script>
  // constellation of holdings: a field of quiet dots, a few brass (the portfolio)
  (function(){
    var g=document.getElementById('dots');
    if(!g)return;
    var seed=42; function rnd(){seed=(seed*9301+49297)%233280;return seed/233280;}
    var ns='http://www.w3.org/2000/svg';
    for(var i=0;i<120;i++){
      var c=document.createElementNS(ns,'circle');
      var brass=rnd()<0.14;
      c.setAttribute('cx',(rnd()*700).toFixed(1));
      c.setAttribute('cy',(rnd()*700).toFixed(1));
      c.setAttribute('r',brass?(2.4+rnd()*2.2).toFixed(1):(1+rnd()*1.4).toFixed(1));
      c.setAttribute('fill',brass?'#A87E2F':'rgba(28,70,52,.35)');
      g.appendChild(c);
    }
  })();

  // scroll reveals
  var obnReduce=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  (function(){
    var els=document.querySelectorAll('.obn .rv');
    if(obnReduce){els.forEach(function(e){e.classList.add('on')});return;}
    var io=new IntersectionObserver(function(en){
      en.forEach(function(x){ if(x.isIntersecting){x.target.classList.add('on');io.unobserve(x.target);} });
    },{threshold:.15});
    els.forEach(function(e){io.observe(e)});
  })();

  // ledger count-up
  (function(){
    function countUp(el){
      var target=+el.dataset.count, t0=null, dur=1200;
      if(obnReduce){el.childNodes[0].nodeValue=target.toLocaleString();return;}
      function step(ts){
        if(!t0)t0=ts;
        var p=Math.min((ts-t0)/dur,1), eased=1-Math.pow(1-p,3);
        el.childNodes[0].nodeValue=Math.round(target*eased).toLocaleString();
        if(p<1)requestAnimationFrame(step);
      }
      requestAnimationFrame(step);
    }
    var nums=document.querySelectorAll('.obn .h-num');
    var io2=new IntersectionObserver(function(en){
      en.forEach(function(x){ if(x.isIntersecting){countUp(x.target);io2.unobserve(x.target);} });
    },{threshold:.6});
    nums.forEach(function(n){io2.observe(n)});
  })();

  // contact form -> REST
  (function(){
    var f=document.getElementById('obn-contact');
    if(!f)return;
    f.addEventListener('submit',function(e){
      e.preventDefault();
      var btn=f.querySelector('.send'); btn.disabled=true; btn.textContent='Sending…';
      var payload={
        name:document.getElementById('f-name').value,
        email:document.getElementById('f-email').value,
        topic:document.getElementById('f-topic').value,
        message:document.getElementById('f-msg').value,
        website:f.querySelector('input[name=website]').value
      };
      fetch('/wp-json/obn/v1/contact',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)})
      .then(function(r){return r.json()})
      .then(function(d){
        if(d.ok){ f.innerHTML='<p style="font-size:18px">Thanks. Your message is in — we’ll be in touch shortly.</p>'; }
        else{ btn.disabled=false; btn.textContent='Send message'; alert(d.error==='rate_limited'?'Too many messages from this connection. Try again in an hour.':'Please fill in your name, a valid email, and a message.'); }
      })
      .catch(function(){ btn.disabled=false; btn.textContent='Send message'; alert('Something went wrong sending your message. Please try again.'); });
    });
  })();
</script>
<?php wp_footer(); ?>
</body>
</html>
