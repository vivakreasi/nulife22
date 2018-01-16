<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\AppTools;
use App\StrukturJaringan;
use App\SumberStruktur;
use App\Anggota;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class NulifeA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nulife:convert {opt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert / migration database nulife from old to latest version';

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
        $opt = $this->argument('opt');
        $available_options = array(
            'structure' => ['function' => 'setCodeStructure', 'description' => 'get Structure by level from admin and then convert'],
            'password'  => ['function' => 'setUserPassword', 'description' => 'Update and Hash All of User Password'],
        );
        if (!array_key_exists($opt, $available_options)) {
            print "command option not available.\n";
            print "Available Options :\n";
            foreach ($available_options as $key => $value) {
                print $key . str_repeat("\t", ceil(12 / strlen($key))) . "=> " . $value['description'] . "\n";
            }
            print "\n";
            return;
        }
        $this->{$available_options[$opt]['function']}();
    }

    public function setUserPassword() {
        ini_set('memory_limit', '1024M');
        set_time_limit(0);
        $updated    = 0;
        $total      = 0;
        print "Running...\n";
        foreach (User::where(DB::Raw("LEFT(password, 6)"), '<>', '$2y$10')->cursor() as $row) {
            $total += 1;
            $values = array('password' => Hash::make($row->password));
            try {
                $row->update($values);
                $updated += 1;
            } catch (\Exception $e) {
            }
        }
        print "done -- updated " . number_format($updated, 0, ',', '.') . " from " . number_format($total, 0, ',', '.') . " rows.\n";
    }

    public function setCodeStructure() {
         ini_set('memory_limit', '1024M');
        set_time_limit(0);
        $updated    = 0;
        $total      = 0;
        print "Running...\n";
        foreach (StrukturJaringan::orderBy('id')->cursor() as $row) {
            $total += 1;
            if (empty($row->kode)) {
                $sumber = SumberStruktur::where('userid', '=', $row->userid)->first();
                if (!empty($sumber)) {
                    $values = ['level' => $sumber->level];
                    if ($row->userid == 'admin') {
                        $values['kode'] = '1.1';
                        try {
                            $row->update($values);
                            $updated += 1;
                        } catch (\Exception $e) {
                        }
                    } else {
                        $parent = StrukturJaringan::where('user_id', '=', $row->upline_id)->first();
                        if (!empty($parent) && !empty($parent->kode)) {
                            $values['kode'] = AppTools::getStructureCodeByFoot($parent->kode, $sumber->level, $row->foot, '.', '-');
                            try {
                                $row->update($values);
                                $updated += 1;
                            } catch (\Exception $e) {
                            }
                        }
                    }
                }
            }
        }
        print "done -- updated " . number_format($updated, 0, ',', '.') . " from " . number_format($total, 0, ',', '.') . " rows.\n";
    }
}
