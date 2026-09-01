<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UntabInstall extends Command
{
    protected $signature = 'untab:install {--fresh : Drop all tables and re-migrate}';

    protected $description = 'Set up the Untab app: env, key, database, migrations & demo seeders';

    public function handle(): int
    {
        $this->info('⚡ Setting up Untab...');

        // 1. .env
        if (! file_exists(base_path('.env'))) {
            $this->task('Creating .env from .env.example', function () {
                copy(base_path('.env.example'), base_path('.env'));
            });
        } else {
            $this->line('  .env already exists.');
        }

        // 2. SQLite database file
        $this->task('Ensuring database/database.sqlite exists', function () {
            if (! file_exists(database_path('database.sqlite'))) {
                touch(database_path('database.sqlite'));
            }
        });

        // 3. Database migration
        $migrationArgs = ['--seed', '--force'];
        if ($this->option('fresh')) {
            $migrationArgs[] = '--fresh';
        }

        $this->task('Running migrations '.(app()->isProduction() ? '(forced)' : '') , function () use ($migrationArgs) {
            $code = $this->callSilently('migrate', $migrationArgs);
            return $code === 0;
        });

        // 4. Storage link + caches
        $this->task('Clearing caches', function () {
            $this->callSilently('optimize:clear');
            return true;
        });

        $this->info('');
        $this->info('✅ Untab is ready!');
        $this->info('   App URL   : '.env('APP_URL', 'http://localhost:8000'));
        $this->info('   Login     : owner@untab.com  /  password123  (Super Admin)');
        $this->info('   Admin     : /admin  (Super Admin panel)');

        return self::SUCCESS;
    }
}
