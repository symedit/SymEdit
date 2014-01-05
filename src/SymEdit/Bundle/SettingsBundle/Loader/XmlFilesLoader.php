<?php

namespace SymEdit\Bundle\SettingsBundle\Loader; 

class XmlFilesLoader extends FilesLoader 
{
    protected function getFileLoaderInstance($file)
    {
        return new XmlFileLoader($file); 
    }
}