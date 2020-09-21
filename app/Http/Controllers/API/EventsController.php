<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Models\Event;

class EventsController extends Controller
{
    public function index()
    {
        return Event::select('name', 'city', 'state')
            ->orderBy('id')
            ->paginate(10);
    }
}
