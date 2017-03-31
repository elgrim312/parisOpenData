<?php
/**
 * Created by PhpStorm.
 * User: elgrim312
 * Date: 31/03/2017
 * Time: 10:21
 */

namespace ApiBundle\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class GetDataService
{
    function __construct()
    {
        $this->url = "https://opendata.paris.fr/api/records/1.0/search/?dataset=utilisations_mensuelles_des_hotspots_paris_wi-fi";
    }

    /**
     * @param int $row
     * @param array $facets
     * @return mixed
     */
    public function RequestOpenData($row = 10, array $facets, $date = null)
    {
        $uri = $this->url."&row=".$row;

        foreach ($facets as $facetKey => $facetValue) {
            $uri .= "&facet=".$facetValue;
        }

        if ($date !== null) {
            $refineDate = \DateTime::createFromFormat('Y-m-d', $date);
            $uri .= "&refine.start_time=".$refineDate;
        }
        dump($uri);
        $client = new Client(
            [
                'timeout' => 4.0
            ]
        );
        $request = new Request('GET', $uri);
        return $client->send($request, ['Content-Type' => 'application/json'])->getBody()->getContents();
    }
}
