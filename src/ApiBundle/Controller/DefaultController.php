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
        $data = $this->get('api.service.get_data_service')->RequestOpenData(1, [
            0 => 'browser',
            1 => 'os',
            2 => 'langue',
            3 => 'device'

        ]);
        $parser = $this->get('api.service.parse_data');

        $browsers = $parser->parseFacet($data, 'browser', 0.02);
        $oss = $parser->parseFacet($data, 'os', 0.01);
        $languages = $parser->parseFacet($data, 'langue', 0.01);
        $devices = $parser->parseFacet($data, 'device', 0.008);
        return $this->render(
            '@Api/Default/index.html.twig',
            [
                'datasets' => [
                    'browsers' => $browsers,
                    'oss' => $oss,
                    'languages' => $languages,
                    'devices' => $devices
                ]
            ]
        );

    }
}
