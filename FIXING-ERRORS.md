# FIXING-ERRORS

Common setup errors for the Untab Laravel project and how to fix them.

---

## 1. `file_get_contents(...): .../exceptions/renderer/dist/styles.css): Failed to open stream: No such file or directory`

```
file_get_contents(C:\laragon\www\gmb\vendor\laravel\framework\src\Illuminate\Foundation\Exceptions\Renderer/../../resources/exceptions/renderer/dist/styles.css):
Failed to open stream: No such file or directory
(View: ...\vendor\laravel\framework\src\Illuminate\Foundation\resources\exceptions\renderer\components\layout.blade.php)
```

### Root cause

The compiled **exception-renderer assets** (`dist/styles.css`, `dist/app.js`) are shipped only in the
**Composer `dist` zip** of `laravel/framework`, NOT in the **git source** checkout (`vendor/…/framework`
cloned from `github.com/laravel/framework.git`). The framework's `.gitattributes` excludes those compiled
assets from the git repo, so a **source** install is missing them and Laravel cannot render any error page.

This happens when Composer installs the framework from **source** instead of **dist** — usually because:
- Composer was invoked with `--prefer-source`, or
- The package resolved to a `dev-*`/branch version, or
- Composer fell back to source (e.g. it could not download/extract the zip — a common cause is the
  PHP **`zip` extension being disabled** on Windows/Laragon).

### Fix

**Step 1 — enable the PHP `zip` extension** (often the real culprit on Laragon/Windows). Open your
`php.ini` (in Laragon: *Menu → PHP → php.ini*, or the folder under `C:\laragon\bin\php\<version>\`) and
uncomment:

```ini
extension=zip
```

Then **restart Laragon**.

**Step 2 — force Composer to install the framework from dist and rebuild the vendor tree.**
From the project root (`C:\laragon\www\gmb`):

```bash
# Option A: refresh just the framework package as a dist zip
composer update laravel/framework --prefer-dist

# Option B (use this if Option A does not fix it): wipe vendor and reinstall from dist
rmdir /s /q vendor                 (Windows)    # or:  rm -rf vendor   (macOS/Linux)
composer install --prefer-dist
composer config --global preferred-install dist
```

**Step 3 — clear caches and verify the asset exists:**

```bash
php artisan optimize:clear
```

Then confirm the compiled files are present:

```
vendor\laravel\framework\src\Illuminate\Foundation\resources\exceptions\renderer\dist\styles.css
vendor\laravel\framework\src\Illuminate\Foundation\resources\exceptions\renderer\dist\app.js
```

> **Prevention:** always use `composer install` / `composer update` **without** `--prefer-source`.
> You can set a global default so it never happens again:
> ```bash
> composer config --global preferred-install dist
> ```

---

## 2. `Class "..." not found` / `failed to open stream` after adding code

The autoloader may be stale. Regenerate it and clear caches:

```bash
composer dump-autoload -o
php artisan optimize:clear
```

---

## 3. New migration / seeder not running

```bash
php artisan migrate
php artisan db:seed
```
Or seed only the users/team:
```bash
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=TeamSeeder
```

---

## 4. Blank pages / white screen after login

Check the logs first:

```bash
php artisan optimize:clear
tail -f storage/logs/laravel.log
```

Ensure `.env` exists, `APP_KEY` is set, and `APP_URL` matches your host (`http://localhost:8000` in dev).
