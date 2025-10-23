<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsumerServicePlatformController extends Controller
{
    /**
     * Display a listing of the consumer service platforms.
     */
    public function index()
    {
        return view('consumer_service_platforms.index');
    }
}