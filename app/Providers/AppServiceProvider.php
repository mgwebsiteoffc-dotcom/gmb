<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Self-heal the Laravel exception-renderer dist assets.
        //
        // On a fresh or antivirus-quarantined vendor, `styles.css` / `scripts.js`
        // inside the framework's exception renderer can be missing, which makes
        // Laravel unable to render ANY error page:
        //
        //   file_get_contents(...resources/exceptions/renderer/dist/styles.css): Failed to open stream
        //
        // We keep byte-exact copies bundled in the repo and restore them at boot
        // (guarded by file_exists so this is essentially free after the first run).
        if ($this->app->runningInConsole() || $this->app->environment('local', 'production')) {
            $this->ensureRendererAssets();
        }
    }

    protected function ensureRendererAssets(): void
    {
        $bundled = base_path('resources/vendor/laravel-exception-renderer/dist');
        $dest = base_path('vendor/laravel/framework/src/Illuminate/Foundation/resources/exceptions/renderer/dist');

        if (! is_dir($bundled) || ! is_dir(dirname($dest))) {
            return;
        }

        if (! is_dir($dest)) {
            @mkdir($dest, 0755, true);
        }

        if (! is_dir($dest)) {
            return;
        }

        foreach (['styles.css', 'scripts.js'] as $file) {
            $source = $bundled.'/'.$file;
            $target = $dest.'/'.$file;

            if (! is_file($source)) {
                continue;
            }

            // Only copy when missing or suspiciously tiny (truncated/quarantined).
            if (! is_file($target) || filesize($target) < 1000) {
                @copy($source, $target);
            }
        }
    }
}
