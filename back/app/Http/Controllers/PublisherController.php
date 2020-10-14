<?php

namespace App\Http\Controllers;

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

}
