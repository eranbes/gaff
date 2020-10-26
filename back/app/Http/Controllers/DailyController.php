<?php

namespace App\Http\Controllers;

use App\Mail\StatusChanged;
use App\Models\Crawl;
use App\Models\Domain;
use App\Models\Publisher;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        $domains = [];

//        $changed_entries = Crawl::whereDate('updated_at', Carbon::yesterday())
        $changed_entries = Crawl::whereDate('updated_at', Carbon::today())
            ->orderBy('status_id')
            ->get()
            ->toArray();

        foreach ($changed_entries as $e) {

            if (!in_array($e['domain_id'], $domains)) {

                $domains[] = $e['domain_id'];

            }
        }

        $domains = Domain::whereIn('id', $domains)
            ->with('publisher')
            ->get(['id', 'name', 'publisher_id'])
            ->map(function ($d) {

                $d['publisher_name'] = $d['publisher']['name'];

                return $d;

            })
            ->toArray();

        $entries = [];

//            $e['publisher_name' => '',
//                'ads entries' => '',
//                'app-ads entries' => '',
//                'bundle_ids' => '',


//        $result = Mail::to('samsonin@mail.ru')
//            ->send(new StatusChanged($report));

        return response($changed_entries);
    }
}

//a.	Entries added
//i.	Publisher name
//ii.	Entries added for app-ads.txt and ads.txt
//                         iii.	Bundle ids associated with the entries added
//
//b.	Entries Deleted
//i.	Publisher name
//ii.	Entries deleted from app-ads.txt and ads.txt
//iii.	Bundle ids associated with the entries deleted
//
//c.	Entries Unavailable
//i.	Publisher name
//ii.	Entries Unavailable from app-ads.txt and ads.txt
//iii.	Bundle ids associated with the entries unavailable
