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
use SebastianBergmann\Environment\Console;

function setActive($path)
{
    return \Request::is('*' . $path . '*') ? ' active' : '';
}

function setOpen($path)
{
    // dd($path);
    return \Request::is('*' . $path . '*') ? ' menu-is-opening menu-open' : '';
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
    if ($routerName == 'livewire.message') {
        $routerName = Route::getCurrentRoute()->name;
    }
    $arr = explode('.', $routerName);
    $arr[count($arr) - 1] = $action;
    if ($arr[0] == 'admin') {
        unset($arr[0]);
    }
    $permission = join('.', $arr);
    return checkPermission($permission);
}

function boldTextSearch($text, $searchTerm)
{
    return str_replace($searchTerm, '<b>' . $searchTerm . '</b>', $text);
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

function checkShowMode()
{
    $name = Route::getCurrentRoute()->getName();
    $arr = explode(".", $name);
    $action = end($arr);
    if ($action == 'show') {
            return true;
    }
    return false;
}