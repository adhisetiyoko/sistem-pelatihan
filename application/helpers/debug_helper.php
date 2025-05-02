<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('dd')) {
    /**
     * Dump dan die, seperti Laravel
     * Digunakan untuk debugging
     */
    function dd(...$vars)
    {
        echo '<pre style="background:#222;color:#0f0;padding:10px;border-radius:5px">';
        foreach ($vars as $var) {
            var_dump($var);
            echo "\n";
        }
        echo '</pre>';
        die;
    }
}
