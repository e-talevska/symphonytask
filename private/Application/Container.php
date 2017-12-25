<?php
namespace QuickBetOnline\Application;

use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;
use Symfony\Component\EventDispatcher;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Illuminate\Database\Capsule\Manager as Capsule;


class Container
{
    private static $oInstance;
    private $container; 

    public static function GetInstance()
    {
        // @codingStandardsIgnoreEnd
        if (self::$oInstance === null) {
            self::$oInstance = new self();
            self::$oInstance->setContainer();
        }

        return self::$oInstance;
    }

    public function getContainer()
    {
        if (self::$oInstance !== null) {
            return self::$oInstance->container;
        }

        throw new RuntimeException('No class instance');
    }

    private function setContainer()
    {
        $this->container = new DependencyInjection\ContainerBuilder();
        $this->container->register('context', Routing\RequestContext::class);
        $this->container->register('matcher', Routing\Matcher\UrlMatcher::class)
            ->setArguments(array('%routes%', new Reference('context')));

        $this->container->register('request_stack', HttpFoundation\RequestStack::class);
        $this->container->register('controller_resolver', HttpKernel\Controller\ControllerResolver::class);
        $this->container->register('argument_resolver', HttpKernel\Controller\ArgumentResolver::class);

        $this->container->register('listener.router', HttpKernel\EventListener\RouterListener::class)
            ->setArguments(array(new Reference('matcher'), new Reference('request_stack')));

        $this->container->register('listener.response', HttpKernel\EventListener\ResponseListener::class)
            ->setArguments(array('%charset%'));

        $this->container->register('listener.exception', HttpKernel\EventListener\ExceptionListener::class)
            ->setArguments(array('%exceptionHandler%'));

        $this->container->register('dispatcher', EventDispatcher\EventDispatcher::class)
            ->addMethodCall('addSubscriber', array(new Reference('listener.router')))
            ->addMethodCall('addSubscriber', array(new Reference('listener.response')))
            ->addMethodCall('addSubscriber', array(new Reference('listener.exception')));

        $this->container->register('file_system_loader', \Twig_Loader_Filesystem::class)
            ->setArguments(array('%views%'));

        $this->container->register('templating', \Twig_Environment::class)
            ->setArguments(array(new Reference('file_system_loader'), array('cache' => '%twig_cache%', 'debug' => '%twig_debug%')));

        $this->container->register('capsule', Capsule::class);
        $this->container->register('app', Application::class)
            ->setArguments(array(
                new Reference('dispatcher'),
                new Reference('controller_resolver'),
                new Reference('request_stack'),
                new Reference('argument_resolver'),
            ));
    }

    private function __construct()
    {

    }
}