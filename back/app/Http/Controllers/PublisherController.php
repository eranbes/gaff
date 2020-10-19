<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Entry;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    function index()
    {
        $publishers = Publisher::get(['id', 'name'])
            ->toArray();

        foreach ($publishers as $i => $p) {

            $publishers[$i]['domains'] = Domain::where('publisher_id', $p['id'])
                ->get()
                ->toArray();

        }

        return response($publishers, 200);
    }

    public function store(Request $request)
    {
        $name = $request->get('newPublisher');

        $publishers = new Publisher();

        $publishers->name = $name;

        if ($status = $publishers->save()) {

            return response(
                Publisher::all()
                    ->toArray(),
                201
            );

        }

        return response(null, 304);
    }

    public function show(Request $request)
    {
        $publisher = Publisher::find($request->id);

        $publisher['domains'] = Domain::where('publisher_id', $request->id)
            ->get()
            ->toArray();

        $publisher['entries'] = Entry::where('publisher_id', $request->id)
            ->get()
            ->toArray();

        return response($publisher);
    }

    public function update(Request $request)
    {
        $id = (int)$request->id;
        $name = $request->get('name');
        $entries = $request->get('entries') ?? [];
        $domains = $request->get('domains') ?? [];

        Publisher::find($id)
            ->update(['name' => $name]);

        Entry::where(['publisher_id' => $id])
            ->delete();

        $entry = new Entry;

        foreach ($entries as $e) {

            $entry->create([
                'name' => $e['name'],
                'is_app' => $e['is_app'],
                'publisher_id' => $id,
                'domain_id' => 0
            ]);

        }

        Domain::where(['publisher_id' => $id])
            ->delete();

        $domain = new Domain;

        foreach ($domains as $d) {

            $domain->create([
                'name' => $d['name'],
                'ns_ads' => $d['ns_ads'],
                'ns_app_ads' => $d['ns_app_ads'],
                'publisher_id' => $id,
            ]);

        }

        return $this->show($request);
    }

}
