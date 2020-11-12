<?php

if (! function_exists('array_of_column')) {
    function array_of_column($collection, $column) {

        $result = [];

        foreach ($collection as $item){

            $result[] = $item->$column ?? null;
        }

        return $result;
    }

    if (! function_exists('compare_dates')) {

        function compare_dates($date1 ,$operator = '>', $date2 = null){

            if (!$date2){
                $date2 = date('Y-m-d H:i:s');
            }

            $date1 = strtotime($date1);
            $date2 = strtotime($date2);

            return version_compare($date1, $date2, $operator);

        }

    }
}
