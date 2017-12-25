<?php

class Autoloader {
    static public function autoload($className)
    {
        // project-specific namespace prefix
        $prefix = 'QuickBetOnline\\';
        // base directory for the namespace prefix
        $base_dir = SOURCE_ROOT;

        // does the class use the namespace prefix?
        $len = strlen($prefix);
        if (strncmp($prefix, $className, $len) !== 0) {
            // no, move to the next registered autoloader
            return;
        }

        // get the relative class name
        $relative_class = substr($className, $len);

        // replace the namespace prefix with the base directory, replace namespace
        // separators with directory separators in the relative class name, append
        // with .php
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        // if the file exists, require it
        if (file_exists($file)) {
            require $file;
        }

//        $className = ltrim(str_replace('QuickBetOnline', '', $className), '\\');
//        $fileName  = '';
//        $namespace = '';
//        if ($lastNsPos = strripos($className, '\\')) {
//            $namespace = substr($className, 0, $lastNsPos);
//            $className = substr($className, $lastNsPos + 1);
//            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
//        }
//
//        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
//        $fileName = SOURCE_ROOT . $fileName;
////var_dump($fileName);exit;
//        if (file_exists($fileName)) {
//            require $fileName;
//        }
    }
//
//    static public function loader($className)
//    {
//
//        $filename = "/private" . DIRECTORY_SEPARATOR . str_replace(['symphonytask', '\\'], ['', DIRECTORY_SEPARATOR], $className) . ".php";
//        var_dump($filename,file_exists($filename));exit;
//        if (file_exists($filename)) {
//            include($filename);
//            if (class_exists($className)) {
//                return TRUE;
//            }
//        }
//        return FALSE;
//    }
//
//    static public function autoloadModel($className)
//    {
//        $filename = "private/models/" . str_replace("\\", DIRECTORY_SEPARATOR, $className) . ".php";
//        if (is_readable($filename)) {
//            require $filename;
//        }
//    }
//
//    static public function autoloadController($className)
//    {
//        $filename = "private/controllers/" . str_replace("\\", DIRECTORY_SEPARATOR, $className) . ".php";
//        var_dump(file_exists($filename));
//        if (is_readable($filename)) {
//            require $filename;
//        }
//    }
}
//spl_autoload_register('Autoloader::autoload');
//spl_autoload_register('Autoloader::autoloadModel');
//spl_autoload_register('Autoloader::autoloadController');