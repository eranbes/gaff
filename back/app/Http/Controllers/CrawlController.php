<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Publisher;
use Illuminate\Http\Request;

class CrawlController extends Controller
{
    /**
     * @param $domain_name
     * @param bool $is_app
     * @return array|false
     */
    private function getContent($domain_name, bool $is_app)
    {
        if (substr($domain_name, -1) != '/') {
            $domain_name .= '/';
        }

        $path = $is_app
            ? 'app-ads.txt'
            : 'ads.txt';

        try {

            $ads = file($domain_name . $path);

            // удаляем ненужные символы
            foreach ($ads as &$file_str) {

                $pos = strpos($file_str, '#');
                if ($pos !== false) $file_str = substr($file_str, 0, $pos);

                $file_str = rtrim($file_str);

                $file_str = preg_replace('/[ \t]+/', ' ', $file_str);

            }

            return $ads;

        } catch (\Exception $exception) {

            return false;

        }
    }

    private function compareEntries(array $needle, array $remote, bool $is_app)
    {
        foreach ($needle as &$n) {

            if ($is_app != $n['is_app']) continue;

            $n['status'] = 'N/A';

            foreach ($remote as $r) {

                if (is_int(strripos($r, $n['name']))) $n['status'] = 'Available';

            }

        }

        return $needle;
    }

    public function run($publisher_id)
    {
        $publisher = Publisher::find($publisher_id)->name;

        $domains = Domain::with('entries')
            ->where('publisher_id', $publisher_id)
            ->get()
            ->toArray();

        foreach ($domains as &$d) {

            if ($d['ns_ads']) {

                if ($d['ads'] = $this->getContent($d['name'], false)) {

                    $d['entries'] = $this->compareEntries($d['entries'], $d['ads'], false);

                }

            }

            if ($d['ns_app_ads']) {

                if ($d['app_ads'] = $this->getContent($d['name'], false)) {

                    $d['entries'] = $this->compareEntries($d['entries'], $d['app_ads'], true);

                }

            }

        }

        return response($domains);
    }
}
