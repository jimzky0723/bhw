<?php

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

//member area
Route::get('member','MemberCtrl@listMember');
Route::get('member/add','MemberCtrl@addMember');
Route::post('member/save','MemberCtrl@saveMember');

Route::get('member/list','MemberCtrl@listMember');
Route::post('member/list','MemberCtrl@searchMember');

Route::get('member/{id}','MemberCtrl@editMember');
Route::post('member/update/{id}','MemberCtrl@updateMember');
Route::get('member/delete/{id}','MemberCtrl@deleteMember');


//location
Route::get('location/muncitylist/{id}','LocationCtrl@muncitylist');
Route::get('location/barangaylist/{id}','LocationCtrl@barangaylist');


//payment status
Route::get('payment/status/{id}','PaymentCtrl@status');
Route::post('payment/save','PaymentCtrl@savePayment');
Route::get('payment/info/{id}','PaymentCtrl@info');
Route::get('payment/delete/{id}','PaymentCtrl@delete');

//generate ID card
Route::get('generate/{id}','GenerateCtrl@generateID');

//generate report
Route::get('report','ReportCtrl@index');
Route::get('report/home','ReportCtrl@generateHome');
Route::get('report/excel','ReportCtrl@generateExcel');

//check png files
Route::get('check','CheckCtrl@index');
Route::get('fix','MemberCtrl@fix');
