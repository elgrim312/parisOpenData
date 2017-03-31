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
        // replace this example code with whatever you need
        $rawData = file_get_contents(
            'https://opendata.paris.fr/api/records/1.0/search/?dataset=utilisations_mensuelles_des_hotspots_paris_wi-fi&rows=10&facet=browser'
        );
        $jsonData = json_decode($rawData, true);
        $browsers = $this->browserShares($jsonData);

        return $this->render(
            'default/index.html.twig',
            [
                'browsers' => $browsers,
            ]
        );
    }

    private function browserShares($data)
    {
        $browsers = $data['facet_groups'][0]['facets'];

        // Get the total number of values
        $total = 0;
        foreach ($browsers as $browser) {
            $total += $browser['count'];
        }

        // Get the main browsers and categorizes the others as 'other'
        $percentageLimit = $total * 0.02;
        $filteredBrowsers = [];
        $filteredBrowsers[] = [
            'name' => 'Others',
            'count' => 0
        ];
        foreach ($browsers as $browser) {
            if ($browser['name'] === 'Other' || $browser['name'] === 'NULL') {
                $filteredBrowsers[0]['count'] += $browser['count'];
            } elseif ($browser['count'] >= $percentageLimit) {
                $filteredBrowsers[] = [
                    'name' => $browser['name'],
                    'count' => $browser['count']
                ];
            } else {
                $filteredBrowsers[0]['count'] += $browser['count'];
            }
        }

        return $filteredBrowsers;
    }
}
