<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\church;
use App\Models\Common;
use App\Models\Ethnicity;
use App\Models\Mainsection;
use App\Models\Subsection;
use App\Models\Pagesection;
use App\Models\Ethnicitydropdown;
use App\Models\Languagedropdown;
use App\Models\Annualreport;
use App\Models\User;
use App\Models\ReportSectionStatus;
use App\Helpers\ARHelper;
use App\Models\District;
use DB;
use Carbon\Carbon;

class MultiDropdownController extends Controller
{

    public function multidropdownupdate(Request $request)
    {

        $table = strtolower($request->Tablename);
        $input = [
            "Mainkey" => $request->Mainkey,
            "FieldName" => $request->FieldName,
            // "PartnershipType" => "AnnualReport",
            "created_at" => Carbon::now()
        ];

        $data = DB::table($table)->insert($input);

        $getdata = DB::table($table)->orderBy('id', 'DESC')->first();

        return response()->json($getdata->id);
        
    }

    public function multidropdowndelete(Request $request)
    {
        $id = $request->id;
        
        $table = strtolower($request->Tablename);

        $data = DB::table($table)->where('id',$id)->delete();

        return response()->json('true');
        
    }


}
