<?php
namespace App\Helpers;
use App\Models\Settings;
use App\Models\Category;
use App\Models\Files;
use App\Models\FileSubmit;
use Spatie\Permission\Models\Role;
use App\Models\Types;
use App\Models\Silder;

use Auth;



class Helpers{
   
    public static function showNotifiCookie() {
        $notifi = self::getCookie('notifi');
        if($notifi != null) {
            $tb = json_decode($notifi);
            self::unsetCookie('notifi');
            return '<div class=" toast alert-'.$tb->status.' alert-dismissible shadow toast-fixed fade show" id="placement-toast2"
            role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false" data-mdb-position="top-right"
            data-mdb-append-to-body="true" data-mdb-stacking="false" data-mdb-width="350px" data-mdb-color="info"
            style="width: 350px; display: block; top: 50px; right: 17px; bottom: unset; left: unset; transform: unset;">
            <div class="toast-header">
                <strong class="me-auto">Thông báo</strong>
                <small>Now</small>
                <button type="button" class="btn-close" data-mdb-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">'.$tb->message.'</div>
        </div>';
        } else {
            return '';
        }
    }
    public static function getCookie($name) {
        if(!isset($_COOKIE[$name])) {
            return null;
        } else {
            return $_COOKIE[$name];
        }
    }
    public static function showNotifi($notifi) {
        if($notifi != null) {
            $tb = json_decode($notifi);
            self::unsetCookie('notifi');
            return '<div class=" toast alert-'.$tb->status.' alert-dismissible shadow toast-fixed fade show" id="placement-toast1"
            role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false" data-mdb-position="top-right"
            data-mdb-append-to-body="true" data-mdb-stacking="false" data-mdb-width="350px" data-mdb-color="info"
            style="width: 350px; display: block; top: 50px; right: 17px; bottom: unset; left: unset; transform: unset;">
            <div class="toast-header">
                <strong class="me-auto">Thông báo</strong>
                <small>Now</small>
                <button type="button" class="btn-close" data-mdb-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">'.$tb->message.'</div>
        </div>';
        } else {
            return '';
        }
    }
    public static function count_file($idPost = null, $uid = null) {
        if($idPost == null) {
            return count(FileSubmit::all());
        } else {
            if($uid == null) {
                $file = FileSubmit::where('idPost', $idPost)->get();
                if($file) return count($file);
                else return 0;
            } else {
                $file = FileSubmit::where('idPost', $idPost)->where('idUser', $uid)->get();
                if($file) return count();
                else return 0;
            }
        }
    }
    public static function setCookie($name, $value, $daylive = 1) {
        setcookie($name, $value, time() + (86400 * $daylive), "/");
    }
    public static function setNotifiCookie($value) {
        self::setCookie('thongbao', $value, 0.1);
    }
    
}
