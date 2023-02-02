<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Contact;
use App\Models\Form;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str;

class formController extends Controller
{
    // drop zone functions 
    public function uploadFile(Request $request){
        $file=$request->file;
        $fileArr = array();
        if ($file){
            $path = public_path().'/uploads/files/';
            $fileNam=$file->getClientOriginalName();
            $ext=$file->getClientOriginalExtension();
            $size=$file->getSize(); 
            $imgHash = time().md5(rand(0,10));
            $filename =$imgHash.".".$ext;
            $move=$file->move($path, $filename);
            $fileArr["file"]["filename"] = $filename;
            $fileArr["file"]["name"] = $fileNam;
            $fileArr["file"]["ext"] = $ext; 
            $fileArr["file"]["size"] = $size;
            $fileArr["file"]["date"]=date('d-m-y');
            //$files=json_encode($fileArr);
            return response()->json(['status'=>'success','file'=>$fileArr]);
        }
        else{
            return response()->json(['status'=>'fail','msg'=>'Please select a file']);
        }
    }
    public function deleteFile(Request $request){

        $file=$request->file;
        if ($file){
            $path = public_path() .'/uploads/files/' ;
            //code for remove old file
            if ($file != '') {
                $file_old = $path . $file;
                if (file_exists($file_old)){
                    @unlink($file_old);
                }
            }
            return response()->json(['status'=>'success','msg'=>'File deleted successfully']);
        }else{
            return response()->json(['status'=>'fail','msg'=>'Failed to delete File']);
        }

    }


    // add form
    public function addForm(Request $request){

        $validator=Validator::make($request->all(),[
            'form_name'=>'required',
            'state'=>'required',
            'message'=>'required'
        ]);
        if($validator->fails()){

            return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
        }

        $forms =new Form(); 
        $forms->form_name = $request->form_name;
        $forms->state = $request->state;
        $forms->message = $request->message; 
        
        if (!empty($request->filesArr)){
            $forms->file=$request->filesArr;
        }else{ 
            return response()->json([
                'status'=>'fail',
                'msg'=>'Form file is missing'
            ],200);
        }

        if($forms->save()){
            return response()->json([
                'status'=>'success',
                'msg'=>'Forms has been added Successfully'
            ],200);

        }else{
            return response()->json([
                'status'=>'fail',
                'msg'=>'something went wrong'
            ],200);
            
        }
    }
        
    // form count
    public function formCount(Request $request){
        $filterName=$request->filterName;
        $filterState=$request->filterState;
        $filterLength=$request->filterLength;
        $result=Form::query();
        if ($filterState !='All'){
            $result=$result->where('state',$filterState);
        }
        if ($filterName !=''){
            $result = $result->where('form_name','like','%' . $filterName . '%');

        }
        $count = $result->take($filterLength)->count();
        if ($count>0){
            return response()->json(['status'=>'success','data'=>$count]);
        }else{
            return response()->json(['status'=>'fail','msg'=>'No Data Found']);
        }

    }

    // append data
    public function forms(Request $request){
        $filterName=$request->filterName;
        $filterState=$request->filterState;
        $filterLength=$request->filterLength;
        $result=Form::query();
        if ($filterState !='All'){
            $result=$result->where('state',$filterState);
        }
        if ($filterName !=''){
            $result = $result->where('form_name','like','%' . $filterName . '%');

        }
        
        $i = 1;

        $forms = $result->take($filterLength)->skip($request->offset)->orderBy('id','DESC')->get();
        if (isset($forms) && sizeof($forms)>0){
            $html='';
            $docExt = array(
                "pdf",
                "PDF",
            );
            foreach ($forms as $form){
                $files = json_decode($form->file);
                    if($files != NULL){
                       
                        foreach($files as $file){ 
                            
                            if(in_array($file->ext,$docExt)){ 
                                $html.='
                                        <tr class="border-bottom"> 
                                            <td>'.$i++.'</td>
                                            <td>
                                                <h6 class="mb-0 m-0 fs-14 fw-semibold">
                                                '.ucwords($form->form_name).'
                                                    </h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0 m-0 fs-14 ">
                                                '.$form->state.'</h6>
                                            </td>
                                            <td>
                                                <a class="text-truncate"  href="/uploads/files/'.$file->filename.'" download="'.$file->name.'">
                                                    <i class="fa fa-file fs-20 text-danger"></i> <em class="text-truncate">( '.$file->name.' )</em>
                                                </a>
                                            </td>

                                            <td>
                                                <h6 class="mb-0 m-0 fs-14 ">
                                                '.$form->message.'</h6>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a  href="/form/edit/'.$form->id.'" class="btn btn-warning btnEdit">Edit</a>
                                                    
                                                    <a class="btn btn-info text-white"  href="/uploads/files/'.$file->filename.'" download="'.$file->name.'">
                                                    View </a>
                                                    <a  class="btn btn-danger text-white btnDelete" id="'.$form->id.'">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    ';
                                        }
                        }
                    }

                
            }
            return response()->json(['status'=>'success','rows'=>$html]);
        }else{
            return response()->json(['status'=>'fail','msg'=>'No Form Found!']);
        }
    }

    // edit form  
    public function editForm($id){
        $forms=Form::where('id',$id)->first();
        if (! empty($forms) ){ 
            $files = json_decode($forms->file);
            return view('templates/forms/form_edit',['forms'=>$forms,'files'=>$files]);
        }else{
            return view('templates.404');
        }
    }
    // update form 
    public function updateForm(Request $request){

        $forms =Form::find($request->id);

        $forms->form_name = $request->form_name;
        $forms->state = $request->state;
        $forms->message = $request->message;

        if (!empty($request->filesArr)){
            $forms->file=$request->filesArr;
        }else{
            return response()->json([
                'status'=>'fail',
                'msg'=>'Document is missing'
            ],200);
        }
        
        if($forms->save()){
            return response()->json([
                'status'=>'success',
                'msg'=>'Form has been Updated Successfully'
            ],200);

        }else{
            return response()->json([
                'status'=>'fail',
                'msg'=>'something went wrong'
            ],200);
            
        }
        
    } 

    // delete form
    public function deleteForm($id){
        $forms=Form::find($id);
        $path = public_path().'/uploads/files/';
        $currentImage=$forms->file;
        if($currentImage !=NULL){
            $files = json_decode($currentImage);
            foreach($files as $file){
                if (file_exists($path.$file->filename)){
                    @unlink($path.$file->filename);
                }  
            }
        }
        $forms->delete();
        if ($forms){
            return response()->json(['status'=>'success','msg'=>'Form is Deleted']);
        }
        return response()->json(['status'=>'fail','msg'=>'failed to delete form']);
    }

  
}
