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
            ->get('name')
            ->toArray();

        foreach ($domains as $i => $d) {

            try {

                $ads = file($d['name'] . 'ads.txt');
                $domains[$i]['ads'] = true;

            } catch (\Exception $exception) {

                $domains[$i]['ads'] = false;

            }

            try {

                $app_ads = file_get_contents($d['name'] . 'app-ads.txt');
                $domains[$i]['app-ads'] = true;

            } catch (\Exception $exception) {

                $domains[$i]['app-ads'] = false;

            }

        }

        return response($domains);
    }
}
