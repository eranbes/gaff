<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Publisher;
use Illuminate\Http\Request;

class CrawlController extends Controller
{
    public function run($publisher_id)
    {
        $publisher = Publisher::find($publisher_id)->name;

        $domains = Domain::where('publisher_id', $publisher_id)
            ->get(['name', 'ns_ads', 'ns_app_ads'])
            ->toArray();

        foreach ($domains as $i => $d) {

            if ($d['ns_ads']) {
                try {

                    $ads = file($d['name'] . 'ads.txt');
                    $domains[$i]['ads'] = true;

                } catch (\Exception $exception) {

                    $domains[$i]['ads'] = false;

                }
            }

            if ($d['ns_app_ads']) {
                try {

                    $app_ads = file_get_contents($d['name'] . 'app-ads.txt');
                    $domains[$i]['app_ads'] = true;

                } catch (\Exception $exception) {

                    $domains[$i]['app_ads'] = false;

                }
            }

        }

        return response($domains);
    }
}
