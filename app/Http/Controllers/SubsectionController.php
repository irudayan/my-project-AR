<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
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

class SubsectionController extends Controller
{
    
    public function subsectionstore(Request $request)
    {
        $code = ARHelper::rmvsplcharcter($request->Name);
       
        $request->merge([
            'SubSectionCode' => $code,
        ]);
        
        $reportsectionstatus = Schema::hasColumn('reportsectionstatus',$code);
        if($reportsectionstatus == false){
            DB::statement("ALTER TABLE reportsectionstatus ADD ".$code." int(11) DEFAULT 0");
        }
        $postion = Subsection::count()+1;
        $postionval= Subsection::where('Position','>=',$postion)->count();
        if($postionval == 0 ){
            $request->merge([
                'Position' => $postion
            ]);
        }
        $input = $request->except('_token');
        $data = new Subsection($input);
        $data->save();

        return response()->json(['success'=> "Sub Section Created Successfully!"]);
    }

    public function getsectiondata(Request $request)
    {
        $data = $request->all();

        if($data['type'] == "submain"){
            $section = Mainsection::all();
            $sectionId = "sub-section-main-section-name";
        }
        if($data['type'] == "pagemain"){
            $section = Mainsection::all();
            $sectionId = "page-section-main-section-name";
        }
        if($data['type'] == "pagesub"){
            $section = Subsection::where('MainsectionName',$data['val'])->get();
            $sectionId = "page-section-sub-section-name";
        }

        return response()->json(['data'=> $section,'sectionId'=> $sectionId]);
    }

    public function subsectionedit(Request $request)
    {
        $id = $request->id;
        $data = Subsection::where('id',$id)->first();
        return response()->json(['data'=> $data]);   
    }

    public function subsectionupdate(Request $request)
    {
        $code = ARHelper::rmvsplcharcter($request->Name);
        $request->merge([
            'SubSectionCode' => $code,
        ]);

        $page = Subsection::select('SubSectionCode')->where('id',$request->id)->first();

        if($code != $page->SubSectionCode){
            DB::statement("ALTER TABLE reportsectionstatus DROP COLUMN ".$page->SubSectionCode);
        }
        
        $reportsectionstatus = Schema::hasColumn('reportsectionstatus',$code);

        if($reportsectionstatus == false){
            DB::statement("ALTER TABLE reportsectionstatus ADD ".$code." int(11) DEFAULT 0");
        }

        $input = $request->except('_token');
        $data = Subsection::where('id',$input['id'])->first();
        $data->update($input);
        $values = Pagesection::where('SubsectionName',$request->oldName)->update(['SubsectionName'=>$request->Name]);
        $values2 = Questions::where('Subsection',$request->oldName)->update(['Subsection'=>$request->Name]);
        return response()->json(['data'=> 'success','success'=> "Sub Section Updated Successfully!"]);
    }

    public function subsectiondata(Request $request)
    {
      if ($request->ajax()) {
            $data = Subsection::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-bs-toggle="modal" title="subsection" data-bs-target="#sub-section" class="subsectionedit" id="subsectionedit'.$row->id.'" data-id="'.$row->id.'" data-original-title="view"><i class="fa fa-edit"></i></a>';
                    $btn = $btn.'   <a href="javascript:void(0)" data-toggle="tooltip" section-id="sub" class="subsectiondel"  id="subsectiondel'.$row->id.'"  data-id="'.$row->id.'" data-original-title="Delete" data-bs-toggle="modal" data-bs-target="#delete-section"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } 
    }

    public static function subsectiondelete(Request $request)
    {
        $id = $request->id;

        $sub = Subsection::select('Name')->where('id',$id)->first();
        $page = Pagesection::select('Name')->where('SubsectionName',$sub['Name'])->count();

        if($page != 0){

            return response()->json(['failed'=> "Page section are exist do not delete the sub section!"]);

        }else{

            $page = Subsection::select('SubSectionCode')->where('id',$id)->first();

            $reportsectionstatus = Schema::hasColumn('reportsectionstatus',$page->SubSectionCode);
            if($reportsectionstatus == true){
                DB::statement("ALTER TABLE reportsectionstatus DROP COLUMN ".$page->SubSectionCode);
            }

            $Question = Subsection::where('id',$id)->delete();
            return response()->json(['success'=> "Sub Section deleted Successfully!"]);
        }
    }

    
}
