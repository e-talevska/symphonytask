<?php
namespace QuickBetOnline\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConversionLogController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function saveAction(Request $request)
    {
        //get the data from post
        $data = $request->request->all();

        //create new log entry in database
        $conversionLog = new \QuickBetOnline\Models\ConversionLog;
        $conversionLog->user_ip = $request->getClientIp();
        $conversionLog->data = json_encode($data);
        $conversionLog->save();

        //return json
        return new JsonResponse([
            'status' => 200
        ]);
    }
}