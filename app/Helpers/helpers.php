<?php

use Carbon\Carbon;
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('maxStr')) {
    function maxStr($str, $maxlen)
    {
        return (strlen($str)>$maxlen) ? substr($str,0,$maxlen).'...' : $str ;
    }
}
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertDatetoYear')) {
    function convertDatetoYear($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y');
    }
}

if (! function_exists('convertDatetileLocToDate')) {
    function convertDatetileLocToDate($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d F Y');
    }
}

if (! function_exists('convertDatetileLocToDateShort')) {
    function convertDatetileLocToDateShort($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d M Y');
    }
}

if (! function_exists('convertDatetileLocToDateDay')) {
    function convertDatetileLocToDateDay($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('l, d F Y');
    }
}
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertDatetileLocToTime')) {
    function convertDatetileLocToTime($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('H:i');
    }
}
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertYdmToMdy')) {
    function convertYdmToMdy($date)
    {
        return Carbon::createFromFormat('Y-d-m', $date)->format('m-d-Y');
    }
}
  