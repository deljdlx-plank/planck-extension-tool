<?php

namespace Planck\Extension\Tool;

class ImageUploader
{





    public function saveImageFromBase64($imageData, $destination, $fileName, $convertToPNG = true)
    {

        $coverExtension = preg_replace('`.*?image/(.*?);.*`', '$1', $imageData);
        if ($coverExtension == 'jpeg') {
            $coverExtension = 'jpg';
        }


        $imageData = preg_replace('`(.*?,)`', '', $imageData);
        $imageBinary = base64_decode($imageData);

        if (!$imageBinary) {
            return false;
        }


        $fileNameWithExtesion = $fileName . '.' . $coverExtension;

        $imagePath = $destination;

        file_put_contents($imagePath . '/' . $fileNameWithExtesion, $imageBinary);

        if ($coverExtension != 'png' && $convertToPNG) {
            imagepng(
                imagecreatefromstring(file_get_contents($imagePath . '/' . $fileNameWithExtesion)),
                $imagePath . '/' . $fileName . '.png'
            );
            unlink($imagePath . '/' . $fileNameWithExtesion);
            return $imagePath . '/' . $fileName . '.png';
        }

        return $imagePath . '/' . $fileNameWithExtesion;


    }



    public function saveImageFromURL($url, $destination, $fileName, $convertToPNG = true)
    {


        $data = getimagesize($url);


        if (!$data) {
            return false;
        }



        $imageBuffer = file_get_contents($url);
        $extension = preg_replace('`.*?/(.*)$`', '$1', $data['mime']);
        if ($extension == 'jpeg') {
            $extension == 'jpg';
        }


        $fileNameWithExtension = $fileName . '.' . $extension;


        file_put_contents($destination . '/' . $fileNameWithExtension, $imageBuffer);


        if ($extension != 'png' && $convertToPNG) {
            imagepng(
                imagecreatefromstring(file_get_contents($destination . '/' . $fileNameWithExtension)),
                $destination . '/' . $fileName . '.png'
            );
            unlink($destination . '/' . $fileNameWithExtension);

            return $destination . '/' . $fileName . '.png';
        }

        return $destination . '/' . $fileNameWithExtension;

    }


}
