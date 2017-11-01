<?php

if(!function_exists('storage_path')) {
    function storage_path($var)
    {
        switch ($var) {
            case 'cache':
                return __DIR__ . '/../../cache';
        }
    }
}
