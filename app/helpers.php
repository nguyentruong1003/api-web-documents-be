<?php
/**
 * Return nav-here if current path begins with this path.
 *
 * @param string $path
 * @return string
 */

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use SebastianBergmann\Environment\Console;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function setActive($path)
{
    return \Request::is($path . '*') ? ' active' : '';
}

function setOpen($path)
{
    return \Request::is($path . '*') ? ' menu-is-opening menu-open' : '';
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

function removeStringUtf8($str)
{
    $hasSign = array(
        'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ', '&agrave;', '&aacute;', '&acirc;', '&atilde;',
        'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ', '&egrave;', '&eacute;', '&ecirc;',
        'ì', 'í', 'ị', 'ỉ', 'ĩ', '&igrave;', '&iacute;', '&icirc;',
        'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ', '&ograve;', '&oacute;', '&ocirc;', '&otilde;',
        'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ', '&ugrave;', '&uacute;',
        'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ', '&yacute;',
        'đ', '&eth;',
        'À', 'Á', 'Ạ', 'Ả', 'Ã', 'Â', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă', 'Ằ', 'Ắ', 'Ặ', 'Ẳ', 'Ẵ', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;',
        'È', 'É', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ', '&Egrave;', '&Eacute;', '&Ecirc;',
        'Ì', 'Í', 'Ị', 'Ỉ', 'Ĩ', '&Igrave;', '&Iacute;', '&Icirc;',
        'Ò', 'Ó', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;',
        'Ù', 'Ú', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ', '&Ugrave;', '&Uacute;',
        'Ỳ', 'Ý', 'Ỵ', 'Ỷ', 'Ỹ', '&Yacute;',
        'Đ', '&ETH;',
    );
    $noSign = array(
        'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
        'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
        'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i',
        'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
        'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
        'y', 'y', 'y', 'y', 'y', 'y',
        'd', 'd',
        'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A',
        'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
        'I', 'I', 'I', 'I', 'I', 'I', 'I', 'I',
        'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O',
        'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
        'Y', 'Y', 'Y', 'Y', 'Y', 'Y',
        'D', 'D'
    );

    $str = str_replace($hasSign, $noSign, $str);
    return $str;
}

if (!function_exists('getFileSize')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function getFileSize(UploadedFile $file)
    {
        $bytes = $file->getSize();
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}

function getFileOnGoogleDriveServer($id) {
    $file = File::findorfail($id);
    $filename = $file->url;
    $dir = '/';
    $recursive = false; // Có lấy file trong các thư mục con không?
    $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
    $data = $contents->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->first();
    $data['link'] = 'https://drive.google.com/file/d/' . $data['path'] . '/preview';
    $data['view'] = 'https://drive.google.com/file/d/' . $data['path'] . '/view';

    return $data;
}

function checkAdminOrAuthor($id) {
    $current_user = Auth::user();
    if ($current_user->hasAnyRole(['administrator', 'moderator']) || $current_user->id == $id) {
        return true;
    }
    return false;
}

function checkAdminCanView()
{
    if (Auth::user()->hasAnyRole(['administrator', 'moderator', 'view admin'])) {
        return true;
    }
    
    return false;
}