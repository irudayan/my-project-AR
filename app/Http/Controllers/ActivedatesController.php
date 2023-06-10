<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\church;
use App\Models\Common;
use App\Models\Annualreport;
use App\Models\Questions;
use App\Models\Activedate;
use App\Models\Districtactivedate;
use App\Helpers\ARHelper;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;

class ActivedatesController extends Controller
{

    public function adminbackendactivedate()
    {
      return view('adminbackend.includes.activedate');
    }

    public function activedatestore(Request $request)
    {
        $year = $request->ActiveDate;
        $activedateyear = date('Y', strtotime($year));
        $request->merge([
            'Year' => $activedateyear,
        ]);
        $countActivedate = Activedate::where('Year',$activedateyear)
                          ->where('Rolestype',$request->Rolestype)->count();
        if($countActivedate == 0){
            $input = $request->except('_token','route');
            $data = new Activedate($input);
            $data->save();
            return response()->json(['success'=> " Created Successfully!"]);
        }else{
            return response()->json(['warning'=> " ".$request->Rolestype." Active Date for Year of ".$activedateyear." Already Set!"]);

        }
    }
    public function activeedit(Request $request)
    {
        $id = $request->id;
        $data = Activedate::where('id',$id)->first();
        return response()->json(['data'=> $data]);
    }
    public function activedateupdate(Request $request)
    {
        $year = $request->ActiveDate;
        $activedateyear = date('Y', strtotime($year));

        $request->merge([
            'Year' => $activedateyear,
        ]);

        // $countActivedate = Activedate::where('Year',$activedateyear)->where('Rolestype',$request->Rolestype)->count();

        // if($countActivedate == 0){

        $input = $request->except('_token','route');
        $data = Activedate::where('id',$input['id'])->first();
        $data->update($input);
        return response()->json(['data'=> 'success','success'=> "Updated Successfully!"]);

        // }else{

        //     return response()->json(['warning'=> "Year of ".$activedateyear." ".$request->Rolestype." Active Date Already Exist!"]);

        // }

    }


    public function activedatedata(Request $request)
    {

    if ($request->ajax()) {

            $data = Activedate::all();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('Status', function($row){
                    $date = Carbon::now();
                    $status = '';
                    if($row->ActiveDate > $date){
                        $status = $status.'<label class="status-notstart">Not Started</label>';
                    }elseif($row->ActiveDate <= $date && $row->EndDate >= $date){
                        $status = $status.'<label class="status-active">Active</label>';
                    }else{
                        $status = $status.'<label class="status-inactive">Inactive</label>';
                    }
                    return $status;
                })
                ->addColumn('Action', function($row){
                    $btn = '';
                    $btn = $btn.'<a href="javascript:void(0)" class="activeedit" id="activeedit'.$row->id.'" data-id="'.$row->id.'" data-original-title="view" title="edit" data-bs-toggle="modal" data-bs-target="#active_date" ><i class="fa fa-edit"></i></a>';
                    $btn = $btn.'   <a href="javascript:void(0)"
                    class="activedatedel"  id="activedatedel'.$row->id.'"  data-id="'.$row->id.'" section-id="main" data-original-title="Delete" data-bs-toggle="modal" data-bs-target="#delete-section">
                    <i class="fa fa-trash"></i>
                    </a>';
                    return $btn;
                })
                ->rawColumns(['Action','Status'])
                ->make(true);
        }
    }



    public static function activedatedelete(Request $request)
    {
        $id = $request->id;
        // dd($id);
        $data = Activedate::where('id',$id)->delete();

        return response()->json(['success'=> "Deleted Successfully!"]);
    }

}

