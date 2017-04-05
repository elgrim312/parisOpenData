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
    public function parseFacet($data, $facetName, $threshold = 0)
    {
        // Get the specified facet array from the data
        $facetIndex = 0;
        $allFacets = $data['facet_groups'];
        foreach ($allFacets as $index => $value) {
            if ($value['name'] === $facetName) {
                $facetIndex = $index;
            }
        }
        $facets = $allFacets[$facetIndex]['facets'];

        // Gets the total number of values
        $total = 0;
        foreach ($facets as $facet) {
            $total += $facet['count'];
        }

        // Gets the main oss and categorizes the others as 'other'
        $limit = $total * $threshold;
        $filteredResults = [];
        $filteredResults[] = [
            'name' => 'Others',
            'count' => 0,
        ];

        foreach ($facets as $facet) {
            if (!empty($filter)) {

            }
            if ($facet['name'] === 'Other' || $facet['name'] === 'NULL') {
                $filteredResults[0]['count'] += $facet['count'];
            } elseif ($facet['count'] >= $limit) {
                $filteredResults[] = [
                    'name' => $facet['name'],
                    'count' => $facet['count'],
                ];
            } else {
                $filteredResults[0]['count'] += $facet['count'];
            }
        }

        return $filteredResults;
    }
}