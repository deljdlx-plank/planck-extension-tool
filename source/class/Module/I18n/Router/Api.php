<?php

namespace Planck\Extension\Tool\Module\I18n\Router;




use Planck\Routing\Router;
use Planck\ModuleResourceLoader;



class Api extends Router
{


    public function registerRoutes()
    {



        $this->get('i18n-api-get-package', '`/tool/i18n/api/get-package`', function () {
            $packageName = $this->request->get('package');
            $lang = $this->request->get('lang');

            $controller = new \Planck\Extension\Tool\Module\I18n\Controller\I18n($this->application);

            echo json_encode($controller->getPackage($packageName, $lang));
        })->json();


        $this->get('i18n-api-get-all-packages', '`/tool/i18n/api/get-all-packages`', function () {


            $lang = $this->request->get('lang');
            $jsonp = $this->request->get('callback');

            $controller = new \Planck\Extension\Tool\Module\I18n\Controller\I18n($this->application);

            echo $jsonp.'('.json_encode($controller->getAllPackages($lang)).');';

        })->javascript();


    }


}
