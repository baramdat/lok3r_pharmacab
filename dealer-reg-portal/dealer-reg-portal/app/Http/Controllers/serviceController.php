<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Contact;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str;

class serviceController extends Controller
{
    // add service
    public function addService(Request $request){

        $validator=Validator::make($request->all(),[
            'service_name'=>'required',
            'description'=>'required',
            'photo'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
        }
        $services =new Service();
        
        $services->service_name = $request->service_name; 
        $services->description = $request->description;

        if($request->photo)
        {
            $currentimage=$services->photo;
            $image=$request->photo;
            $img_name=time().'-'.$image->getClientOriginalName();
            $path=public_path('/uploads/files/');
            $image->move($path,$img_name);
            $services->photo=$img_name;
        }

        $services->save();

        return response()->json([
            'status'=>'success',
            'msg'=>'Service Created Successfully'
        ],200);
    }
 
    // service count
    public function serviceCount(Request $request){
        $filterStatus=$request->filterStatus;
        $filterTitle=$request->filterTitle;
        $filterLength=$request->filterLength;
        $result=Service::query();
        if ($filterTitle !=''){
            $result = $result->where('service_name', 'like', '%' . $filterTitle . '%');
        }
        if ($filterStatus !='All'){
            $result=$result->where('status',$filterStatus);
        }
        $count = $result->take($filterLength)->count();
        if ($count>0){
            return response()->json(['status'=>'success','data'=>$count]);
        }else{
            return response()->json(['status'=>'fail','msg'=>'No Data Found']);
        }

    }

    // append data  
    public function services(Request $request){
        $filterStatus=$request->filterStatus;
        $filterTitle=$request->filterTitle;
        $filterLength=$request->filterLength;
        $result=Service::query();
        if ($filterTitle !=''){
            $result = $result->where('service_name', 'like', '%' . $filterTitle . '%');
        }
        if ($filterStatus !='All'){
            $result=$result->where('status',$filterStatus);
        }
        $services = $result->take($filterLength)->skip($request->offset)->orderBy('id','DESC')->get();
        if (isset($services) && sizeof($services)>0){
            $html='';
            foreach ($services as $service){
                if ($service->photo==NULL){
                    $img='<img class="card-img-right h-100"
                    src="'.asset('assets/images/media/22.jpg').'" alt="img">';
                }elseif(file_exists("uploads/files/".$service->photo)){
                    $img='<img src="'.asset('uploads/files/'.$service->photo).'"
                        class="card-img-right h-100" alt="img">';
                }elseif (!file_exists("uploads/files/".$service->photo)){
                    $img='<img class="card-img-right h-100" alt="img"
                    src="'.asset('assets/images/media/22.jpg').'">';
                }
                if ($service->status=="1"){
                    $status="Active";
                    $bg="bg-success";
                }else{
                    $status="Block";
                    $bg="bg-danger";
                } 
                               
                $btn = '
                    <a class="dropdown-item btnEdit" href="/service/edit/'.$service->id.'"><i
                            class="fe fe-edit me-2"></i> Edit</a>

                    <a class="dropdown-item btnDelete" href="javascript:void(0)" id="'.$service->id.'"><i
                            class="fe fe-trash me-2"></i>
                        Delete</a>
                    ';

                $html.='
                <div class="col-xl-6">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-4 ps-3 ps-md-0" style="object-fit: cover;" >
                                '.$img.'
                            </div>
                            <div class="col-md-8 ">
                                <div class="card-body pt-3">
                                    <div class="row">

                                        <div class="col-9">
                                            <h4 class="card-title">'.$service->service_name.'</h4>
                                            <p class="card-text">'.$service->description.'.</p>
                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                        </div>
                                        <div class="col-3 text-end">
                                            <div class="ms-auto mt-1 file-dropdown">
                                                <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"><i
                                                        class="fe fe-more-vertical fs-18"></i></a>
                                                <div class="dropdown-menu dropdown-menu-start">
                                                    '.$btn.'
                                                </div>
                                            </div>
                                        </div>
                                    </div>        
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                ';
            }
            return response()->json(['status'=>'success','rows'=>$html]);
        }else{
            return response()->json(['status'=>'fail','msg'=>'No User Found!']);
        }
    } 

    // delete service
    public function deleteService($id){
        $services=Service::find($id);
        $currentImage=$services->photo;
        $path = public_path().'/uploads/files/';

        if (file_exists($path.$currentImage)){
            @unlink($path.$currentImage);
        }
        $services->delete();
        if ($services){
            return response()->json(['status'=>'success','msg'=>'Service is Deleted']);
        }
        return response()->json(['status'=>'fail','msg'=>'failed to delete Service']);
    }

    // edit service
    public function editService($id){
        $services=Service::where('id',$id)->first();

        if ($services){
            return view('templates/services/service_edit',['service'=>$services]);
        }else{
            return view('templates.404');
        }
    }

    // update service
    public function updateService(Request $request){ 

        $services =Service::find($request->id);
        if($request->photo)
        {
            $currentimage=$services->photo;
            $image=$request->photo;
            $img_name=time().'-'.$image->getClientOriginalName();
            $path=public_path('/uploads/files/');
            $image->move($path,$img_name);
            if(file_exists($path.$currentimage))
            {
                @unlink($path.$currentimage);
            }
            $services->photo=$img_name;
        }
       
        $services->service_name= $request->service_name;
        $services->description = $request->description;
        $services->status = $request->status;

        if($services->save()){
            return response()->json([
                'status'=>'success',
                'msg'=>'Service Updated Successfully'
            ],200);
            
        }else{
            return response()->json([
                'status'=>'fail',
                'msg'=>'something went wrong'
            ],200);
        }
        
    }
}
 