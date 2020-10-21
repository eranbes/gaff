<?php

namespace App\Http\Controllers;

use App\Models\Crawl;
use App\Models\Domain;
use App\Models\Publisher;
use Illuminate\Http\Request;

class CrawlController extends Controller
{
    /**
     * @param string $domain_name
     * @param bool $is_app
     * @param array $needle_entries
     * @return array
     */
    private function getContent(string $domain_name, bool $is_app, array $needle_entries)
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

            foreach ($needle_entries as &$n) {

                if ($is_app != $n['is_app']) continue;

                $n['is_available'] = false;

                foreach ($ads as $a) {

                    if (is_int(strripos($a, $n['name']))) $n['is_available'] = true;

                }

            }

            return [true, $needle_entries];

        } catch (\Exception $exception) {

            return [false, $needle_entries];

        }
    }

    public function run($publisher_id)
    {
        $domains = Domain::with('entries')
            ->where('publisher_id', $publisher_id)
            ->get()
            ->toArray();

        foreach ($domains as &$d) {

            if ($d['entries']) {

                if ($d['ns_ads']) {

                    [$d['ads'], $d['entries']] = $this->getContent($d['name'], false, $d['entries']);

                }

                if ($d['ns_app_ads']) {

                    [$d['app_ads'], $d['entries']] = $this->getContent($d['name'], true, $d['entries']);

                }

            }

            foreach ($d['entries'] as $e) {

                $e['is_available'] = (int)@$e['is_available'];

                if ($crawl = Crawl::where('domain_id', $e['domain_id'])
                    ->where('is_app', $e['is_app'])
                    ->where('entry_name', $e['name'])
                    ->orderBy('updated_at', 'desc')
                    ->first()) {

                    $prev_status = $crawl->status_id;

                    // 0 - N/A, 1 - ADDED, 2 - DELETED

                    // 0 + false = 0 - не обновлять
                    // 0 + true = 1
                    // 1 + false = 2
                    // 1 + true = 1 - не обновлять
                    // 2 + false = 2 - не обновлять
                    // 2 + true = 1

                    if ($prev_status == 2) $prev_status = 0;
                    if ($prev_status == $e['is_available']) continue;

                    $crawl->status_id = $prev_status + 1;
                    $crawl->save();

                } else {

                    Crawl::create([
                        'domain_id' => $e['domain_id'],
                        'is_app' => $e['is_app'],
                        'entry_name' => $e['name'],
                        'status_id' => $e['is_available']
                    ]);

                }

            }

        }

        return response($domains);
    }

    public function index()
    {
        $publishers = Publisher::pluck('name', 'id')
            ->toArray();

        $domains = Domain::with('entries')
            ->get()
            ->toArray();

        foreach ($domains as &$d) {

            $d['publisher'] = $publishers[$d['publisher_id']];

            $d['ads'] = $d['app_ads'] = [];

            foreach ($d['entries'] as $e) {

                if ($crawl = Crawl::where('domain_id', $e['domain_id'])
                    ->where('is_app', $e['is_app'])
                    ->where('entry_name', $e['name'])
                    ->orderBy('updated_at', 'desc')
                    ->first()
                    ->toArray()) {

                    if ($e['is_app']) {
                        $d['app_ads'][] = $crawl;
                    } else {
                        $d['ads'][] = $crawl;
                    }

                }

            }

        }

        return response($domains);
    }
}
