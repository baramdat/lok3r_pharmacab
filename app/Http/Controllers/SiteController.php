<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User; 
use App\Models\Locker;
use App\Models\LockerSize;
use App\Models\Site;

Use Exception;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str;

class SiteController extends Controller
{
    //add
    public function add(Request $request){        
        try
        {
            $validator = Validator::make($request->all(),[
                'name'=>'required',
                'address'=>'required',
                'url'=>'required'
            ]);
    
            if($validator->fails()){
                return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
            }

            $site = new Site();

            if (Site::where('name',trim($request->name))->exists()){
                return response()->json(['status'=>'fail','msg'=>'Same site already added!']);
            }

            if (Site::where('url',trim($request->url))->exists()){
                return response()->json(['status'=>'fail','msg'=>'Site with same URL is already added!']);
            }
    
            $site->name = trim($request->name);
            $site->address = $request->address;
            $site->url = trim($request->url); 
    
            if($site->save()){
                return response()->json([
                    'status'=>'success',
                    'msg'=>'Site has been added successfully'
                ],200);
            }else{
                return response()->json([
                    'status'=>'fail',
                    'msg'=>'Failed to add the site'
                ],200);            
            }
        }
        catch(Exception $e)
        {
            return response()->json([
                'status'=>'fail',
                'msg'=>$e->getMessage()
            ],200); 
        }
    }

    // update
    public function update(Request $request){ 
        try {

            $validator = Validator::make($request->all(),[
                'name'=>'required',
                'address'=>'required',
                'url'=>'required',
                'status'=>'required',
            ]);
    
            if($validator->fails()){
                return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
            }

            if(Site::where('name',$request->name)->where('id','!=',$request->id)->exists()){
                return response()->json(['status'=>'fail','msg'=>'Site with same name is already exists']);
            }

            if(Site::where('url',$request->url)->where('id','!=',$request->id)->exists()){
                return response()->json(['status'=>'fail','msg'=>'Site with same URL is already exists']);
            }
            
            $site = Site::find($request->id);
       
            $site->name = trim($request->name);
            $site->address = $request->address;
            $site->url = trim($request->url); 
            $site->status = $request->status;

            if($site->save()){
                return response()->json([
                    'status'=>'success',
                    'msg'=>'Site updated'
                ],200);
                
            }else{
                return response()->json([
                    'status'=>'fail',
                    'msg'=>'Failed to update the site'
                ],200);
            }   
        }
        catch(Exception $e)
        {
            return response()->json([
                'status'=>'fail',
                'msg'=>$e->getMessage()
            ],200); 
        }        
    }

    public function viewEdit($id){
        $site = Site::where('id',$id)->first();
        if (!empty($site) ){ 
            return view('templates/site/edit',['site'=>$site]);
        }else{
            return view('templates.404');
        }
    }

    public function viewDetails($id){
        $site = Site::where('id',$id)->first();
        if (!empty($site) ){ 
            return view('templates/site/detail',['locker'=>$site]);
        }else{
            return view('templates.404');
        }
    }

    // view locker by id
    public function view($id){
        $locker = Locker::find($id);
        if (!empty($locker)){
            return view('templates.users.user_detail',['locker'=>$locker]);
        }else{
            return view('templates.404',['locker'=>$locker]);
        }
    }

    // delete
    public function delete($id){
        try{
            $site = Site::find($id);
        
            if ($site->delete()){
                return response()->json(['status'=>'success','msg'=>'Site has been deleted']);
            }
            return response()->json(['status'=>'fail','msg'=>'Failed to delete the site']);
        }
        catch(Exception $e)
        {
            return response()->json([
                'status'=>'fail',
                'msg'=>$e->getMessage()
            ],200); 
        }
    }

    // count
    public function count(Request $request){
        try {
            $filterName = $request->filterName;
            $filterStatus = $request->filterStatus;
            $result = Site::query();

            if ($filterName !=''){
                $result = $result->where('name','like','%' . $filterName . '%');
            }

            if ($filterStatus !='all'){
                $result = $result->where('status',$filterStatus);
            }  

            $count = $result->count();
            if ($count>0){
                return response()->json(['status'=>'success','data'=>$count]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No Data Found']);
            }
        }
        catch(Exception $e)
        {
            return response()->json([
                'status'=>'fail',
                'msg'=>$e->getMessage()
            ],200); 
        }
    }

    // list
    public function list(Request $request){
        try {
            $filterName = $request->filterName;
            $filterStatus = $request->filterStatus;
            $filterLength = $request->filterLength;
            $result = Site::query();

            if ($filterName !=''){
                $result = $result->where('name','like','%' . $filterName . '%');
            }

            if ($filterStatus !='all'){
                $result = $result->where('status',$filterStatus);
            }            
            
            $i = 1;

            $sites = $result->take($filterLength)->skip($request->offset)->orderBy('id','DESC')->get();
            if (isset($sites) && sizeof($sites)>0){
                $html='';
                foreach ($sites as $site){
                    $html.='
                        <tr class="border-bottom"> 
                            <td>'.$i++.'</td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 fw-semibold">
                                '.ucwords($site->name).'
                                    </h6>
                                <p class="text-muted"><i class="fa fa-map-marker text-primary"></i> '.ucwords($site->address).'</p>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                <a href="'.$site->url.'" target="_blank">'.$site->url.'</a></h6>
                            </td>

                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">'.self::status($site->status).'</h6>
                            </td>

                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a  href="/site/edit/'.$site->id.'" class="btn btn-warning btnEdit">Edit</a>
                                    <a  class="btn btn-danger text-white btnDelete" id="'.$site->id.'">Delete</a>
                                </div>
                            </td>
                        </tr>
                    ';
                }
                return response()->json(['status'=>'success','rows'=>$html,'data'=>$sites]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No Site Found!']);
            }
        }
        catch(Exception $e)
        {
            return response()->json([
                'status'=>'fail',
                'msg'=>$e->getMessage()
            ],200); 
        }
    }

    public static function status($status){
        $html = '';
        if($status == 'active'){
            $html = '<badge class="badge bg-success">Available</badge>';
        }else if($status == 'inactive'){
            $html = '<badge class="badge bg-danger">Inactive</badge>';
        }else{
            $html = '<badge class="badge bg-danger">Inactive</badge>';
        }

        return $html;
    }
}
