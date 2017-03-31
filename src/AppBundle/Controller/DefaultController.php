<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $parser = $this->get('api.service.parse_data');
        $parser->parseBrowsers();

        return $this->render(
            'default/index.html.twig',
            [
                'browsers' => $browsers,
            ]
        );
    }

}
