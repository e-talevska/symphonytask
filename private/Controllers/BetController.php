<?php
namespace QuickBetOnline\Controllers;

use Symfony\Component\HttpFoundation\Request;

class BetController extends BaseController
{
    /**
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        //get what we have in odds table in order to show in view
        $odds = \QuickBetOnline\Models\Odd::all();

        return $this->template->render('bet/convert.html.twig', array('odds' => $odds));
    }
}