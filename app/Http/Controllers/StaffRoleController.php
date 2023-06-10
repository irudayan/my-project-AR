<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\church;
use App\Models\Common;
use App\Models\Annualreport;
use App\Models\Questions;
use App\Models\Activedate;
use App\Models\Districtactivedate;
use App\Models\Staffroledropdown;
use App\Helpers\ARHelper;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;

class StaffRoleController extends Controller
{

    public function index(){

        return view('adminbackend.includes.managestaffrole');
    }

    public function addstaffroles(Request $request)
    {
        $input = $request->except('_token');
        DB::table('staffroledropdown')->insert($input);
        return response()->json(['success'=> "New Staff Role Added Successfully!","action" => "Add"]);
    }

    public function deletestaffroles(Request $request){
        $id = $request->id;
        $data = Staffroledropdown::where('id',$id)->delete();
        return response()->json(["success"=> "Deleted Successfully!","action" => "Delete"]);
    }
    public function editstaffroles(Request $request){
        $id = $request->id;
        $data = Staffroledropdown::where('id',$id)->first();
        return response()->json(['data'=> $data]);
    }

    public function updatestaffroles(Request $request){
        $input = $request->except('_token');
        //dd($input);
        $data = Staffroledropdown::where('id',$input['id'])->first();
        $data->update($input);
        return response()->json(['data'=> 'success','success'=> "Updated Successfully!"]);
    }

    protected function checkrolename(Request $request)
    {  $data= $request->all();
          $user = Staffroledropdown::all()->where('role_name',$data['role_name'])->first();
        if ($user) {
              return "false";
        } else {
            return "true";
        }
    }

    public function showstaffroles(Request $request)
    {
    if ($request->ajax()) {

            $data = Staffroledropdown::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('role_name', function($row){
                    $rolename = '';
                        $rolename = $rolename.'<span data-original-title="view" >'.$row->role_name.'</span>';
                    return $rolename;
                    })
                // ->addColumn('description', function($row){
                //     $description = '';
                //         $description = $description.'<span data-original-title="view" >'.$row->description.'</span>';
                //     return $description;
                // })
                ->addColumn('Action', function($row){
                    $btn = '';
                    $btn = $btn.'<a href="javascript:void(0)" class="staffroleedit" id="staffroleedit'.$row->id.'" data-id="'.$row->id.'" data-original-title="view" title="edit" data-bs-toggle="modal" data-bs-target="#edit_staffrole" ><i class="fa fa-edit"></i></a>';
                    $btn = $btn.'   <a href="javascript:void(0)"
                    class="staffroledel"  id="staffroledel'.$row->id.'" data-id="'.$row->id.'" section-id="main" data-original-title="Delete" data-bs-toggle="modal" data-bs-target="#delete_staffrole">
                    <i class="fa fa-trash"></i>
                    </a>';
                    return $btn;
                })
                ->rawColumns(['role_name','description','Action'])
                ->make(true);
        }
    }

}
