<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Untab — Finish Setup</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif; background: #f0f4ff; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; color: #0f172a; }
        .card { background: #fff; max-width: 640px; width: 100%; border-radius: 24px; box-shadow: 0 20px 50px rgba(15,31,138,.12); padding: 40px; border: 1px solid #e0eaff; }
        .logo { width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg,#1e1b4b,#5666e8); display: flex; align-items: center; justify-content: center; font-size: 26px; color: #fff; margin-bottom: 20px; }
        h1 { font-size: 26px; font-weight: 800; margin-bottom: 8px; }
        p { color: #475569; font-size: 14px; line-height: 1.6; margin-bottom: 8px; }
        code { background: #f1f5f9; padding: 2px 6px; border-radius: 6px; font-size: 13px; color: #1e293b; }
        pre { background: #0f172a; color: #e2e8f0; padding: 18px; border-radius: 14px; overflow-x: auto; font-size: 13px; line-height: 1.7; margin: 16px 0; }
        pre .cmt { color: #94a3b8; }
        ol { margin: 12px 0 16px 20px; color: #334155; font-size: 14px; line-height: 1.9; }
        .btn { display: inline-block; background: #1e1b4b; color: #fff; font-weight: 700; font-size: 14px; padding: 12px 22px; border-radius: 12px; text-decoration: none; margin-top: 8px; box-shadow: 0 8px 20px rgba(26,53,200,.25); }
        .alt { background: #f1f5f9; color: #334155; box-shadow: none; margin-left: 8px; }
        .box { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; padding: 12px 16px; border-radius: 12px; font-size: 13px; margin: 14px 0; }
        ul { margin-left: 20px; color: #334155; font-size: 14px; line-height: 1.9; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">↗</div>
        <h1>Untab is installed but not set up yet</h1>
        <p>Your database hasn't been migrated yet, so the app can't render pages right now. This usually just needs one command. Here's exactly what to run:</p>

        <ol>
            <li>Open your terminal in the project folder (<code>C:\laragon\www\gmb</code>)</li>
            <li>Run the one-line installer below</li>
            <li>Reload this page and log in</li>
        </ol>

        <pre># Run this in project root (from Composer, Laragon terminal, or cmd)
composer run setup</pre>

        <p>...or, if you prefer the step-by-step (or <code>composer run setup</code> isn't available):</p>

        <pre><span class="cmt"># 1. Install dependencies</span>
composer install
<span class="cmt"># 2. Create SQLite DB + .env + app key</span>
php scripts/authenticate-framework-renderer.php
@php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
@php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate
<span class="cmt"># 3. Create tables + demo data</span>
php artisan migrate --seed</pre>

        <p>Alternatively, run the built-in installer command in one step:</p>
        <pre>php artisan untab:install --fresh</pre>

        <div class="box">
            <strong>Windows / Laragon tip:</strong> the framework's error-page assets
            (<code>scripts.js</code>) are sometimes quarantined by antivirus. Enable the PHP
            <code>zip</code> extension in <code>php.ini</code> and re-run
            <code>composer install</code> if you see a <code>renderer/dist/styles.css</code>
            error. This page already self-heals those files on <code>composer install</code>.
        </div>

        <p>Once the tables are created, the demo accounts are:</p>
        <ul>
            <li><code>owner@untab.com</code> / <code>password123</code> — <strong>Super Admin</strong> (goes to <code>/admin</code>)</li>
            <li><code>apex@untab.com</code> / <code>password123</code> — Brand Admin</li>
            <li><code>sarah@untab.com</code> / <code>password123</code> — User / Staff</li>
        </ul>

        <a class="btn" href="/login">Reload / Go to Login</a>
    </div>
</body>
</html>
