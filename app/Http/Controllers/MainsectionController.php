<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\church;
use App\Models\Common;
use App\Models\Annualreport;
use App\Models\Staff;
use App\Models\Mainsection;
use App\Models\Subsection;
use App\Models\Pagesection;
use App\Models\Questions;
use App\Helpers\ARHelper;
use Yajra\DataTables\DataTables;
use DB;

class MainsectionController extends Controller
{   
    public function index(Request $request){    
   
            $main  = Mainsection::orderBy('Position','asc')->get();
            $submain  = Subsection::orderBy('Position','asc')->get();
            return view('adminbackend.includes.sections',compact('main','submain'));
    }

    public function Mainsectionposition(Request $request)
    {
    if ($request->ajax()) {

            $data = Mainsection::orderBy('Position','asc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
    
    public function updateOrder(Request $request){

        foreach ($request->Position as $key => $Position) {
        $main = Mainsection::find($Position['id'])->update(['Position' => $Position['Position']]);
        }

        return response()->json(['data'=> 'success']); 
    }

    public function subsectionposition(Request $request)
    {
    if ($request->ajax()) {

            $data = Subsection::orderBy('Position','asc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function updatesubsection(Request $request){
        foreach ($request->Position as $key => $Position) {
        $submain = Subsection::find($Position['id'])->update(['Position' => $Position['Position']]);
        }

        return response()->json(['data'=> 'success']);
    } 

    public function mainsectionstore(Request $request)
    {
        $code = ARHelper::rmvsplcharcter($request->Name);
        $request->merge([
            'MainSectionCode' => $code,
        ]);
        $postion = Mainsection::count()+1;
        $postionval= Mainsection::where('Position','>=',$postion)->count();
        if($postionval == 0 ){
            $request->merge([
                'Position' => $postion
            ]);
        }
        $input = $request->except('_token');
        $data = new Mainsection($input);
        $data->save();
        return response()->json(['success'=> "Main Section Created Successfully!"]);
        
    }

    public function mainsectionedit(Request $request)
    {
        $id = $request->id;
        $data = Mainsection::where('id',$id)->first();
        return response()->json(['data'=> $data]);
    }

    public function mainsectionupdate(Request $request)
    {
        $code = ARHelper::rmvsplcharcter($request->Name);
        $request->merge([
            'MainSectionCode' => $code,
        ]);
        $input = $request->except('_token');
        $data = Mainsection::where('id',$input['id'])->first();
        $data->update($input);
        $values1 = Subsection::where('MainsectionName',$request->oldName)->update(['MainsectionName'=>$request->Name]);
        $values2 = Pagesection::where('MainsectionName',$request->oldName)->update(['MainsectionName'=>$request->Name]);
        $values3 = Questions::where('Mainsection',$request->oldName)->update(['Mainsection'=>$request->Name]);
        return response()->json(['data'=> 'success','success'=> "Main Section Updated Successfully!"]);

    }

    public function mainsectiondata(Request $request)
    {
      if ($request->ajax()) {
            $data = Mainsection::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '';
                    $btn = $btn.'<a href="javascript:void(0)" class="mainsectionedit" id="mainsectionedit'.$row->id.'" data-id="'.$row->id.'" data-original-title="view" title="edit" data-bs-toggle="modal" data-bs-target="#main-section" ><i class="fa fa-edit"></i></a>';
                    $btn = $btn.'   <a href="javascript:void(0)" data-toggle="tooltip" class="mainsectiondel"  id="mainsectiondel'.$row->id.'"  data-id="'.$row->id.'" section-id="main" data-original-title="Delete" data-bs-toggle="modal" data-bs-target="#delete-section"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } 
    } 

    public static function mainsectiondelete(Request $request)
    {
        $id = $request->id;
        $main = Mainsection::select('Name')->where('id',$id)->first();
        $sub = subsection::select('Name')->where('MainsectionName',$main['Name'])->count();
        
        if($sub != 0){
            return response()->json(['failed'=> "Sub section are exist do not delete the main section!"]);
        }else{
            $Question = Mainsection::where('id',$id)->delete();
            return response()->json(['success'=> "Main Section deleted Successfully!"]);
        }
        
    }

}
