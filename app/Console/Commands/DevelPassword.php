<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DevelPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'development:password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all password, for development only';

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
     * @return mixed
     */
    public function handle()
    {
        $password = 'aaa';
        DB::table('users')->update(array('password' => Hash::make($password)));
        print "Password development sudah diupdate dengan password \"" . $password . "\"\n";
    }
}
