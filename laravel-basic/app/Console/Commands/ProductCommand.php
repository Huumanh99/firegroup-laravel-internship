<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Response;

class ProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Backup:Data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::all()->toArray();
        $filename = "logins.csv";

        $handle = fopen($filename, 'w');
        fputcsv($handle, array_keys($user[0]));

        foreach ($user as $row) {
            fputcsv($handle, array($row['id'], $row['name']));
        }
        fclose($handle);
    }
}
