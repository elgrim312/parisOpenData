<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $openData = $this->get('api.service.get_data_service');
        $res = $openData->RequestOpenData(10, ['os' => 'os']);
        return $this->render('ApiBundle:Default:index.html.twig');
    }
}
