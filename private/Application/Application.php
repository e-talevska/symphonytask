<?php

namespace QuickBetOnline\Application;

use Symfony\Component\HttpKernel;

/**
 * Application class
 */
class Application extends HttpKernel\HttpKernel
{
//    protected $dispatcher;
//    protected $matcher;
//    protected $controllerResolver;
//    protected $argumentResolver;
//
//
//    public function __construct(EventDispatcher $dispatcher, UrlMatcherInterface $matcher, ControllerResolverInterface $controllerResolver, ArgumentResolverInterface $argumentResolver)
//    {
//        $this->dispatcher = $dispatcher;
//        $this->matcher = $matcher;
//        $this->controllerResolver = $controllerResolver;
//        $this->argumentResolver = $argumentResolver;
//    }
//
//    public function handle(Request $request,$type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
//    {
//        $this->matcher->getContext()->fromRequest($request);
//
//        try {
//            $request->attributes->add($this->matcher->match($request->getPathInfo()));
//
//            $controller = $this->controllerResolver->getController($request);
//            $arguments = $this->argumentResolver->getArguments($request, $controller);
//
//            $response = call_user_func_array($controller, $arguments);
//        } catch (ResourceNotFoundException $e) {
//            $response = new Response('Not Found', 404);
//        } catch (\Exception $e) {
//            $response = new Response('An error occurred', 500);
//        }
//
//        // dispatch a response event
////        $this->dispatcher->dispatch('response', new ResponseEvent($response, $request));
//
//        return $response;
//    }
}
