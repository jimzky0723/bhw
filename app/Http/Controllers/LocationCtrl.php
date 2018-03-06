<?php

namespace App\Http\Controllers;

use App\Barangay;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Muncity;

class LocationCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function muncitylist($id)
    {
        $muncity = Muncity::select('id','description')
                ->where('province_id',$id)
                ->orderBy('description','asc')
                ->get();
        return $muncity;

    }

    public function barangaylist($id)
    {
        $barangay = Barangay::select('id','description')
                ->where('muncity_id',$id)
                ->orderBy('description','asc')
                ->get();
        return $barangay;

    }
}
