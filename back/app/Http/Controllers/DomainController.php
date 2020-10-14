<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    function index()
    {
        $domains = Domain::all()
            ->toArray();

        return response($domains, 200);
    }

    public function store(Request $request)
    {
        $name = $request->get('newDomain');

        $domains = new Domain();

        $domains->name = $name;

        if ($status = $domains->save()) {

            return response(
                Domain::all()
                    ->toArray(),
                201
            );

        }

        return response(null, 304);
    }

}
