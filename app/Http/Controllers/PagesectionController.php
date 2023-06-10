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
use App\Models\ReportSectionStatus;
use App\Helpers\ARHelper;
use Yajra\DataTables\DataTables;
use DB;

class PagesectionController extends Controller
{
    
    public function pagesectionstore(Request $request)
    {
        $code = ARHelper::rmvsplcharcter($request->Name);
        $request->merge([
            'PageSectionCode' => $code,
        ]);
        $PagesectionColumn = $request->PagesectionColumn;
        $inColumn = str_replace(', ,',',',implode(", ",$PagesectionColumn));
        $request->merge([
            'PagesectionColumn' => $inColumn,
        ]);
        
        $input = $request->except('_token');
        $data = new Pagesection($input);
        $data->save();

        return response()->json(['success'=> "Page Section Created Successfully!"]);
    }


    public function pagesectionedit(Request $request)
    {
        $id = $request->id;
        $data = Pagesection::where('id',$id)->first();
        return response()->json(['data'=> $data]);
    }

    public function pagesectionupdate(Request $request)
    {
        $code = ARHelper::rmvsplcharcter($request->Name);
        $request->merge([
            'PageSectionCode' => $code,
        ]);

        $PagesectionColumn = $request->PagesectionColumn;
        $inColumn = str_replace(', ,',',',implode(", ",$PagesectionColumn));
        $request->merge([
            'PagesectionColumn' => $inColumn,
        ]);

        $input = $request->except('_token');
        $values = Questions::where('Pagesection',$request->oldName)->update(['Pagesection'=>$request->Name]);
        $data = Pagesection::where('id',$input['id'])->first();
        $data->update($input);
        return response()->json(['data'=> 'success','success'=> "Page Section Updated Successfully!"]);
    }

    public static function getpagesubsection(Request $request)
    {
        $data = $request->all();
        $pagesection = Pagesection::where('id','=',$data['val'])->first();
        $Subsection = Subsection::where('MainsectionName','=',$pagesection->MainsectionName)->get();
        return response()->json(['data'=> $Subsection]);
    }

    public function pagesectiondata(Request $request)
    {
      if ($request->ajax()) {
            $data = Pagesection::orderBy('Position', 'asc')->get();
       
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#page-section" class="pagesectionedit" id="pagesectionedit'.$row->id.'" data-id="'.$row->id.'" data-original-title="view"><i class="fa fa-edit"></i></a>';
                    $btn = $btn.'   <a href="javascript:void(0)" data-toggle="tooltip" section-id="page" class="Pagesectiondel"  id="Pagesectiondel'.$row->id.'"  data-id="'.$row->id.'" data-original-title="Delete" data-bs-toggle="modal" data-bs-target="#delete-section"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } 
    }

    public static function pagesectiondelete(Request $request)
    {
        $id = $request->id;
        $input = $request->all();
        $page = Pagesection::where('id',$id)->first();

        $question = Questions::select('Name')->where('Pagesection',$page['Name'])->count();

        if($question != 0){
            return response()->json(['failed'=> "Questions are exist do not delete the page section!"]);
        }else{
            $Question = Pagesection::where('id',$id)->delete();
            return response()->json(['success'=> "Page Section deleted Successfully!"]);
        }
    }

    public function updatepagesectionposition(Request $request)
    {
        foreach ($request->Position as $key => $Position) {
            $submain = Pagesection::find($Position['id'])->update(['Position' => $Position['Position']]);
        }
        return response()->json(['data'=> 'success']);
    }
    
}
