<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RestoreSQLiteDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore SQLite database from a SQL dump file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File {$file} not found.");
            return 1;
        }

        $sqliteDatabase = database_path('database.sqlite');
        if (file_exists($sqliteDatabase)) {
            $this->info("🗑️ Deleting existing SQLite database...");
            unlink($sqliteDatabase);
        }

        file_put_contents($sqliteDatabase, '');

        $this->info("✨ Restoring SQLite database...");

        $this->call('db:wipe', ['--force' => true]);

        $queries = file_get_contents($file);
        DB::unprepared($queries);

        $this->info("✅ SQLite database restored successfully.");

        return 0;
    }
}
