<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // Core Bundles
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),

            // SymEdit Bundles
            new SymEdit\Bundle\ResourceBundle\SymEditResourceBundle(),
            new SymEdit\Bundle\StylizerBundle\SymEditStylizerBundle(),
            new SymEdit\Bundle\BlogBundle\SymEditBlogBundle(),
            new SymEdit\Bundle\UserBundle\SymEditUserBundle(),
            new SymEdit\Bundle\WidgetBundle\SymEditWidgetBundle(),
            new SymEdit\Bundle\CoreBundle\SymEditBundle($this),
            new SymEdit\Bundle\SeoExportBundle\SymEditSeoExportBundle(),
            new SymEdit\Bundle\SitemapBundle\SymEditSitemapBundle(),
            new SymEdit\Bundle\SeoBundle\SymEditSeoBundle(),
            new SymEdit\Bundle\MediaBundle\SymEditMediaBundle(),
            new SymEdit\Bundle\ThemeBundle\SymEditThemeBundle(),
            new SymEdit\Bundle\MailChimpBundle\SymEditMailChimpBundle(),
            new SymEdit\Bundle\AnalyticsBundle\SymEditAnalyticsBundle(),
            new SymEdit\Bundle\ShortcodeBundle\SymEditShortcodeBundle(),
            new SymEdit\Bundle\CacheBundle\SymEditCacheBundle(),
            new SymEdit\Bundle\MenuBundle\SymEditMenuBundle(),
            new SymEdit\Bundle\EventsBundle\SymEditEventsBundle(),
            new SymEdit\Bundle\FormBuilderBundle\SymEditFormBuilderBundle(),
            new SymEdit\Bundle\SettingsBundle\SymEditSettingsBundle(),
            new SymEdit\Bundle\ApiBundle\SymEditApiBundle(),

            // Isometriks Bundles
            new Isometriks\Bundle\SpamBundle\IsometriksSpamBundle(),
            new Isometriks\Bundle\JsonLdDumperBundle\IsometriksJsonLdDumperBundle(),

            // Others
            new FOS\RestBundle\FOSRestBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
            new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),

            new Sylius\Bundle\ResourceBundle\SyliusResourceBundle(),
            new winzou\Bundle\StateMachineBundle\winzouStateMachineBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            new JMS\AopBundle\JMSAopBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle(),

            // Doctrine last so mappings work properly
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }
    
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
