<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use Illuminate\Http\Request;

class TestEvent extends Controller
{
    function index() {
        event(new MyEvent('hello world'));
        echo "Good";
        //return view('serveur');
    }
}
