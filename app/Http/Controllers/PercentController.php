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

class PercentController extends Controller
{

    public function percentUpdate(Request $request)
    {
        $user = Auth::user()->username;
        $request->merge([
            'created_at' => Carbon::now()
        ]);

        $id = $request->id;

        $tablename = strtolower($request->tablename);


        if($id == null){
            $input = $request->except('tablename');
            $data = DB::table($tablename)->insert($input);
            $dataval = DB::table($tablename)->orderBy('id', 'DESC')->first();
            return response()->json(['id'=>$dataval->id]);
        }else{
            $inputupdate = $request->except('id','tablename');
            $data = DB::table($tablename)->where('Year',$inputupdate['Year'])
            ->where('Name',$inputupdate['Name'])->where('Mainkey',$inputupdate['Mainkey'])->update($inputupdate);
            $dataval = DB::table($tablename)->orderBy('id', 'DESC')->first();
            return response()->json(['id'=>$dataval->id]);
        }
        
        
    }

    public function percentDelete(Request $request)
    {
        $id = $request->id;

        $table = strtolower($request->table);

        $data = DB::table($table)->where('id',$id)->delete();

        return response()->json('true');
        
    }


}
