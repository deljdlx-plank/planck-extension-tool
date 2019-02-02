<?php

namespace Planck\Extension\Tool\Helper;


class I18n
{

    public static function localize($string, $key = null, $package = 'main', $localization = null)
    {

        static $items;


        if(!$localization) {
            $localization = \Planck\ApplicationRegistry::getInstance()->get('default-lang');
        }


        if(!$items) {
            $items = array();
        }

        if(!array_key_exists($package, $items)) {
            $items[$package] = static::getI18NPackage($package, $localization);
        }

        if($key && array_key_exists($key, $items[$package])) {
            return $items[$package][$key];
        }

        if(array_key_exists($string, $items[$package])) {
            return $items[$package][$string];
        }

        return $string;
    }


    public static function getI18NAllPackages($localization = null)
    {
        if(!$localization) {
            $localization = \Planck\ApplicationRegistry::getInstance()->get('default-lang');
        }

        $dir = opendir(\Planck\ApplicationRegistry::getInstance()->get('lang-filepath-root').'/'.$localization);

        $packages = array();

        while($file = readdir($dir)) {
            if($file !='..' && $file !='.') {
                $packageName = str_replace('.php', '', $file);
                $packages[$packageName] = getI18NPackage($packageName, $localization);
            }

        }

        closedir($dir);

        return $packages;

    }


    public static function getI18NPackage($packageName, $localization = null)
    {

        if(!$localization) {
            $localization = \Planck\ApplicationRegistry::getInstance()->get('default-lang');
        }

        $file = \Planck\ApplicationRegistry::getInstance()->get('lang-filepath-root').'/'.$localization.'/'.$packageName.'.php';


        if(is_file($file)) {
            return include($file);
        }
        return array();
    }
}
