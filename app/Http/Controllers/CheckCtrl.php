<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;

use App\Http\Requests;

class CheckCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Member::where('url_prof','like',"%jpg%")
                ->orwhere('url_prof','like',"%jpeg%")
                ->orwhere('url_sig','like',"%jpg%")
                ->orwhere('url_sig','like',"%jpeg%")
                ->paginate(20);
        return view('report.check',[
            'data' => $data
        ]);
    }
}
