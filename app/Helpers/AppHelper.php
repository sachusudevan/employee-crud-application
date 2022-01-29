<?php

namespace App\Helpers;


class AppHelper {

    /**
     * Generate random string
     * @return mixed
     */
    public static function generateRandomString($length = 6, $type = 'num') {
        if ($type == 'num') {
            $pool = '0123456789';
        } else {
            $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

}
