<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!class_exists('PHPGangsta_GoogleAuthenticator')) {
    require_once APPPATH . 'third_party/PHPGangsta/PHPGangsta/GoogleAuthenticator.php';
}

if (!function_exists('generate_2fa_secret')) {
    function generate_2fa_secret()
    {
        $ga = new PHPGangsta_GoogleAuthenticator();
        return $ga->createSecret();
    }
}

if (!function_exists('get_2fa_qrcode')) {
    function get_2fa_qrcode($secret, $name, $title)
    {
        $ga = new PHPGangsta_GoogleAuthenticator();
        return $ga->getQRCodeGoogleUrl($title, $name, $secret);
    }
}

if (!function_exists('verify_2fa_code')) {
    function verify_2fa_code($secret, $code)
    {
        $ga = new PHPGangsta_GoogleAuthenticator();
        return $ga->verifyCode($secret, $code, 2);
    }
}
