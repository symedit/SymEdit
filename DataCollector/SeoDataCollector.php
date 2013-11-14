<?php

namespace Isometriks\Bundle\SeoBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoDataCollector extends DataCollector
{
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if (!$request->attributes->has('_seo')) {
            return;
        }
        
        $seo = $request->attributes->get('_seo');
        $this->data = $seo->getSeo();
        
        $blankError = array('title', 'description');
        $total = 0;
        
        foreach ($blankError as $blankKey) {
            if (empty($this->data[$blankKey])) {
                $total++;
            }
        }
        
        $this->data['errors'] = $total;
    }
    
    public function getData()
    {
        return $this->data;
    }

    public function getName()
    {
        return 'isometriks_seo';
    }
}