<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

#[Signature('app:dbbackup')]
#[Description('Create a database backup file in storage/app/backup')]
class DBBackup extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $disk = Storage::disk('local');

        if (! $disk->exists('backup')) {
            $disk->makeDirectory('backup');
        }

        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $dumpPath = env('DB_MYSQLDUMP_PATH', 'mysqldump');

        $filename = $database . "_" . now()->format('d-m-Y-H-i-s') . '.sql.gz';
        $path = $disk->path('/backup/' . $filename);

        $command = [
            $dumpPath,
            '--user=' . $username,
            '--host=' . $host,
            '--routines',
            '--events',
            '--triggers',
        ];

        if (! empty($password)) {
            $command[] = '--password=' . $password;
        }

        if (! empty($port)) {
            $command[] = '--port=' . $port;
        }

        $command[] = $database;


        $process = Process::run($command);

        if (! $process->successful()) {
            $errorOutput = trim($process->errorOutput() ?: $process->output());

            if (str_contains($errorOutput, 'not recognized') || str_contains($errorOutput, 'not found')) {
                $errorOutput .= PHP_EOL . 'Please install mysqldump or set MYSQLDUMP_PATH in your .env file.';
            }

            $this->error('Database backup failed.');
            $this->error('Exit code: ' . $process->exitCode());
            $this->line($errorOutput);

            return 1;
        }

        file_put_contents($path, gzencode($process->output(), 9));

        $this->info('Database backup saved as ' . basename($path));

        return 0;
    }
}
