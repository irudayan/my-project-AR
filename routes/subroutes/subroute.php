<?php
use App\Models\Subsection;
use App\Models\Mainsection;
use App\Http\Controllers\ReportController;
use App\Helpers\ARHelper;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


$subsection = Subsection::get();

$segments = Request::segments();
//dd($segments);
if(count($segments) > 3 && $segments[3] == 'Review'){
    $test= Route::get('AnnualReport/ChurchReport/Review/Review/{id}/{year}', [ReportController::class, 'Review']);
}else{

    foreach ($subsection as $key => $page) {
    $test= Route::get('AnnualReport/ChurchReport/'.ARHelper::rmvsplcharcter($page->MainsectionName).'/'.ARHelper::rmvsplcharcter($page->Name).'/{id}/{year}', [ReportController::class, 'Common']);
    // $test= Route::get('AnnualReport/ChurchReport/'.ARHelper::rmvsplcharcter($page->MainsectionName).'/'.ARHelper::rmvsplcharcter($page->Name).'/{id}/{year}', [ReportController::class, ARHelper::rmvsplcharcter($page->Name)]);
    }
}

Route::get('storereviewsubmit', [ReportController::class, 'storereviewsubmit']);
Route::post('StoreAnnualreport', [ReportController::class, 'StoreAnnualreport']);
Route::get('reportAutoSave', [ReportController::class, 'reportAutoSave']);
Route::get('MoveNextsection', [ReportController::class, 'MoveNextsection']);
