<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Publisher;
use Illuminate\Http\Request;

class CrawlController extends Controller
{
    private function getContent($domain_name, $is_app)
    {
        if (substr($domain_name, -1) != '/') {
            $domain_name .= '/';
        }

        $path = $is_app
            ? 'app-ads.txt'
            : 'ads.txt';

        try {

            $ads = file($domain_name . $path);
            return true;

        } catch (\Exception $exception) {

            return false;

        }
    }

    public function run($publisher_id)
    {
        $publisher = Publisher::find($publisher_id)->name;

        $domains = Domain::with('entries')
            ->where('publisher_id', $publisher_id)
            ->get(['name', 'ns_ads', 'ns_app_ads'])
            ->toArray();

        foreach ($domains as &$d) {

            if ($d['ns_ads']) {

                $d['ads'] = $this->getContent($d['name'], false);

            }

            if ($d['ns_app_ads']) {

                $d['app_ads'] = $this->getContent($d['name'], false);

            }

        }

        return response($domains);
    }
}
