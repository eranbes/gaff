<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    function index()
    {
        $publishers = Publisher::all()
//            ->get(['id', 'name']
            ->toArray();

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

        $publisher['entries'] = Entry::where('publisher_id', $request->id)
            ->get()
            ->toArray();

        return response($publisher);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $name = $request->get('name');
        $entries = $request->get('entries') ?? [];

        Publisher::find($id)
            ->update(['name' => $name]);

        Entry::where(['publisher_id' => $id])
            ->delete();

        $entry = new Entry;

        foreach ($entries as $e) {

            $entry->name = $e['name'];
            $entry->is_app = $e['is_app'];
            $entry->publisher_id = $id;
            $entry->domain_id = 0;

            $entry->save();
        }

        return $this->show($request);
    }

}
