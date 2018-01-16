<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class GeneratePin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pin:generate';

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
     * @return mixed
     */
    public function handle()
    {
        $type = $this->anticipate('Add or remove pin? (A/R)', ['A', 'R']);
        if($type != 'A' && $type != 'a' && $type != 'R' && $type != 'r'){
            $this->error('Please only input A or R!');
            exit;
        }
        $userid = $this->ask('Which user? (Input userid, e.g : NUL0000001)');
        $cek = DB::table('users')->where('userid', $userid)->first();
        if(!$cek){
            $this->error('Userid not found');
            exit;
        }
        $pin = $this->ask('How much pin do you want to add/remove?');
        if(!is_numeric($pin)){
            $this->error('Please only input number');
            exit;
        }
        $this->info('Please check your input data below');
        $this->line('Type = '.(($type=='A'||$type=='a')?'Add Pin':'Remove Pin'));
        $this->line('Userid = '.$userid." [".$cek->name."]");
        $this->line('Amount of PIN = '.$pin);
        if ($this->confirm('ARE YOU SURE? (DISCLAIMER : Developer is not responsible of any wrong input)')) {
            if($type == 'a' || $type == 'A'){
                $this->addpin($userid,$pin);
            }
            else{
                $this->removepin($userid,$pin);
            }
            $this->info('Success!');
        }
    }

    public function addpin($userid,$pin)
    {
        $data = DB::table('users')->where('userid', $userid)->first();
        if(!$data){
            return $this->error('Userid not found');
            exit;
        }
        $amount = $pin;
        $trans_code = strtoupper(uniqid());
        $transaction_id = DB::table('tb_transaction')->insertGetId([
            'transaction_code' => $trans_code,
            'transaction_type' => 2,
            'from' => 0,
            'to' => $data->id,
            'total_price' => $amount*350000,
            'unique_digit' => '000',
            'status' => 2
        ]); 
        $transaction_list_id = DB::table('tb_transaction_list')->insertGetId([
            'transaction_code' => $trans_code,
            'pin_type_id' => 1,
            'amount' => $amount
        ]);
        $bar = $this->output->createProgressBar($amount);
        for ($x=0; $x < $amount; $x++) { 
            $new_pin_code = 'OLDP-'.$x.date('his').rand(1,999);
            $cek = DB::table('tb_pin')->where('pin_code', $new_pin_code)->first();
            if($cek){
                $new_pin_code = 'OLDP-'.$x.date('his').rand(1,999);
                $cek = DB::table('tb_pin')->where('pin_code', $new_pin_code)->first();
                if($cek){
                    $new_pin_code = 'OLDP-'.$x.date('his').rand(1,999);
                    $cek = DB::table('tb_pin')->where('pin_code', $new_pin_code)->first();
                    if($cek){
                        $new_pin_code = 'OLDP-'.$x.date('his').rand(1,999);
                        $cek = DB::table('tb_pin')->where('pin_code', $new_pin_code)->first();
                        if($cek){
                            echo "old_pin => userid = ".$userid.", loop = ".$x;exit;
                        }
                    }
                }
            }
            
            $new_pin = new \App\Pin;
            $new_pin->pin_code = $new_pin_code;
            $new_pin->pin_type_id = 1;
            $new_pin->is_sold = 0;
            $new_pin->save();

            $new_pin_member = new \App\PinMember;
            $new_pin_member->pin_code = $new_pin_code;
            $new_pin_member->pin_type_id = 1;
            $new_pin_member->user_id = $data->id;
            $new_pin_member->transaction_code = $trans_code;
            $new_pin_member->is_used = 0;
            $new_pin_member->save();

            // Tambah di transaction_detail
            $transaction_detail[$x] = new \App\TransactionDetail;
            $transaction_detail[$x]->transaction_list_id = $transaction_list_id;
            $transaction_detail[$x]->pin_code = $new_pin_code;
            $transaction_detail[$x]->save();

            $bar->advance();
        }
        $bar->finish();
    }
    
    public function removepin($userid,$pin)
    {
        $data = DB::table('users')->where('userid', $userid)->first();
        if(!$data){
            return $this->error('Userid not found');
            exit;
        }
        $amount = $pin;
        $bar = $this->output->createProgressBar($amount);
        for ($x=0; $x < $amount; $x++) { 
            $activepin = DB::table('tb_pin_member')->where('user_id', $data->id)->orderBy('created_at', 'ASC')->where('is_used', 0)->first();
            if(!$activepin){
                $this->error('Sorry, not enought pin to remove [removed pin : '.$x.']');
                exit;
            }
            $trans_code = $activepin->transaction_code;
            
            DB::table('tb_pin')->where('pin_code', $activepin->pin_code)->delete();
            DB::table('tb_pin_member')->where('pin_code', $activepin->pin_code)->delete();
            DB::table('tb_transaction')->where('transaction_code', $trans_code)->delete();
            DB::table('tb_transaction_confirm')->where('transaction_code', $trans_code)->delete();

            $trans_list_id = DB::table('tb_transaction_list')->where('transaction_code', $trans_code)->first();
            if(!$trans_list_id){
                continue;
            }
            else{
                $trans_list_id = $trans_list_id->id;
                DB::table('tb_transaction_list')->where('transaction_code', $trans_code)->delete();
                DB::table('tb_transaction_detail')->where('transaction_list_id', $trans_list_id)->delete();
            }

            $bar->advance();
        }
        $bar->finish();
    }
}
