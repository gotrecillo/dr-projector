<?php

if ( ! function_exists('rsearch')) {
    function rsearch($folder, $pattern)
    {
        $dir      = new RecursiveDirectoryIterator($folder);
        $ite      = new RecursiveIteratorIterator($dir);
        $files    = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
        $fileList = array();
        foreach ($files as $file) {
            $fileList = array_merge($fileList, $file);
        }

        return $fileList;
    }
}

if ( ! function_exists('rglob')) {
    function rglob($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, rglob($dir . '/' . basename($pattern), $flags));
        }

        return $files;
    }
}

