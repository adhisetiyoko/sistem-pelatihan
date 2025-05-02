<?php
if (!function_exists('is_menu_active')) {
    function is_menu_active($segment, $current_segment) {
        return $segment === $current_segment ? 'active' : '';
    }
}