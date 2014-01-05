<?php

namespace Isometriks\Bundle\SettingsBundle\Loader; 

class YamlFilesLoader extends FilesLoader 
{
    protected function getFileLoaderInstance($file)
    {
        return new YamlFileLoader($file); 
    }
}