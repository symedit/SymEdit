<?php

namespace Isometriks\Bundle\StylizerBundle\Command; 

use Symfony\Bundle\AsseticBundle\Command\DumpCommand as BaseCommand; 
use Symfony\Component\Console\Input\InputInterface; 
use Symfony\Component\Console\Output\OutputInterface; 

class DumpCommand extends BaseCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stylizer = $this->getContainer()->get('isometriks_stylizer.stylizer'); 
        $stylizer->inject(); 
        
        parent::execute($input, $output); 
    }
}