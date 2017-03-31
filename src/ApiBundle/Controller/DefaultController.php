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
        $parser = $this->get('api.service.parse_data');
        die(dump($parser->parseBrowsers()));
        return $this->render(
            'default/index.html.twig',
            [
                'browsers' => $browsers,
            ]
        );

    }
}
