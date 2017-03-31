<?php
/**
 * Created by PhpStorm.
 * User: elgrim312
 * Date: 31/03/2017
 * Time: 13:25
 */

namespace ApiBundle\Service;
use ApiBundle\Service\GetDataService;

class ParseService
{
    /**
     * @param $data
     * @return array
     */
    public function parseBrowsers()
    {
        $dataService = new GetDataService();
        $data = $dataService->RequestOpenData(1, ['browser']);

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
            'count' => 0,
        ];
        foreach ($browsers as $browser) {
            if ($browser['name'] === 'Other' || $browser['name'] === 'NULL') {
                $filteredBrowsers[0]['count'] += $browser['count'];
            } elseif ($browser['count'] >= $percentageLimit) {
                $filteredBrowsers[] = [
                    'name' => $browser['name'],
                    'count' => $browser['count'],
                ];
            } else {
                $filteredBrowsers[0]['count'] += $browser['count'];
            }
        }

        return $filteredBrowsers;
    }
}