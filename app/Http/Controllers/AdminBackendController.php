<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\church;
use App\Models\Common;
use App\Models\Annualreport;
use App\Models\Questions;
use App\Models\Mainsection;
use App\Models\Subsection;
use App\Models\Pagesection;
use App\Models\Activedate;
use App\Models\Districtactivedate;
use App\Helpers\ARHelper;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use DB;

class AdminBackendController extends Controller
{
    public function adminbackend()
    {
        $data =  DB::table('church')
        ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','church.mainkey')
        ->LEFTJOIN('annual_report as ar', function($join)
                    {
                        $year = Carbon::now()->year;
                        $join->on('ar.Mainkey', '=', 'church.mainkey');
                        $join->on('ar.YearReported',DB::raw($year - 1));
                    })
        ->select('church.id','church.Mainkey','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail','ar.ReportStatus','ar.validate')
        ->orderBy('mnc.MailingName', 'ASC')
        ->get();

        $year = Carbon::now()->year;

        $SubmitReport =  DB::table('church')
            ->LEFTJOIN('annual_report as ar','ar.Mainkey','=','church.Mainkey')
            ->where('ar.ReportStatus', '=', 'Completed')
            ->where('ar.YearReported', '=', $year-1)
            ->count();

        $ProgressReport =  DB::table('church')
            ->LEFTJOIN('annual_report as ar','ar.Mainkey','=','church.Mainkey')
            ->where('ar.ReportStatus', '=', 'In Progress')
            ->where('ar.YearReported', '=', $year-1)
            ->count();

        $Churchcount = count($data);
        $notstarted= $SubmitReport+$ProgressReport;
        $PendingReport =$Churchcount-$notstarted;

        $SubmitReportPercent = round(($SubmitReport * 100) / $Churchcount, 2);
        $PendingReportPercent = round(($PendingReport * 100) / $Churchcount, 2);
        $ProgressReportPercent = round(($ProgressReport * 100) / $Churchcount, 2);


        return view('adminbackend.includes.dashboard',compact('data','Churchcount','SubmitReport','PendingReport','SubmitReportPercent','PendingReportPercent','ProgressReportPercent','ProgressReport'));
    
    }

    public function getchurchlists(Request $request)
    {
        if ($request->ajax()) {
            $data =  DB::table('church')
            ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','church.mainkey')
            ->select('church.id','church.Mainkey','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail')
            ->orderBy('mnc.MailingName', 'ASC')
            ->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('Name', function($value){
                    $btn = '';
                    $url = url('AnnualReport/ChurchReport/'.ARHelper::encryptUrl($value->Mainkey).'/'.ARHelper::getcurrentyear($value->Mainkey).'');

                    $btn = $btn.'<a href="'.$url.'" class="mainsectionedit" target="_blank">'.$value->MailingName.' </a>';
                    //dd($btn);
                    return $btn;
                })

                ->rawColumns(['Name'])
                ->make(true);
        }
    } 


    public function adminbackendchurchlist()
    {
        $data =  \DB::table('church')
            ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','church.mainkey')
            ->select('church.id','church.Mainkey','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail')
            //->where('church.mainkey','=','343307')
            ->orderBy('mnc.MailingName', 'ASC')
            ->get();

        return view('adminbackend.includes.churchlist',compact('data'));
    }

    public function adminbackendmanageusers()
    {
        $data = \DB::table('church')
            ->LEFTJOIN('mncommon as mnc','mnc.mainkey','=','church.mainkey')
            ->select('church.id','church.Mainkey','mnc.MailingName','mnc.ChurchCode','mnc.USAEmail')
            ->orderBy('mnc.MailingName', 'ASC')
            ->get();

        return view('adminbackend.includes.manageusers',compact('data'));
    }

    public function adminbackendsections()
    {
        return view('adminbackend.includes.sections');
    }

    public function adminbackendquestions()
    {
        $Questions = Questions::all();
        return view('adminbackend.includes.questions',compact('Questions'));
    }

    public function adminbackendquestionsorder()
    {
        $Pagesection = Pagesection::orderBy('Position', 'ASC')->get();
        return view('adminbackend.includes.questionsorderby',compact('Pagesection'));
    }

    public function updatepagesectionposition(Request $request)
    {
        foreach ($request->Position as $key => $Position) {
            $submain = Pagesection::find($Position['id'])->update(['Position' => $Position['Position']]);
        }
        return response()->json(['data'=> 'success']);
    }

    public function updatevalidate(Request $request)
    {
        $input = $request->all();
        $data1 = Annualreport::select('id')->where('Mainkey',$input['mainkey'])->where('YearReported',$input['YearReport'])->first();
        if($data1 != null){
            $data = Annualreport::where('id',$data1->id)->first();
            $data->update(['validate' => $input['validate']]);
        }
        
    }
    public function updateactive(Request $request)
    {
        $input = $request->all();
     
        $data1 = church::select('id')->where('Mainkey',$input['mainkey'])->first();
        if($data1 != null){
            $data = church::where('id',$data1->id)->first();
            $data->update(['Active' => $input['Active']]);
        }
        
    }
    public function churchdataupdate(Request $request)
    {
        $input =  [
            'USAEmail' => $request->USAEmail
        ];
        $mncommon = DB::table('mncommon')->where('Mainkey',$request->churchmainkey)->update($input);

        return response()->json(['data'=> "Email updated successfully"]); 
    }
}
