<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\MutasiMandiri;
use App\Plan_c_mandiri;
use App\Plan_c_pin;
use App\AppTools;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class PaymentPlanC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'planc:payment-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Check Payment on Plan-C';

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
        if(env('APP_MANDIRI',false)){
            $menit = intval(date('i'));
            $timeExec = date('Y-m-d H:i:s');
            print $timeExec;
            print $this->sparatorOut . $menit;
            $newMutasi  = $this->getMutasiMandiri($timeExec);
            if ($newMutasi->status != '200') {
                print $this->sparatorOut . "Error " . $newMutasi->status . " : " . $newMutasi->data;
            } elseif (!is_array($newMutasi->data) || empty($newMutasi->data)) {
                print $this->sparatorOut . "Tidak ada data yang dapat diproses";
                if (!is_array($newMutasi->data)) {
                    print $this->sparatorOut . "'" . $newMutasi->data . "'";
                }
            } else {
                if (!$this->processMutasi($newMutasi->data, $timeExec)) {
                    print $this->sparatorOut . "Gagal proses check mutasi";
                }
            }
            print "\n";
        }
    }

    private function getMutasiMandiri($tglCheck) {
        $api_key = env('APP_MANDIRI_KEY','');
        $result = (object) array('status' => '404', 'data' => []);
        try{
            $http = new Client([
                'base_uri'          => 'http://adsnet.id',
                //'base_uri'          => 'http://adsnet.api/',
                'timeout'           => 60,
                //'debug'             => true,
            ]);

            $start  = date('Y-m-d', strtotime($tglCheck));
            $end    = date('Y-m-d', strtotime($tglCheck));

            //$response = $http->request('POST', 'mandiri', [
            $response = $http->request('POST', 'api/mandiri/' . $start . '/' . $end, [
            //$response = $http->request('GET', 'mandiri?start=' . $start . '&end=' . $end, [
                'headers'   => ['APIToken' => $api_key],
            ]);

            $result->status = $response->getStatusCode();
            if($result->status == '200') {
                $result->data = json_decode($response->getBody()->getContents());
            } elseif ($response->getStatusCode() == '401') {
                $result->data = '401';
            } elseif ($response->getStatusCode() == '500') {
                $result->data = 'server error';
            }

        } catch (ClientException $e) {
            $result->status = $e->getCode();
            $result->data = $e->getMessage();
        } catch (RequestException $e) {
            $result->status = $e->getCode();
            $result->data = $e->getMessage();
        } catch (\Exception $e) {
            $result->status = '999';
            $result->data = $e->getMessage();
        }
        return $result;
    }

    private function processMutasi($data, $tglCheck) {
        if (!is_array($data) || empty($data)) return false;
        $clsMutasi          = new MutasiMandiri();
        $clsPlanCMandiri    = new Plan_c_mandiri();
        $clsPin             = new Plan_c_pin();
        $urut       = 1;
        $sukses     = true;
        $today      = date('Y-m-d', strtotime($tglCheck));
        $currentMutasi  = $clsMutasi->getDataByDate($today, true);
        $isMasihKosong  = empty($currentMutasi);
        $currentPlanC   = $clsPlanCMandiri->getByDate($today, true);
        DB::beginTransaction();
        foreach ($data as $row) {
            $ambil = true;
            if (!$isMasihKosong) {
                $ambil = !array_key_exists($urut, $currentMutasi);
            }
            $tglTransaksi   = AppTools::dmy_to_ymd($row[0]);
            $debit          = AppTools::number_formated_to_number($row[2]);
            $credit         = AppTools::number_formated_to_number($row[3]);
            $formatedCredit = AppTools::format_number($credit, 2, '', '.');
            if ($ambil) {
                $mData  = array(
                    'no_urut'           => $urut,
                    'tgl_check'         => $tglCheck,
                    'tgl_transaksi'     => $tglTransaksi,
                    'uraian_transaksi'  => $row[1],
                    'debit'             => AppTools::format_number($debit, 2, '', '.'),
                    'credit'            => $formatedCredit
                );
                $mutasi = null;
                if (!$clsMutasi->saveData($mData, $mutasi)) {
                    $sukses = false;
                    break;
                }
                if ($credit > 0 && !array_key_exists($urut, $currentPlanC)) {
                    $pecahan    = $clsPlanCMandiri->fixCreditValue($credit);
                    $xData      = array(
                        'no_urut'           => $urut,
                        'tgl_check'         => $tglCheck,
                        'tgl_transaksi'     => $tglTransaksi,
                        'uraian_transaksi'  => $row[1],
                        'credit'            => $formatedCredit,
                        'angka_pokok'       => $pecahan['angka_pokok'],
                        'angka_desimal'     => $pecahan['angka_desimal'],
                        'angka_unik'        => $clsPin->setUniqueDigit($pecahan['angka_unik']),
                        'processed'         => 0,
                        'id_mutasi'         => $mutasi->id
                    );
                    $xMutasi = null;
                    if (!$clsPlanCMandiri->saveData($xData, $xMutasi)) {
                        $sukses = false;
                        break;
                    }

                }
            }
            $urut++;
        }
        if ($sukses) {
            DB::commit();
            print $this->sparatorOut . "SUCCESS";
        } else {
            DB::rollback();
            print $this->sparatorOut . "FAILED";
        }
        return $sukses;
    }
}
