<?php

namespace QuickBetOnline\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;

/**
 * Class ErrorController - showing appropriate pages for different errors
 * @package QuickBetOnline\Controllers
 */
class ErrorController extends BaseController
{
    public function exceptionAction(FlattenException $exception, Request $request)
    {
        $msg = 'Something went wrong!';

        //if ajax, return json response
        if($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'message' => $msg,
                'status' => $exception->getStatusCode()
            ]);

        } else {
            //open different templates accordingly
            switch ($exception->getStatusCode()) {
                case '404':
                    return $this->template->render('errors/400.html.twig', array('msg' => $msg));
                case '500':
                    return $this->template->render('errors/500.html.twig', array('msg' => $msg));
            }
        }
    }
}