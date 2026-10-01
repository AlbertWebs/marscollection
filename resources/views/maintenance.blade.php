<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#171611">
    <title>Under Maintenance | Mars Collection</title>
    <style>
        * { box-sizing: border-box; }
        body { --ink: #171611; --muted: #77756d; --gold: #e5a928; margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 34px; overflow-x: hidden; background: #f2efe7; color: var(--ink); font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        body::before { position: fixed; inset: 0; z-index: -1; background: radial-gradient(ellipse at 14% 14%, rgba(229,169,40,.17), transparent 34%), radial-gradient(ellipse at 90% 90%, rgba(27,35,34,.08), transparent 35%); content: ""; }
        main { width: min(1100px, 100%); min-height: 590px; display: grid; grid-template-columns: 1fr 1fr; overflow: hidden; border: 1px solid rgba(23,22,17,.08); border-radius: 28px; background: #fffefa; box-shadow: 0 35px 100px rgba(35,31,20,.16); }
        .copy { position: relative; display: flex; flex-direction: column; align-items: flex-start; justify-content: center; padding: clamp(38px, 7vw, 84px); }
        .brand { display: flex; align-items: center; gap: 13px; margin-bottom: auto; }
        .brand img { width: 136px; height: auto; }
        .brand-line { width: 1px; height: 32px; background: #dedbd2; }
        .brand-caption { color: var(--muted); font-size: 10px; font-weight: 700; letter-spacing: .18em; line-height: 1.5; text-transform: uppercase; }
        .label { display: inline-flex; align-items: center; gap: 9px; margin: 48px 0 18px; padding: 9px 12px; border: 1px solid #f0dfb5; border-radius: 999px; background: #fff9e9; color: #875e0d; font-size: 10px; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; }
        .pulse { position: relative; width: 7px; height: 7px; border-radius: 50%; background: var(--gold); }
        .pulse::after { position: absolute; inset: -4px; border: 1px solid var(--gold); border-radius: 50%; animation: pulse 1.8s ease-out infinite; content: ""; }
        h1 { max-width: 480px; margin: 0; font-size: clamp(44px, 6vw, 72px); font-weight: 650; letter-spacing: -.065em; line-height: .99; }
        h1 span { color: #bd8516; }
        .message { max-width: 390px; margin: 24px 0 0; color: #69675f; font-size: 15px; line-height: 1.8; }
        .actions { display: flex; flex-wrap: wrap; align-items: center; gap: 20px; margin-top: 34px; }
        .button { display: inline-flex; align-items: center; gap: 12px; min-height: 48px; padding: 0 19px; border-radius: 6px; background: var(--ink); color: white; font-size: 12px; font-weight: 700; letter-spacing: .04em; text-decoration: none; transition: background .2s, transform .2s; }
        .button:hover { transform: translateY(-2px); background: #9c6d13; }
        .button span { font-size: 17px; }
        .eta { color: var(--muted); font-size: 11px; }
        .foot { margin-top: auto; padding-top: 48px; color: #aaa79e; font-size: 10px; letter-spacing: .13em; text-transform: uppercase; }
        .visual { position: relative; min-height: 590px; overflow: hidden; background: #24221b; }
        .visual::after { position: absolute; inset: 0; background: linear-gradient(180deg, rgba(14,14,12,.03) 35%, rgba(14,14,12,.58) 100%); content: ""; }
        .visual img { width: 100%; height: 100%; position: absolute; inset: 0; object-fit: cover; object-position: 55% center; }
        .image-tag { position: absolute; z-index: 1; right: 28px; bottom: 28px; left: 28px; display: flex; align-items: flex-end; justify-content: space-between; gap: 16px; color: white; }
        .image-tag p { margin: 0; }
        .image-tag .overline { margin-bottom: 7px; color: #f4cd78; font-size: 9px; font-weight: 800; letter-spacing: .2em; text-transform: uppercase; }
        .image-tag .title { font-size: 21px; font-weight: 600; letter-spacing: -.03em; }
        .image-tag .index { font-size: 11px; letter-spacing: .12em; opacity: .75; }
        @keyframes pulse { 0% { transform: scale(.65); opacity: .8; } 100% { transform: scale(1.8); opacity: 0; } }
        @media (max-width: 760px) { body { padding: 16px; } main { grid-template-columns: 1fr; } .copy { min-height: 560px; padding: 34px clamp(26px, 8vw, 58px); } .brand { margin-bottom: 0; } .label { margin-top: 55px; } .foot { padding-top: 45px; } .visual { min-height: 340px; } }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; scroll-behavior: auto !important; transition-duration: .01ms !important; } }
    </style>
</head>
<body>
    <main>
        <section class="copy">
            <div class="brand">
                <img src="{{ asset('mars-collections-logo.png') }}" alt="Mars Collection">
                <span class="brand-line" aria-hidden="true"></span>
                <span class="brand-caption">Step into<br>your style</span>
            </div>
            <p class="label"><span class="pulse" aria-hidden="true"></span> A little refresh is underway</p>
            <h1>Good things<br>are <span>in motion.</span></h1>
            <p class="message">We’re polishing the Mars Collection experience. Our online store will be back shortly with all your favourite pairs.</p>
            <div class="actions">
                <a class="button" href="mailto:hello@marscollection.co.ke">Need help? Contact us <span aria-hidden="true">↗</span></a>
                <span class="eta">Thanks for bearing with us</span>
            </div>
            <p class="foot">Mars Collection · Made to move</p>
        </section>
        <section class="visual" aria-label="Mars Collection footwear">
            <img src="{{ asset('images/mars-footwear-hero.png') }}" alt="A featured footwear look from Mars Collection">
            <div class="image-tag">
                <div><p class="overline">Find your next favourite</p><p class="title">The next step starts here.</p></div>
                <span class="index">MC / 01</span>
            </div>
        </section>
    </main>
</body>
</html>
