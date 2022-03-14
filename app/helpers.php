<?php
/**
 * Return nav-here if current path begins with this path.
 *
 * @param string $path
 * @return string
 */

use App\Models\GwApproveResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

function setActive($path)
{
    return \Request::is($path . '*') ? ' class=active' : '';
}

function setOpen($path)
{
    return \Request::is($path . '*') ? ' class=open' : '';
}

function reFormatDate($datetime, $format = null)
{
    if (empty($datetime)) {
        return '';
    }

    if ($format == null) {
        $format = config('common.formatDate');
    }
    return (($datetime != '0000-00-00 00:00:00') && ($datetime != '0000-00-00')) ? date($format, strtotime($datetime)) : '';
}

function numberFormat($money = 0, $dec_point = '.', $thousands_sep = ',')
{
    $arr = explode('.', sprintf("%.2f", $money));
    $decimal = (count($arr) > 1 && $arr[1] != '00') ? 2 : 0;
    return number_format($money, $decimal, $dec_point, $thousands_sep);
}

function checkPermission($permission)
{
    if (Auth::user()->hasRole('administrator')) {
        return true;
    }
    if (Auth::user()->can($permission)) {
        return true;
    }
    return false;
}

function checkButtonCanView($action)
{
    $router_name = Route::getCurrentRoute()->getName();
    $permission = str_replace('index', $action, $router_name);
    return checkPermission($permission);
}

function checkRoutePermission($action) {
    $routerName = Route::getCurrentRoute()->getName();
    $arr = explode('.', $routerName);
    $arr[count($arr) - 1] = $action;
    $permission = join('.', $arr);
    return checkPermission($permission);
}

function boldTextSearchV2($text, $searchTerm){
    if (!strlen($searchTerm)) {
        return $text;
    }
    $newText = strtolower(removeStringUtf8($text));
    $newSearchTerm = strtolower(removeStringUtf8($searchTerm));
    $lengText = strlen($newText);
    $lengSearchTerm = strlen($newSearchTerm);
    $index = 0;
    for($i = 0; $i <= $lengText - $lengSearchTerm; $i++){
        if($newSearchTerm==substr($newText,$i,$lengSearchTerm)){
            $text = mb_substr($text,0,$i+$index).'<b>'.mb_substr($text,$i+$index,$lengSearchTerm).'</b>'.mb_substr($text,$i + $index + $lengSearchTerm ,$lengText-$i-$lengSearchTerm);
            $index+=5;
        }
    }
    return $text;

}

function removeFormatNumber($number, $specials = ['.', ','])
{
    foreach ($specials as $special) {
        $number = str_replace($special, '', $number);
    }
    return (int)$number;
}
