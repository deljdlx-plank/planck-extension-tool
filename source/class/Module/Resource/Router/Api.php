<?php

namespace Planck\Extension\Tool\Module\Resource\Router;





use Planck\Extension\Tool\ImageUploader;
use Planck\Routing\Route;
use Planck\Routing\Router;

class Api extends Router
{


    public function registerRoutes()
    {




        $this->post('upload-file', '`/tool/resource/api/upload-file`', function () {
            /*
            $files = $this->request->files();
            foreach ($files as $file) {
                $file->saveIntoPath(__DIR__);
            }
            echo json_encode($files);
            */
        })->json();







        $this->post('/tool/resource/api/upload-image', '`/tool/resource/api/upload-image`', function () {



            $data = $this->request->post();

            /*
            print_r($this->request->files());
            exit();
            */

            if(isset($data['imageURL'])) {

                $imageName = uniqid();

                $uploader = new ImageUploader();



                $imagePath = $uploader->saveImageFromURL(
                    $data['imageURL'],
                    $this->application->get('user-data-filepath-root').'/tmp',
                    $imageName

                );

                echo json_encode(array(
                    'url'=> $this->application->get('user-data-url-root').'/tmp/'.basename($imagePath),
                ));
            }



        })->json();







        $this->get('tool/resource/list', '`/tool/ressource/list`', function () {



            $url = $this->get('url');

            $routes = $this->application->getValidatedRoutes($url);
            if(empty($routes)) {
                $this->json();
                echo json_encode(false);
                return;
            }


            $descriptor = [];
            foreach ($routes as $route) {

                $descriptor[] = array(
                    'router' => get_class($route->getRouter()),
                    'routeName' => $route->getName(),
                    'extensionName'=> $route->getRouter()->getExtensionName(),
                    'moduleName' => $route->getRouter()->getModuleName()
                );
            }

            if($callback = $this->get('callback')) {
                $this->javascript();
                echo $callback.'('.json_encode($descriptor).');';
            }
            else {
                $this->json();
                echo json_encode($descriptor);

            }




        })->json();








    }


}
