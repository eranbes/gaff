<?php

namespace App\Http\Controllers;

use App\Mail\StatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DailyController extends Controller
{
    public function run()
    {

        $result = Mail::to('samsonin@mail.ru')->send( new StatusChanged );

        return response($result , $result ? 201 : 200);

    }
}
