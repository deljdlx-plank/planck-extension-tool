<?php
namespace Planck\Extension\Tool\Module\I18n\Controller;

use Planck\Controller;

class I18n extends Controller
{

    public function getPackage($packageName, $localization = null)
    {

        if(!$localization) {
            $localization = \Planck\Application::getInstance()->get('default-lang');
        }

        $file = $this->application->get('lang-filepath-root').'/'.$localization.'/'.$packageName.'.php';


        if(is_file($file)) {
            return include($file);
        }
        return array();
    }

    public function getAllPackages($localization = null)
    {
        if(!$localization) {
            $localization = $this->application->get('default-lang');
        }

        $dir = opendir($this->application->get('lang-filepath-root').'/'.$localization);

        $packages = array();

        while($file = readdir($dir)) {
            if($file !='..' && $file !='.') {
                $packageName = str_replace('.php', '', $file);
                $packages[$packageName] = $this->getPackage($packageName, $localization);
            }

        }

        closedir($dir);

        return $packages;

    }

}



