<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
/*    public function __construct()
    {

    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index.index');
    }
}
