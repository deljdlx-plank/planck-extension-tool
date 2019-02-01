<?php

namespace Planck\Extension\Tool\Module\Asset\Router;



use Planck\Extension\Tool\Module\Asset\Controller\LocalCSSFileSender;
use Planck\Extension\Tool\Module\Asset\Controller\LocalJavascriptFileSender;
use Planck\Router;
use Planck\ModuleResourceLoader;



class Api extends Router
{


    public function registerRoutes()
    {


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
