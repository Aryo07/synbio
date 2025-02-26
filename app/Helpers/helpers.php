<?php
if  (! function_exists('moneyFormat')) {
    /**
     * Format number to money format
     *
     * @param int $value
     * @return string
     */
    function moneyFormat($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }
}
