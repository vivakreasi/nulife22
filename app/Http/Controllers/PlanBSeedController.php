<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PlanBSeedController extends Controller
{

    public function seedPlanB()
    {
        ini_set('memory_limit', '1024M');
        
        $clsUser = new User();
        if ($clsUser->seedPlanBReferal()) {
            echo 'DONE';
        }
    }


}
