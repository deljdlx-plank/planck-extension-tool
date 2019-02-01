<?php

namespace Planck\Extension\Tool\Module\Asset\Controller;


use Planck\Controller;

class LocalCSSFileSender extends Controller
{

    public function getCSS($hash)
    {
        $cryptEngine = $this->application->get('encrypt-engine');



        $css = $cryptEngine->decrypt($hash);



        if(!$css) {
            return false;
        }

        $cssFile = $css;

        if(is_file($cssFile)) {
            return file_get_contents($cssFile);
        }

        return false;
    }


}

