<?php

namespace Planck\Extension\Tool\Module\Fixture\Router;





use Planck\Extension\Tool\ImageUploader;
use Planck\Route;
use Planck\Router;

class Api extends Router
{


    public function registerRoutes()
    {


        $this->all('call', '`/tool/fixture/get`', function () {

            $data = array();

            for($i=0; $i<10; $i++) {
                $item = array(
                    'id' => $i,
                    'name' => 'item'.$i,
                    'list' => array(
                        'sub item 0', 'sub item 1', 'sub item 2'
                    ),
                    'metadata' => array(
                        'time' => time()
                    )

                );

                $data[] = $item;
            }


            echo json_encode($data);
        })->json();










    }


}
