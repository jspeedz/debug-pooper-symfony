<?php
use Symfony\Component\VarDumper\VarDumper;

if(!function_exists('💩')) {
    function 💩($var) {
        foreach(func_get_args() as $var) {
            VarDumper::dump($var);
        }
    }
}
