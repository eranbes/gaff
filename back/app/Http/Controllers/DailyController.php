<?php

namespace App\Http\Controllers;

use App\Mail\StatusChanged;
use App\Models\Crawl;
use App\Models\Domain;
use App\Models\Publisher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class DailyController extends Controller
{
    public function run()
    {
        $publishers = Publisher::pluck('id');

//        $crawl = new CrawlController;
//
//        foreach ($publishers as $p) {
//
//            $crawl->run($p);
//
//        }

        $d_ids = [];

        $changed_entries = Crawl::whereDate('updated_at', Carbon::yesterday())
//        $changed_entries = Crawl::whereDate('updated_at', Carbon::today())
            ->orderBy('status_id')
            ->get()
            ->toArray();

        foreach ($changed_entries as $e) {

            if (!in_array($e['domain_id'], $d_ids)) {

                $d_ids[] = $e['domain_id'];

            }
        }

        $domains = [];

        Domain::whereIn('id', $d_ids)
            ->with(['publisher', 'assets'])
            ->get(['id', 'name', 'publisher_id'])
            ->map(function ($d) use (&$domains) {

                $domains[$d['id']]['publisher_name'] = $d['publisher']['name'];

                foreach ($d['assets'] as $a) {

                    $domains[$d['id']]['bundle_ids'][] = $a['asset_id'];

                }

            });

        $report = [
            0 => [],
            1 => [],
            2 => [],
        ];

        foreach ($changed_entries as $e) {

            $report[$e['status_id']][] = [
                'publisher_name' => $domains[$e['domain_id']]['publisher_name'],
                'is_app' => $e['is_app'],
                'entry_name' => $e['entry_name'],
                'bundle_ids' => $domains[$e['domain_id']]['bundle_ids'] ?? false,
            ];

        }

        if ($report[0] || $report[1] || $report[2]) {

            Mail::to(env('REPORTS_EMAIL'))
                ->send(new StatusChanged($report));

        }

        return response($report);
    }
}

// a.	Entries added
// i.	Publisher name
// ii.	Entries added for app-ads.txt and ads.txt
// iii.	Bundle ids associated with the entries added
//
// b.	Entries Deleted
// i.	Publisher name
// ii.	Entries deleted from app-ads.txt and ads.txt
// iii.	Bundle ids associated with the entries deleted
//
// c.	Entries Unavailable
// i.	Publisher name
// ii.	Entries Unavailable from app-ads.txt and ads.txt
// iii.	Bundle ids associated with the entries unavailable
