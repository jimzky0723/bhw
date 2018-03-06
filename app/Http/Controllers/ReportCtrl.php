<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

class ReportCtrl extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('report.index');
    }

    public function generateHome()
    {
        $data = array();
        $year = date('Y');
        for($i=1; $i<=12; $i++)
        {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $start = "$year-$month-01";
            $month2 = str_pad(($i+1), 2, '0', STR_PAD_LEFT);
            $end = "$year-$month2-01";
            if($i==12)
            {
                $end = ($year+1).'-01-01';
            }
            $data['bohol'][] = self::countMember(1,$start,$end);
            $data['cebu'][] = self::countMember(2,$start,$end);
            $data['negros'][] = self::countMember(3,$start,$end);
            $data['siquijor'][] = self::countMember(4,$start,$end);
        }
        return $data;
    }

    public function countMember($province,$start,$end)
    {
        $count = Member::where('province',$province)
                ->where('date_added','>=',$start)
                ->where('date_added','<',$end)
                ->count();
        return $count;
    }

    public function generateExcel()
    {
        $data = array(
            array('data1', 'data2'),
            array('data3', 'data4')
        );

        Excel::create('Filename', function($excel) use($data) {


            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromArray($data);
                $sheet->row(1, array(
                    'test1', 'test2'
                ));

            });

        })->export('xls');
    }
}
