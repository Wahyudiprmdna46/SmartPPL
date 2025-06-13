<?php
/**
 *  File  : app/helpers.php
 *  Tujuan: menampung fungsi‑fungsi global buatan sendiri
 */

if (!function_exists('public_path')) {
    /**
     * Override helper public_path agar menunjuk ke folder public_html
     */
    function public_path($path = '')
    {
        // ganti "public_html" jika nama folder publicmu berbeda
        return base_path('public_html' . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }
}
