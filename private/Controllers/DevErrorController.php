<?php

namespace QuickBetOnline\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;

/**
 * Class DevErrorController - used for development only
 * @package QuickBetOnline\Controllers
 */
class DevErrorController extends BaseController
{
    public function exceptionAction(FlattenException $exception, Request $request)
    {
        $msg = 'Something went wrong! ('.$exception->getMessage().')';

        //if ajax, return json response
        if($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'message' => $msg,
                'status' => $exception->getStatusCode()
            ]);

        } else {
            switch ($exception->getStatusCode()) {
                case '404':
                    return $this->template->render('errors/400.html.twig', array('msg' => $exception->getMessage()));
                case '500':
                    return $this->template->render('errors/500.html.twig', array('msg' => $exception->getMessage()));
            }
        }
    }
}