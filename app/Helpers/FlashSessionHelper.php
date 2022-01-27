<?php 

namespace App\Helpers;
use stdClass;
use Session;


class FlashSessionHelper {
    
    public static function createflashmsg($type = "", $message = "") {
        Session::flash('message', self::getMessage($message)); 
        Session::flash('type', $type); 
        return true;
    }
    
    
    
    public function getMessage($code){
        $message = '';
        switch ($code) {
            case 100:
                $message = 'Data Successfullly Updated';
                break;
            case 201:
                $message = 'Data Successfullly Created';
                break;
            
            case 101:
                $message = 'Something Went Wrong';
                break;

            default:
                break;
        }
        
        return $message;
    }

}