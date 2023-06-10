<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\resourcefiles;
use Yajra\DataTables\DataTables;

class ResourceFileController extends Controller {

   public function resourceindex(){
        return view('backend.includes.resourcedocuments');
   }

   public function resourcefilesget(Request $request)
   {
      if ($request->ajax()) {
            $data = resourcefiles::orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action', function($row){
                     $btn = '';
                     $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" class="resourcefilesedit" id="resourcefilesedit'.$row->id.'" data-id="'.$row->id.'" data-original-title="view"><i class="fa fa-edit"></i></a>';
                     $btn = $btn.'   <a href="javascript:void(0)" data-toggle="tooltip" class="resourcefilesdel"  id="resourcefilesdel'.$row->id.'"  data-id="'.$row->id.'" data-original-title="Delete"><i class="fa fa-trash"></i></a>';
                     return $btn;
                 })
                 ->rawColumns(['action'])
                 ->make(true);
      } 
   }

   public function ResourceUploadFile(Request $request)
   {
         $file = $request->file('resource');
         $filename = $file->getClientOriginalName();
         // File extension
         $extension = $file->getClientOriginalExtension();

         // File upload location
         $location = 'resourcefiles';

         $input = ([
           'resource' => $file->getClientOriginalName()
         ]);

         $resourcefiles = new resourcefiles($input);
         $resourcefiles->save();

         // Upload file
         $file->move($location,$filename);

         // File path
         $filepath = url('resourcefiles/'.$filename);

         // Response
         $data['success'] = 1;
         $data['message'] = 'Uploaded Successfully!';
         $data['filepath'] = $filepath;
         $data['extension'] = $extension;
         
      return response()->json($data);
   }

   public function resourcefilesview(Request $request)
    {
        $reqId = $request->all();
        $fileData = resourcefiles::where('id',$reqId)->get();
        $fileDataVal = $fileData[0];
        return response()->json(['fileData'=> $fileDataVal]);
    }

    public function resourcefilesupdate(Request $request)
    {
        
        $input = $request->except('_token');
        
        $reqId = $request->id;
        $unavailabeData = resourcefiles::where('id',$reqId)->update($input);

        return response()->json(['success'=> 'Updated Successfully']);
    }


    public function destroyresourcefile(Request $request)
    {
        $reqId = $request->id;
        $resourcefilesData = resourcefiles::find($reqId);
        if($resourcefilesData != null){
            $filename = $resourcefilesData->resource;
            // File path
            $filepath = 'resourcefiles/'.$filename;
            unlink($filepath);
        }
        $resourcefilesData->delete();
        return response()->json(['resourcefilesData' => 'delete success']);
    }

} 