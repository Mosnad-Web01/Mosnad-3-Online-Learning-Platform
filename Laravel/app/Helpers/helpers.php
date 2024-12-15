<?php

if (!function_exists('secondsToHumanReadable')) {
    function secondsToHumanReadable($seconds)
    {
        $days = floor($seconds / 86400);
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        $formattedTime = '';
        if ($days > 0) {
            $formattedTime .= $days . ' days ';
        }
        if ($hours > 0) {
            $formattedTime .= $hours . ' hours ';
        }
        if ($minutes > 0) {
            $formattedTime .= $minutes . ' minutes ';
        }
        if ($seconds > 0) {
            $formattedTime .= $seconds . ' seconds';
        }

        return $formattedTime ?: '0 seconds';
    }
}
