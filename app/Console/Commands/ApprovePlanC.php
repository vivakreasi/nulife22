<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\MutasiMandiri;
use App\Plan_c_mandiri;
use App\Plan_c;
use App\Plan_c_pin;
use App\AppTools;
use Illuminate\Support\Facades\DB;

class ApprovePlanC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'planc:approve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Approve new Plan-C by matching payment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private $sparatorOut = '#';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(env('APP_MANDIRI',false)) {
            $timeExec = date('Y-m-d H:i:s');
            $this->processMatchingData($timeExec);
            print "\n";
        }
    }

    private function processMatchingData($timeExec) {
        $today      = date('Y-m-d', strtotime($timeExec));
        $menit      = intval(date('i'));
        $clsPlanCMandiri    = new Plan_c_mandiri();
        $clsPinC            = new Plan_c_pin();
        $dataMutasi = $clsPlanCMandiri->getByDate($today, true);
        $dataOrder  = $clsPinC->getNewByOrderDate($today);
        //$dataOrder  = $clsPinC->getNewByOrderDate($today, false);    // testing
        print $timeExec . $this->sparatorOut . $menit;
        if ($dataOrder->isEmpty() || empty($dataMutasi)) {
            print $this->sparatorOut . "Tidak ada data yang dapat diproses";
            return;
        }
        $jmlSukses  = 0;
        $jmlGagal   = 0;
        $jmlProcess = 0;
        foreach ($dataOrder as $row) {
            $jmlProcess += 1;
            $matching = $this->isMatched($row, $dataMutasi);
            if ($matching->match) {
                DB::beginTransaction();
                if ($clsPinC->setApprove($row->id, $matching->id_mutasi) && $clsPlanCMandiri->setProcessed($matching->id_planc_mandiri)) {
                    $jmlSukses += 1;
                    DB::commit();
                } else {
                    $jmlGagal += 1;
                    DB::rollback();
                }
            }
        }
        print $this->sparatorOut . "Jumlah Proses:" . $jmlProcess;
        print $this->sparatorOut . "Jumlah Sukses:" . $jmlSukses;
        print $this->sparatorOut . "Jumlah Gagal:" . $jmlGagal;
        return;
    }

    private function isMatched($rowOrder, $dataMutasi) {
        $result = (object) array('match' => false, 'id_planc_mandiri' => 0, 'id_mutasi' => 0);
        foreach ($dataMutasi as $key => $value) {
            if ($value->angka_unik == $rowOrder->unik_pin && $value->angka_pokok == $rowOrder->harga_pin && $value->id_mutasi > 0 && $value->angka_pokok > 0 && $value->status == 0 && $rowOrder->status == 4) {
                $result->match = true;
                $result->id_planc_mandiri = $value->id;
                $result->id_mutasi = $value->id_mutasi;
                break;
            }
        }
        return $result;
    }
}