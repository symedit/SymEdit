<?php

namespace Isometriks\Bundle\StylizerBundle\Dumper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Bundle\AsseticBundle\FilterManager;
use Isometriks\Bundle\StylizerBundle\Injector\InjectorInterface;
use Isometriks\Bundle\StylizerBundle\Loader\Loader;

class Dumper
{
    private $container;
    private $injectors;
    private $command;
    private $manager;

    public function __construct(ContainerInterface $container, FilterManager $manager, Command $command, array $injectors = array())
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->injectors = $injectors;
        $this->command = $command;

        /**
         * Setup command
         */
        $definition = $this->command->getDefinition();
        $definition->addOption(new InputOption('verbose'));
        $definition->addOption(new InputOption('env'));
        $definition->addArgument(new \Symfony\Component\Console\Input\InputArgument('env'));
    }

    public function dump()
    {
        $input = new ArrayInput(array('env' => 'prod'), $this->command->getDefinition());
        $output = new NullOutput();

        $code = $this->command->run($input, $output);

        return $code;
    }

    /**
     * Injects all the variables
     */
    public function inject(array $variables)
    {
        foreach($this->injectors as &$injector){
            if(is_string($injector)){
                $injector = $this->container->get($injector);

                if(!$injector instanceof InjectorInterface){
                    throw new \Exception(sprintf('Your injector must implement InjectorInterface, %s given', get_class($injector)));
                } else {
                    $injector->setFilterManager($this->manager);
                }
            }

            $injector->inject($variables);
        }
    }
}