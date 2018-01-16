<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Validator;

class News extends Model {
    
    public function getAllNews(){
        $sql = DB::table('tb_contents')
                    ->where('tb_contents.publish', '=', 1)
                    ->orderBy('id', 'ASC')
                    ->get();
        return $sql;
    }
    
    public function getNewsByID($id){
        $sql = DB::table('tb_contents')
                    ->where('publish', '=', 1)
                    ->where('id', '=', $id)
                    ->first();
        return $sql;
    }
    
    
    
    
}

