<?php
namespace QuickBetOnline\Application\Listeners;

use QuickBetOnline\Controllers\BaseController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerArgumentsEvent;

class ControllerListener implements EventSubscriberInterface
{

    function onFilterControllerArguments(FilterControllerArgumentsEvent $event)
    {
    }

    function onControllerCall($event) {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof BaseController) {
            $controller[0]->setContainer(\QuickBetOnline\Application\Container::GetInstance()->getContainer());
        }
    }

    function onCheckContainer($event) {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof BaseController && null === $controller[0]->getTemplate()) {
            throw new \LogicException('No templating engine set');
        }
    }


    public static function getSubscribedEvents()
    {
       return [
           KernelEvents::CONTROLLER_ARGUMENTS  => 'onFilterControllerArguments',
           KernelEvents::CONTROLLER  => [
                array('onControllerCall', 10),
                array('onCheckContainer', -10),
            ],
       ];
    }
}