<?php
/**
 * Created by IntelliJ IDEA.
 * User: Elio
 * Date: 07/05/2018
 * Time: 11:42
 */

namespace App\Services;


class GeneralService
{
    function sort($arr) {

        usort($arr, function($a, $b){
            $ad = $a->getDate();
            $bd = $b->getDate();

            if ($ad == $bd) {
                return 0;
            }

            return $ad < $bd ? -1 : 1;
        });
        return $arr;
    }
}