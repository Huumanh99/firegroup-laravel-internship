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
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=file.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        $id = 0;
        $i = 0;
        $limit = 5;

        do {
            $users = User::orderBy('id', 'asc')->where('id', '>', $id)->limit($limit)->get();
            $countUser = $users->count();
            $arr = $users->toArray();

            if ($countUser == 0)
                return;

            $id = $arr[$countUser - 1]['id'];

            $filename = "filename_" . ++$i . ".csv";

            $columns = array('id', 'name', 'username', 'email', 'password', 'image', 'role', 'is_active', 'created_at', 'updated_at');

            $handle = fopen($filename, 'w');

            fputcsv($handle, $columns);

            foreach ($arr as $value) {
                fputcsv($handle, $value);
            }

            fclose($handle);
        } while ($countUser <= $limit);
    }
}
