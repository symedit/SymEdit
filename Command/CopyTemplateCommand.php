<?php

/*
 * This file is part of SymEdit
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 * 
 */

namespace Isometriks\Bundle\SymEditBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument; 
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption; 

class CopyTemplateCommand extends ContainerAwareCommand
{
    private $finder; 
    private $fs; 
    private $params; 
    private $overwrite; 
    
    protected function configure()
    {
        $this
            ->setName('symedit:templates:copy')
            ->addArgument('bundle', InputArgument::OPTIONAL, 'Optional Bundle to Copy From')
            ->addOption('overwrite', null, InputOption::VALUE_NONE, 'Overwrite without asking' )
            ->setDescription('Copy base templates from SymEdit to Host Bundle, or if Bundle Name is supplied, copy from there.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog'); 
        
        $source_bundle = $input->getArgument('bundle'); 
        if($not_first = !$source_bundle){
            $source_bundle = 'IsometriksSymEditBundle'; 
        }
        
        // Ask to overwrite templates
        $this->overwrite = $input->getOption('overwrite') || $dialog->askConfirmation($output, '<question>Overwite Templates if they exist?</question>', false);

        $this->fs      = $this->getContainer()->get('filesystem'); 
        $this->finder  = $this->getContainer()->get('isometriks_sym_edit.finder.resource_finder'); 
        $dest          = rtrim($this->finder->getBundleDir(),'/');
        
        // Iterate through parent skeletons as well, if explicitly set, use the first one found. 
        $parents = $this->finder->getBundleDir('IsometriksSymEditBundle', !$not_first); 
        
        if(!is_array($parents)){
            $parents = array($parents); 
        } else {
            $parents = array_reverse($parents); 
        }

        $bundle = $this->finder->getBundle(); 
        $namespace = $this->finder->getBundleNamespace(); 
        
        $this->params = array(
            'asset_dir'      => strtolower(substr($bundle, 0, strlen($bundle)-6)), // Strip 'Bundle' from the end.
            'bundle'         => $bundle, 
            'namespace'      => $namespace,
            'namespace_name' => strtolower(str_replace('\\','_',$namespace)), 
        ); 
        
        foreach($parents as $parent_dir){
            $this->copySkeleton($parent_dir, $dest);
        }
 
    }
    
    private function copySkeleton($bundle_dir, $dest)
    {
        $skeleton      = sprintf('%s/Resources/skeleton', rtrim($bundle_dir,'/')); 
        $skel_len      = strlen($skeleton);         
        
        if(!is_dir($skeleton)){
            return; 
        }
        
        echo 'Copying: ' . $skeleton . "\n\n"; 
        
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($skeleton)); 
        $iterator->setFlags(\RecursiveDirectoryIterator::SKIP_DOTS);
        
        foreach($iterator as $path){
            if(strpos($path, '.svn') !== false || strpos($path, '.git') !== false){
                continue; 
            }
            
            $dest_path = $dest.substr($path, $skel_len);
            
            if(!file_exists($dest_path) || $this->overwrite){
                $this->fs->copy($path, $dest_path, $this->overwrite); 
                $this->replaceVars($dest_path, $this->params); 
            }
        }        
    }
    
    protected function replaceVars($file, array $params = array())
    {
        if(!is_file($file) || !is_writable($file)){
            throw new \Exception(sprintf('"%s" is not a file, or is not writable', $file)); 
        }
        
        $contents = file_get_contents($file); 
        
        // If it has no replacements, just exit, no need to write the file again. 
        if(strpos($contents, '{{{') === false){
            return; 
        }
        
        $contents = preg_replace_callback('#\{\{\{[[:space:]]*([[:alpha:]_]+)[[:space:]]*\}\}\}#', function($matches) use ($params){
            return isset($params[$matches[1]]) ? $params[$matches[1]] : $matches[0]; 
        }, $contents); 
        
        file_put_contents($file, $contents); 
    }
}