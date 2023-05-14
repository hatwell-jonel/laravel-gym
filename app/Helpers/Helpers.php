<?php

namespace App\Helpers;

class Helpers {
    public static function IDGenerator($model, $trow, $length = 3, $prefix, $branch = ''){

        $data = $model::orderBy('id', 'desc')->first();
        
        if(!$data){
            $last_number = '';
        }else{
            $code                   = substr($data->$trow,strlen($prefix)+1);
            $actual_last_number     = ($code/1)*1;
            $increment_last_number  = $actual_last_number+1;
            $last_number            = $increment_last_number;
        }
        
        $khmer = '';
        for($i=1; $i<$length; $i++){
            $khmer.='0';
        }

        if( $model->count() == 0){
            $khmer.='1';
        }

        return $prefix.$branch.$khmer.$last_number;
    }
}