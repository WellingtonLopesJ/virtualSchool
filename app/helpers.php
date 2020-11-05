<?php

if (! function_exists('array_of_column')) {
    function array_of_column($collection, $column) {

        $result = [];

        foreach ($collection as $item){

            $result[] = $item->$column ?? null;
        }

        return $result;
    }
}
