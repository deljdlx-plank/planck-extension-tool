<?php

namespace Planck\Extension\Tool\Module\Route\Router;





use Planck\Extension\Tool\ImageUploader;
use Planck\Routing\Route;
use Planck\Routing\Router;

class Api extends Router
{


    public function registerRoutes()
    {



        $this->get('get-routes', '`/tool/route/get-routes`', function() {

            $routes = $this->getApplication()->getRoutes();
            echo json_encode(
                array_keys($routes)
            );

        })->json()

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
