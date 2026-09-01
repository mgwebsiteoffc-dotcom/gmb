# FIXING-ERRORS

Quick fixes for the Untab Laravel project.

---

## ⚡ The one-command fix

From the project root (`C:\laragon\www\gmb`):

```bash
composer run setup
```

That installs deps, self-heals the framework renderer, creates `.env`, the SQLite
DB, the app key, and runs `migrate --seed` (creating all tables + demo users).
Or, if Composer scripts aren't available:

```bash
composer install
php scripts/authenticate-framework-renderer.php
@php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
@php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate
php artisan migrate --seed
```

Or the built-in installer:

```bash
php artisan untab:install --fresh
```

Then log in: **`owner@untab.com` / `password123`** (Super Admin → `/admin`).

> If you open the site before migrating, Untab now shows a friendly **"Finish Setup"**
> page instead of crashing — it tells you exactly which command to run.

---

## 1. `...exceptions/renderer/dist/styles.css): Failed to open stream`

```
file_get_contents(C:\laragon\www\gmb\vendor\laravel\framework\src\Illuminate\Foundation\Exceptions\Renderer\../../resources/exceptions/renderer/dist/styles.css):
Failed to open stream: No such file or directory
```

### What's actually happening

`vendor/laravel/framework/.../resources/exceptions/renderer/dist/` ships two compiled
assets — `styles.css` and `scripts.js`. **These genuinely exist in the package**, so
this is usually NOT a source-vs-dist install problem. It's almost always one of:

- **Antivirus quarantined them.** Windows Defender / other AV commonly flags the large
  minified `scripts.js` (712 KB). Laravel then can't render ANY error page.
- **An interrupted/unzipped install** left the `dist` folder incomplete.
- **The database isn't migrated**, so the app throws an exception on login, and then
  the error *renderer* tries to load the asset and fails a second time.

### Fix

**A. The app now self-heals this automatically.** Since commit `f9297ec`, a Composer
script (`scripts/authenticate-framework-renderer.php`) runs on every
`composer install / update / dump-autoload` and restores byte-exact copies of
`styles.css` + `scripts.js` if they're missing. So just re-run:

```bash
composer dump-autoload        # triggers the self-heal
composer install              # or this
```

**B. If it's antivirus,** add an exclusion for the project folder (or specifically
`vendor\laravel\framework\src\Illuminate\Foundation\resources\exceptions\renderer\dist`)
and restore the quarantined file, then re-run `composer install`.

**C. Enable the PHP `zip` extension** (Laragon/Windows) in `php.ini`:

```ini
extension=zip
```

Then restart Laragon. Without `zip`, Composer can't extract the `laravel/framework`
dist zip correctly.

**D. Run the migrations** (this is the actual login blocker):

```bash
php artisan migrate --seed
```

If the `users` table is missing, the app shows the "Finish Setup" page instead of
crashing.

### Manual restore (if you want to do it yourself)

```
vendor\laravel\framework\src\Illuminate\Foundation\resources\exceptions\renderer\dist\styles.css
vendor\laravel\framework\src\Illuminate\Foundation\resources\exceptions\renderer\dist\scripts.js
```

Restore them from the repo copy in `resources/vendor/laravel-exception-renderer/dist/`.

---

## 2. "Not able to login" / login loops

Most likely one of:

1. **DB not migrated** → `php artisan migrate --seed` (or `composer run setup`).
   - The app uses `SESSION_DRIVER=database`, so without the `sessions`/`users`
     tables, login throws. Now handled by the "Finish Setup" page.
2. **Wrong .env** → ensure `.env` exists and `APP_KEY` is set (`php artisan key:generate`).
3. **`is_active` column missing.** My role model is now fail-safe: if the column isn't
   present (migration pending), it's treated as active so login never fails on it.

---

## 3. `Class "..." not found` after adding code

```bash
composer dump-autoload -o
php artisan optimize:clear
```

---

## 4. Blank pages after login

```bash
php artisan optimize:clear
tail -f storage/logs/laravel.log
```
