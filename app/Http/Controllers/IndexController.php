<?php

    namespace App\Http\Controllers;

    use App\Models\Ads;
    use Illuminate\Http\Request;

    class IndexController extends Controller
    {
        //
        public function index()
        {

            return view('index');
        }

        public function view($id)
        {

            return view('view')->with(['ads'=>$id]);
        }
    }
