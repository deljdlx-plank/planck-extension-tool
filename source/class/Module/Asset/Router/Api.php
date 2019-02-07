<?php

namespace Planck\Extension\Tool\Module\Asset\Router;



use Planck\Extension\Tool\Module\Asset\Controller\LocalCSSFileSender;
use Planck\Extension\Tool\Module\Asset\Controller\LocalJavascriptFileSender;
use Planck\Helper\File;
use Planck\Router;
use Planck\ModuleResourceLoader;



class Api extends Router
{


    public function registerRoutes()
    {


        $this->get('tool-asset-api-get-extension-javascript', '`/tool/asset/api/get-extension-javascript`', function () {

            $extensionName = $this->get('extension');
            $extension = $this->application->getExtension($extensionName);

            $javascript = $this->get('javascript');

            $javascript = File::sanitizePath($javascript);

            $file = realpath($extension->getAssetsFilepath().$javascript);
            if(is_file($file)) {
                echo file_get_contents($file);
            }
        })->contentType('text/javascript');


        $this->get('tool-asset-api-get-extension-css', '`/tool/asset/api/get-extension-css`', function () {



            $extensionName = $this->get('extension');
            $extension = $this->application->getExtension($extensionName);




            $css = $this->get('css');

            $css = File::sanitizePath($css);

            $file = realpath($extension->getAssetsFilepath().$css);
            if(is_file($file)) {
                echo file_get_contents($file);
            }
        })->contentType('text/css');






        $this->get('tool/get/javascript', '`/tool/api-get-javascript`', function () {

            $hash = $this->request->get('javascript');
            $controller = new LocalJavascriptFileSender($this->application);
            echo $controller->getJavascript($hash);


        })->contentType('text/javascript');







        $this->get('tool/get/css', '`/tool/api-get-css`', function () {

            $hash = $this->request->get('css');

            $controller = new LocalCSSFileSender($this->application);
            echo $controller->getCSS($hash);


        })->contentType('text/css');


    }


}
