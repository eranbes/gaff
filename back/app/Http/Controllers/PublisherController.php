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
        $publishers = Publisher::with('domains')
            ->get(['id', 'name'])
            ->toArray();

        return response($publishers, 200);
    }

    public function store(Request $request)
    {
        $name = $request->get('newPublisher');

        $publishers = new Publisher();

        $publishers->name = $name;

        return $publishers->save()

            ? response(Publisher::with('domains')
                ->get(['id', 'name'])
                ->toArray(),
                201
            )
            : response(null, 304);
    }

    public function show(Request $request)
    {
        $publisher = Publisher::find($request->id);

        $publisher['domains'] = Domain::with(['entries', 'assets'])
            ->where('publisher_id', $request->id)
            ->get()
            ->toArray();

        return response($publisher);
    }

    public function update(Request $request)
    {
        $id = (int)$request->id;
        $name = $request->get('name');
        $domains = $request->get('domains') ?? [];

        Publisher::find($id)
            ->update(['name' => $name]);

        foreach ($domains as $d) {

            $new_domain = [
                'name' => $d['name'],
                'ns_ads' => $d['ns_ads'],
                'ns_app_ads' => $d['ns_app_ads'],
                'publisher_id' => $id,
            ];

            $domain = Domain::where('id', $d['id'])
                ->where('publisher_id', $d['publisher_id']);

            if ($domain->get()->isEmpty()) {

                $new_id = (new Domain)->create($new_domain)->id;

                foreach ($d['entries'] as &$e) {

                    if ($e['domain_id'] == $d['id']) {
                        $e['domain_id'] = $new_id;
                    }

                }

            } else {

                $domain->update($new_domain);

            }

            Entry::where('domain_id', $d['id'])
                ->delete();

            $entry = new Entry;

            foreach ($d['entries'] as $e) {
                $entry->create([
                    'name' => $e['name'],
                    'is_app' => $e['is_app'],
                    'domain_id' => $e['domain_id']
                ]);
            }

        }

        return $this->show($request);
    }

}
