<?php

namespace Planck\Extension\Tool\Module\Asset\Controller;


use Planck\Controller;

class LocalJavascriptFileSender extends Controller
{

    public function getJavascript($hash)
    {



        $cryptEngine = $this->application->get('encrypt-engine');


        $javascript = $cryptEngine->decrypt($hash);

        if(!$javascript) {
            return false;
        }


        if(is_file($javascript)) {

            return file_get_contents($javascript);
        }

        return false;
    }


}

