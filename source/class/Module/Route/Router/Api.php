<?php

namespace Planck\Extension\Tool\Module\Route\Router;





use Planck\Exception;
use Planck\Extension\Tool\ImageUploader;
use Planck\Extension\Tool\Module\I18n\Controller\I18n;
use Planck\Routing\Route;
use Planck\Routing\RouteDescriptor;
use Planck\Routing\Router;

class Api extends Router
{


    public function registerRoutes()
    {



        $this->get('get-routes', '`/tool/route/get-routes`', function() {

            $routes = $this->getApplication()->getRoutes();


            $descriptors = [];
            foreach ($routes as $routeName => $route) {
                if($route->hasDescriptor()) {
                    $descriptors[$routeName] = $route->getDescriptor()->jsonSerialize();
                }
                else {
                    $descriptor = new RouteDescriptor();
                    $descriptor->setRoute($route);
                    $descriptors[$routeName] = $descriptor->jsonSerialize();
                }

                $descriptors[$routeName]['canonicalURL'] = $this->getApplication()->buildRoute('extension-route', array(
                    $route
                ));



            }


            echo json_encode(
                $descriptors
            );

        })->json()
            ->setBuilder('/tool/route/get-routes')
            ->setDescriptor(new RouteDescriptor(array(
                'label' => \Planck\Extension\Tool\Helper\I18n::localize('Listing des routes'),
                'description' => \Planck\Extension\Tool\Helper\I18n::localize('Liste et décrit les routes disponibles'),
            )))
        ;



        $this->all('dump-request', '`/tool/route/dump-request`', function () {

            echo json_encode(array(
                'post' => $this->post(),
                'get' => $this->get()
            ));


        })->json();


        $this->all('call', '`/tool/route/call`', function () {

            $data = $this->data();


            if(empty($data['route'])) {
                echo json_encode(false);    //a bit ugly
                return;
            }

            $route = $this->application->getRouteByFingerPrint($data['route']);


            if($route) {

                $request = $this->request;

                $route->setParameters($data);
                $route->setRequest($request);
                $route->execute();


                $output = $route->getOutput();



                echo $output;

                return;
            }



            echo json_encode(false);    //a bit ugly
        })->json();










    }


}
