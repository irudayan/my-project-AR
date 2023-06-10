<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\AdminBackendController;
use App\Http\Controllers\MainsectionController;
use App\Http\Controllers\SubsectionController;
use App\Http\Controllers\PagesectionController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ManageusersController;
use App\Http\Controllers\PdfController;
use App\Models\Activedate;
use App\Models\User;
use App\Models\resourcefiles;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ExportdataController;
use App\Http\Controllers\ChurchlistexportController;
use App\Http\Controllers\MultiDropdownController;
use App\Http\Controllers\PercentController;
use App\Http\Controllers\FormulaController;
use App\Http\Controllers\ActivedatesController;
use App\Http\Controllers\ResourceFileController;
use App\Http\Controllers\StaffRoleController;


//  URL::forcescheme('https');

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

$usertype = User::get('usertype');

Route::get('/', function () {
    $files = resourcefiles::where('active_status','Publish')->get();
    return view('frontend/home',compact('files'));
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('districtchurch', [RegisterController::class, 'districtchurch']);
Route::get('checkemail', [RegisterController::class, 'checkemail']);
Route::get('checkusername', [RegisterController::class, 'checkusername']);
Route::get('sendmessage', [ContactusController::class,'sendmessage'])->name('sendmessage');
Route::get('login/{id}', [dashboardController::class, 'verifyLogin'])->name('verify-login');
Route::get('Impersonate/{id}', [HomeController::class, 'verifyLogin'])->name('verify-login');
Route::get('change-password/{id}',[HomeController::class, 'changePassword'])->name('change-password');
Route::post('reset-password',[HomeController::class, 'resetpassword'])->name('reset-password');
Route::view('phpinfo','phpinformation');

Route::group(['middleware' => 'auth'], function()

{

    Route::get('viewdashboardstaff', [dashboardController::class, 'viewdashboardstaff']);
    Route::get('otpgenerate', [dashboardController::class, 'getotpgenerate']);
    Route::get('Getstaffdetailslink', [ManageusersController::class, 'Getstaffdetailslink']);
    Route::get('AnnualReport/getdistrict', [ManageusersController::class, 'getdistrictchurch']);
    Route::get('AnnualReport/getdistrict/export', [ManageusersController::class, 'getdistrictchurchexport']);
    Route::get('AnnualReport/getendyears/export', [ManageusersController::class, 'getendyearchurchexport']);
    Route::get('AnnualReport/getstartyears/export', [ManageusersController::class, 'getstartyearchurchexport']);
    Route::get('AnnualReport/usergetdistrict/export', [ManageusersController::class, 'getuserchurchexport']);
    Route::get('AnnualReport/getyear/export', [ManageusersController::class, 'getyearreportedexport']);
    Route::get('AnnualReport/getdisname/reportname', [ManageusersController::class, 'getdistrictName']);

    Route::get('AnnualReport/Dashboard', [dashboardController::class, 'index'])->name('dashboard');
    Route::get('AnnualReport/Churchlist', [dashboardController::class, 'churchlist'])->name('churchlist');
    Route::get('AnnualReport/churchedit', [dashboardController::class, 'churchedit']);
    Route::get('churchlistfilter', [dashboardController::class, 'churchlistfilter']);
    Route::get('dashboardchurchlistfilter', [dashboardController::class, 'dashboardchurchlistfilter']);

    Route::get('churchlistedit', [dashboardController::class, 'churchlistedit']);

    Route::get('pdfgenerate/{id}/{year}', [dashboardController::class, 'pdfgenerate'])->name('pdfgenerate');
    Route::get('encryptdata', [dashboardController::class, 'encryptdata']);

    Route::get('AnnualReport/ChurchReport/{id}/{year}', [dashboardController::class, 'churchreportdynamic'])->name('churchreportdynamic');
    Route::get('GetChildChurchReport', [dashboardController::class, 'GetChildChurchReport']);
    Route::get('exportXlxs', [ExportController::class,'exportXlxs'])->name('exportXlxs');
    Route::get('churchexportXlxs', [ChurchlistexportController::class,'churchexportXlxs'])->name('churchexportXlxs');
    Route::get('Exportallchurchlist', [ChurchlistexportController::class,'Exportallchurchlist'])->name('Exportallchurchlist');
    Route::get('ExportallDistrictchurchlist', [ChurchlistexportController::class,'ExportallDistrictchurchlist'])->name('ExportallDistrictchurchlist');
    Route::get('churchexportalldataXlxs', [ExportdataController::class,'churchexportalldataXlxs'])->name('churchexportalldataXlxs');

    $real_path = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'subroutes' . DIRECTORY_SEPARATOR;
    include_once($real_path . 'subroute.php');
    // AdminDashboard Routes

    Route::get('/AnnualReport/validate', [AdminBackendController::class, 'updatevalidate']);
    Route::get('/AnnualReport/active', [AdminBackendController::class, 'updateactive']);
    Route::get('/AnnualReport/Admin-Dashboard', [AdminBackendController::class, 'adminbackend']);
    Route::get('getchurchlists', [AdminBackendController::class, 'getchurchlists']);
    Route::get('churchdataupdate', [AdminBackendController::class, 'churchdataupdate']);

    Route::get('/AnnualReport/Admin-Dashboard/Churchlist', [AdminBackendController::class, 'adminbackendchurchlist']);

    // chruch active date
    Route::get('/AnnualReport/Admin-Dashboard/Active-Dates', [ActivedatesController::class, 'adminbackendactivedate']);

    Route::post('activedatestore', [ActivedatesController::class, 'activedatestore'])->name('activedatestore');
    Route::get('activedatedata', [ActivedatesController::class, 'activedatedata']);
    Route::get('activeedit', [ActivedatesController::class, 'activeedit']);
    Route::post('activedateupdate', [ActivedatesController::class, 'activedateupdate']);
    Route::get('activedatedelete', [ActivedatesController::class, 'activedatedelete']);


    Route::get('/AnnualReport/Admin-Dashboard/Manage-users', [AdminBackendController::class, 'adminbackendmanageusers']);
    Route::get('/AnnualReport/Admin-Dashboard/Sections', [AdminBackendController::class, 'adminbackendsections']);
    Route::get('/AnnualReport/Admin-Dashboard/Questions', [AdminBackendController::class, 'adminbackendquestions']);
    Route::get('/AnnualReport/Admin-Dashboard/Export', [QuestionsController::class, 'exportall']); 
    Route::get('/AnnualReport/Admin-Dashboard/Questionsorder', [AdminBackendController::class, 'adminbackendquestionsorder']);
    //Staff role manage
    Route::get('checkrolename', [StaffRoleController::class, 'checkrolename']);
    Route::get('AnnualReport/Admin-Dashboard/Manage-Staff-Roles', [StaffRoleController::class, 'index']);
    Route::post('AnnualReport/Admin-Dashboard/Add-Staff-Roles', [StaffRoleController::class, 'addstaffroles']);
    Route::get('AnnualReport/Admin-Dashboard/Delete-Staff-Roles', [StaffRoleController::class, 'deletestaffroles']);
    Route::get('AnnualReport/Admin-Dashboard/Edit-Staff-Roles', [StaffRoleController::class, 'editstaffroles']);
    Route::post('AnnualReport/Admin-Dashboard/Update-Staff-Roles', [StaffRoleController::class, 'updatestaffroles']);
    Route::get('showstaffroles', [StaffRoleController::class, 'showstaffroles']);


    // Section Controller Routes
    Route::get('Mainsectionposition', [MainsectionController::class, 'Mainsectionposition']);
    Route::get('subsectionposition', [MainsectionController::class, 'subsectionposition']);
    Route::get('mainsectiondata', [MainsectionController::class, 'mainsectiondata']);
    Route::get('/AnnualReport/Admin-Dashboard/Sections', [MainsectionController::class, 'index']);
    Route::post('update-order', [MainsectionController::class, 'updateOrder']);
     Route::post('updatesubsection', [MainsectionController::class, 'updatesubsection']);
    Route::post('mainsectionstore', [MainsectionController::class, 'mainsectionstore']);
    Route::get('mainsectionedit', [MainsectionController::class, 'mainsectionedit']);
    Route::post('mainsectionupdate', [MainsectionController::class, 'mainsectionupdate']);
    Route::get('mainsectiondelete', [MainsectionController::class, 'mainsectiondelete']);

    Route::get('subsectiondata', [SubsectionController::class, 'subsectiondata']);
    Route::get('subsectionedit', [SubsectionController::class, 'subsectionedit']);
    Route::post('subsectionupdate', [SubsectionController::class, 'subsectionupdate']);
    Route::post('subsectionstore', [SubsectionController::class, 'subsectionstore']);
    Route::get('subsectiondelete', [SubsectionController::class, 'subsectiondelete']);

    Route::get('getsectiondata', [SubsectionController::class, 'getsectiondata']);


    Route::get('pagesectiondata', [PagesectionController::class, 'pagesectiondata']);
    Route::get('pagesectionedit', [PagesectionController::class, 'pagesectionedit']);
    Route::post('pagesectionupdate', [PagesectionController::class, 'pagesectionupdate']);
    Route::post('pagesectionstore', [PagesectionController::class, 'pagesectionstore']);
    Route::get('pagesectiondelete', [PagesectionController::class, 'pagesectiondelete']);

    Route::get('getpagesubsection', [PagesectionController::class, 'getpagesubsection']);
    Route::post('updatepagesectionposition', [PagesectionController::class, 'updatepagesectionposition']);

    Route::get('AnnualReport/Manage-Users', [ManageusersController::class, 'index']);
    Route::get('AnnualReport/Church-Export', [ManageusersController::class, 'exportindex']);
    Route::get('getusertypecount', [ManageusersController::class, 'getusertypecount']);
    Route::get('ManageUserslist', [ManageusersController::class, 'getuserlist']);
    Route::get('AnnualReport/Get-Users', [ManageusersController::class, 'getusers']);
    Route::get('AnnualReport/delete-Users', [ManageusersController::class, 'deleteusers']);
    Route::get('AnnualReport/Get-staffs', [ManageusersController::class, 'getstaffs']);
    Route::get('AnnualReport/delete-staffs', [ManageusersController::class, 'deletestaffs']);
    Route::get('AnnualReport/delete-newstaffs', [ManageusersController::class, 'deletenewstaffs']);
    Route::get('AnnualReport/Update-Profile', [ManageusersController::class, 'UpdateUsers']);
    Route::post('AnnualReport/Update-Users', [ManageusersController::class, 'UpdateUsers']);
    Route::get('AnnualReport/Update-otp', [ManageusersController::class, 'UpdateUsers']);
    Route::post('AnnualReport/Update-Staffs', [ManageusersController::class, 'UpdateStaffs']);
    Route::post('AnnualReport/Add-Staffs', [ManageusersController::class, 'addnewstaffs']);


    // Route::get('getuserstatus', [App\Http\Controllers\ManageusersController::class, 'getuserstatus'])->name('getuserstatus');
    // Route::post('userstatusupdate', [App\Http\Controllers\ManageusersController::class, 'userstatusupdate'])->name('userstatusupdate');
    // Route::get('getstatus', [App\Http\Controllers\ManageusersController::class, 'getstatus'])->name('getstatus');

    Route::get('/AnnualReport/Admin-Dashboard/Add-Question', [QuestionsController::class, 'addQuestion']);
    Route::get('/AnnualReport/Admin-Dashboard/Edit-Question/{id}', [QuestionsController::class, 'editQuestion']);
    Route::get('deleteQuestion', [QuestionsController::class, 'deleteQuestion']);
    Route::get('getsection', [QuestionsController::class, 'getsection']);
    Route::post('QuestionStore', [QuestionsController::class, 'QuestionStore']);
    Route::post('QuestionUpdate', [QuestionsController::class, 'QuestionUpdate']);

    Route::get('GetQuesass', [QuestionsController::class, 'GetQuesass']);
    Route::get('getChild', [QuestionsController::class, 'getChild']);
    Route::get('getChildAnsQues', [QuestionsController::class, 'getChildAnsQues']);
    Route::get('getQuesParent', [QuestionsController::class, 'getQuesParent']);
    Route::get('getChildAns', [QuestionsController::class, 'getChildAns']);
    Route::get('checkQuestioncode', [QuestionsController::class, 'checkQuestioncode']);
    Route::post('updateQuestionposition', [QuestionsController::class, 'updateQuestionposition']);

    Route::get('multidropdownupdate', [MultiDropdownController::class, 'multidropdownupdate']);
    Route::get('multidropdowndelete', [MultiDropdownController::class, 'multidropdowndelete']);
    Route::get('percentUpdate', [PercentController::class, 'percentUpdate']);
    Route::get('percentDelete', [PercentController::class, 'percentDelete']);

    Route::get('formulaenableQuestions', [FormulaController::class, 'formulaenableQuestions']);
    Route::get('FormulaCalulate', [FormulaController::class, 'FormulaCalulate']);
    Route::get('multinumericformula', [FormulaController::class, 'multinumericformula']);

    // resource uploads
    Route::get('AnnualReport/Manage-Documents', [ResourceFileController::class,'resourceindex'])->name('resourceindex');
    Route::post('ResourceUploadFile', [ResourceFileController::class,'ResourceUploadFile'])->name('ResourceUploadFile');
    Route::get('resourcefilesget', [ResourceFileController::class,'resourcefilesget'])->name('resourcefilesget');
    Route::get('resourcefilesview', [ResourceFileController::class,'resourcefilesview'])->name('resourcefilesview');
    Route::post('resourcefilesupdate', [ResourceFileController::class,'resourcefilesupdate'])->name('resourcefilesupdate');
    Route::post('updateresourcefile', [ResourceFileController::class,'updateresourcefile'])->name('updateresourcefile');
    Route::get('destroyresourcefile', [ResourceFileController::class,'destroyresourcefile'])->name('destroyresourcefile');
});

Route::get('logout', function ()
{
    auth()->logout();
    Session()->flush();
    return Redirect::to('/');
})->name('logout');
