<?php

/*
 * Untab self-heal script — runs on Composer install/update.
 *
 * A. Framework exception-renderer assets
 *    The compiled `dist/styles.css` and `dist/scripts.js` ship inside
 *    `laravel/framework`, but are sometimes missing from a local `vendor/` —
 *    most often because Windows Defender/antivirus quarantines the large
 *    minified `scripts.js`, or because an unzip was interrupted. When missing,
 *    Laravel cannot render ANY error page and you see:
 *
 *      file_get_contents(...exceptions/renderer/dist/styles.css): Failed to open stream
 *
 *    This restores byte-exact copies bundled in this repo.
 *
 * B. SQLite database file + storage directories
 *    `.env.example` uses `SESSION_DRIVER=database` and an SQLite connection. If
 *    `database/database.sqlite` or the `storage/framework/*` dirs are missing,
 *    login loops / every page throws, which in turn shows the renderer error.
 *    This ensures they always exist.
 */

$projectRoot = dirname(__DIR__);
$verb = PHP_SAPI === 'cli';

function say(string $msg) {
    if (PHP_SAPI === 'cli') {
        fwrite(STDOUT, "[untab-heal] {$msg}\n");
    }
}

// --- A. Renderer assets ---
$bundled = $projectRoot.'/resources/vendor/laravel-exception-renderer/dist';
$destinationDir = $projectRoot.'/vendor/laravel/framework/src/Illuminate/Foundation/resources/exceptions/renderer/dist';

if (is_dir($destinationDir)) {
    $copied = 0;
    foreach (['styles.css', 'scripts.js'] as $file) {
        $source = $bundled.'/'.$file;
        $target = $destinationDir.'/'.$file;
        if (! file_exists($source)) {
            continue;
        }
        if (! file_exists($target) || filesize($target) < 1000) {
            if (@copy($source, $target)) {
                $copied++;
                say("restored framework renderer asset: {$file}");
            }
        }
    }
    say($copied ? "framework renderer assets restored ({$copied} file(s))."
                : "framework renderer assets already present. Nothing to do.");
} else {
    say("vendor/laravel/framework not installed yet — renderer heal skipped.");
}

// --- B. SQLite database file ---
$dbFile = $projectRoot.'/database/database.sqlite';
if (! file_exists($dbFile)) {
    if (@touch($dbFile)) {
        say("created database/database.sqlite");
    } else {
        say("WARNING: could not create database/database.sqlite — create it manually.");
    }
} else {
    say("database/database.sqlite present.");
}

// --- C. Storage framework directories ---
foreach (['sessions', 'views', 'cache', 'cache/data'] as $dir) {
    $path = $projectRoot.'/storage/framework/'.$dir;
    if (! is_dir($path)) {
        @mkdir($path, 0755, true);
        say("ensured storage/framework/{$dir}");
    }
}

say("Done.");
