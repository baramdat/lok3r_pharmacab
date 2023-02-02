<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Inventory_items;
use App\Models\Inventory_record;
use Illuminate\Http\Request;

use App\Models\User; 
use App\Models\Locker;
use App\Models\Locker_history;
use App\Models\LockerSize;

Use Exception;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str;

class LockerController extends Controller
{
    //add
    public function add(Request $request){        
        try
        {
            $validator = Validator::make($request->all(),[
                'number'=>'required',
                'size_id'=>'required',
                'row'=>'required',
                'column'=>'required',
                'site_id'=>'required',
                'relay'=>'required',
            ]);
    
            if($validator->fails()){
                return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
            }
    
            $locker = new Locker();

            if (Locker::where('number',$request->number)->where('site_id',$request->site_id)->exists()){
                return response()->json(['status'=>'fail','msg'=>'Same locker already added!']);
            }

            if (Locker::where('relay',$request->relay)->where('site_id',$request->site_id)->exists()){
                return response()->json(['status'=>'fail','msg'=>'Same site locker is already added!']);
            }
    
            $locker->number = strtoupper($request->number);
            $locker->size_id = $request->size_id;
            $locker->site_id = $request->site_id;
            $locker->row = $request->row; 
            $locker->column = $request->column; 
            $locker->relay = $request->relay; 
            $locker->comment = $request->comment; 
            $locker->status = 'available';
    
            if($locker->save()){
                return response()->json([
                    'status'=>'success',
                    'msg'=>'Locker has been added successfully'
                ],200);
            }else{
                return response()->json([
                    'status'=>'fail',
                    'msg'=>'Failed to add the locker'
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

    public function add_history(Request $request){
        try
        {
            $validator = Validator::make($request->all(),[
                'locker_opening_reason'=>'required',
                'product'=>'required',
                'quantity'=>'required',
                'product_action'=>'required',
            ]);
            if($validator->fails()){
                return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
            }
            $history = new Inventory_record();
            $history->notes = $request->locker_opening_reason;
            $history->locker_id = $request->locker_id_history;
            $history->user_id = Auth::user()->id;
            $history->site_id = Auth::user()->site_id; 
            $history->item_id = $request->product; 
            if($request->product_action=='sub'){
                $inventory=Inventory::where('item_id',$request->product)->first();
                if($request->quantity>$inventory->quantity){
                    return response()->json(['status'=>'fail','msg'=>'You can not take given number of product']);
                }
                $quantity=$inventory->quantity-$request->quantity;
                 $inventory->quantity=$quantity;
                 $inventory->last_quantity='-'. $request->quantity;
                 $inventory->save();
                 $history->quantity ='-'. $request->quantity;
            }else{
                $inventory=Inventory::where('item_id',$request->product)->first();
                $quantity=$inventory->quantity+$request->quantity;
                 $inventory->quantity=$quantity;
                 $inventory->last_quantity='+'. $request->quantity;
                 $inventory->save();
                 $history->quantity ='+'. $request->quantity;
            }
            if($history->save()){
                return response()->json([
                    'status'=>'success',
                   // 'msg'=>'Locker has been added successfully'
                ],200);
            }else{
                return response()->json([
                    'status'=>'fail',
                    'msg'=>'Failed to add the locker'
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
                'number'=>'required',
                'size_id'=>'required',
                'row'=>'required',
                'column'=>'required',
                'site_id'=>'required',
                'relay'=>'required',
            ]);
    
            if($validator->fails()){
                return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
            }

            if(Locker::where('number',$request->number)->where('site_id',$request->site_id)->where('id','!=',$request->id)->exists()){
                return response()->json(['status'=>'fail','msg'=>'Same relay locker is already exists']);
            }

            if(Locker::where('relay',$request->relay)->where('site_id',$request->site_id)->where('id','!=',$request->id)->exists()){
                return response()->json(['status'=>'fail','msg'=>'Same relay locker is already exists']);
            }
            
            $locker = Locker::find($request->id);
       
            $locker->number = strtoupper($request->number);
            $locker->size_id = $request->size_id;
            $locker->site_id = $request->site_id;
            $locker->row = $request->row; 
            $locker->column = $request->column; 
            $locker->relay = $request->relay; 
            $locker->comment = $request->comment; 
            $locker->status = $request->status; 
            if($request->status == 'available'){
                $locker->booking_id = 0; 
                $locker->occupied_by = 0; 
                $locker->occupied_until = ''; 
            }
    
            if (Locker::where('number',$request->number)->where('id','!=',$locker->id)->exists()){
                return response()->json(['status'=>'fail','msg'=>'Same locker already exits!']);
            }
    
            if($locker->save()){
                return response()->json([
                    'status'=>'success',
                    'msg'=>'Locker updated'
                ],200);
                
            }else{
                return response()->json([
                    'status'=>'fail',
                    'msg'=>'Failed to update the locker'
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
        if(!Auth::user()->hasRole('Site User')){
            if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff')){
                $locker = Locker::where('id',$id)->where('site_id',Auth::user()->site->id)->first();
                if (!empty($locker) ){ 
                    return view('templates/locker/edit',['locker'=>$locker]);
                }else{
                    return view('templates.404');
                }
            }else{
                $locker = Locker::where('id',$id)->first();
                if (!empty($locker) ){ 
                    return view('templates/locker/edit',['locker'=>$locker]);
                }else{
                    return view('templates.404');
                }
            }
        }else{
            return view('templates.404');
        }                
    }
    public function lockerList(Request $request){
          $inventory_item=Inventory_items::all();
        return view('templates.locker.list',compact('inventory_item'));
    }
    public function viewPurchaseHistory($id){
        $locker = Locker::where('id',$id)->first();
        if (!empty($locker) ){ 
            return view('templates/locker/purchase_history',['locker'=>$locker]);
        }else{
            return view('templates.404');
        }
    }

    public function viewDetails($id){
        if(!Auth::user()->hasRole('Site User')){
            if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff')){
                $locker = Locker::where('id',$id)->where('site_id',Auth::user()->site->id)->first();
                if (!empty($locker) ){ 
                    return view('templates/locker/detail',['locker'=>$locker]);
                }else{
                    return view('templates.404');
                }
            }else{
                $locker = Locker::where('id',$id)->first();
                if (!empty($locker) ){ 
                    return view('templates/locker/detail',['locker'=>$locker]);
                }else{
                    return view('templates.404');
                }
            }
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
            $locker = Locker::find($id);
        
            if ($locker->delete()){
                return response()->json(['status'=>'success','msg'=>'Locker has been deleted']);
            }
            return response()->json(['status'=>'fail','msg'=>'Failed to delete the locker']);
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
            $filterLockerNo = $request->filterLockerNo;
            $filterSize = $request->filterSize;
            $filterRow = $request->filterRow;
            $filterColumn = $request->filterColumn;
            // $filterTitle=$request->filterTitle;
            // $filterLength=$request->filterLength;
            $result = Locker::query();
            if ($filterLockerNo !=''){
                $result = $result->where('number','like','%' . $filterLockerNo . '%');
            }

            if ($filterRow !=''){
                $result = $result->where('row',$filterRow);
            }

            if ($filterColumn !=''){
                $result = $result->where('column',$filterColumn);
            }

            if ($filterSize !='all'){
                $result = $result->where('size_id',$filterSize);
            }

            if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff')){
                $result = $result->where('site_id',Auth::user()->site->id);
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

    public function historyCount(Request $request){
        try {
            $filterLockerNo = $request->filterLockerNo;
            $locker_history=Inventory_record::query();
            if(!Auth::user()->hasRole('Super Admin')){
                $locker_history=$locker_history->where('site_id', Auth::user()->site_id);
            }
            if ($filterLockerNo !=''){
                $locker_history= $locker_history->whereHas(
                    'locker',
                    function ($q) use ($filterLockerNo) {
                        $q->where('lockers.number', 'like', '%' . $filterLockerNo . '%');
                    }
                );
            }

            $count = $locker_history->count();
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
            $filterLockerNo = $request->filterLockerNo;
            $filterSize = $request->filterSize;
            $filterRow = $request->filterRow;
            $filterColumn = $request->filterColumn;
            $filterLength=$request->filterLength;
            $result = Locker::query();
            if ($filterSize !='all'){
                $result = $result->where('size_id',$filterSize);
            }

            if ($filterRow !=''){
                $result = $result->where('row',$filterRow);
            }

            if ($filterColumn !=''){
                $result = $result->where('column',$filterColumn);
            }

            if ($filterLockerNo !=''){
                $result = $result->where('number','like','%' . $filterLockerNo . '%');
            }

            if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff')){
                $result = $result->where('site_id',Auth::user()->site->id);
            }
            
            $i = 1;

            $lockers = $result->take($filterLength)->skip($request->offset)->orderBy('id','DESC')->get();
            if (isset($lockers) && sizeof($lockers)>0){
                $html='';
                foreach ($lockers as $locker){
                    $html.='
                        <tr class="border-bottom"> 
                            <td>'.$i++.'</td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 fw-semibold">
                                '.ucwords($locker->number).'
                                    </h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.ucwords($locker->site->name).'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$locker->relay.'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$locker->size->size.'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$locker->column.'</h6>
                            </td>

                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$locker->row.'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.self::status($locker->status).'
                                '.($locker->status == 'occupied' ? ' <b>By</b> '.$locker->occupied->email : '').'

                                '.($locker->status == 'inactive' ? ' <b>Since</b> '.date('m/d/Y',strtotime($locker->updated_at)) : '').'
                                </h6>
                            </td>
                            <td>
                                <a  href="javascript:;" state="2" lockerId="'.$locker->id.'" relay="'.$locker->relay.'" class="btn btn-danger btn-sm relayState">Open Locker</a>

                                <a  href="/locker/details/'.$locker->id.'" class="btn btn-info btn-sm">Details</a>

                                '.($locker->status == 'occupied' ? '<small>Can’t be made inactive or be deleted</small>' : '<div class="btn-group btn-group-sm" role="group">
                                <a  href="/locker/edit/'.$locker->id.'" class="btn btn-warning btnEdit">Edit</a>
                                <a  class="btn btn-danger text-white btnDelete" id="'.$locker->id.'">Delete</a>
                            </div>').'
                                
                            </td>
                        </tr>
                    ';
                }
                return response()->json(['status'=>'success','rows'=>$html]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No Form Found!']);
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

    public function historyList(Request $request){
        try {
            $filterLockerNo = $request->filterLockerNo;
            $filterLength=$request->filterLength;
            $locker_history=Inventory_record::query();
            if(!Auth::user()->hasRole('Super Admin')){
                // $locker_history= Locker_history::join('users', 'users.id', '=', 'locker_history.user_id')
                // ->join('sites', 'sites.id', '=', 'locker_history.site_id')
                // ->join('lockers', 'lockers.id', '=', 'locker_history.locker_id');
                $locker_history=$locker_history->where('site_id', Auth::user()->site_id);
            }
            // else{
            //     $locker_history= Locker_history::join('users', 'users.id', '=', 'locker_history.user_id')
            //     ->join('sites', 'sites.id', '=', 'locker_history.site_id')
            //     ->join('lockers', 'lockers.id', '=', 'locker_history.locker_id')->where('locker_history.site_id', Auth::user()->site_id);
            // }
            if ($filterLockerNo !=''){
                $locker_history= $locker_history->whereHas(
                    'locker',
                    function ($q) use ($filterLockerNo) {
                        $q->where('lockers.number', 'like', '%' . $filterLockerNo . '%');
                    }
                );
                // $locker_history = $locker_history->where('lockers.number','like','%' . $filterLockerNo . '%');
            }

            $i = 1;

            $lockers = $locker_history->take($filterLength)->skip($request->offset)->orderBy('id','DESC')->get();
            if (isset($lockers) && sizeof($lockers)>0){
                $html='';
                foreach ($lockers as $locker){
                    $html.='
                        <tr class="border-bottom"> 
                            <td>'.$i++.'</td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 fw-semibold">
                                '.ucwords($locker->user->first_name).' '.ucwords($locker->user->last_name).'
                                    </h6>
                            </td>
                            <td>
                            <a href="'.url('products/list').'?id='.$locker->item_id.'">
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.ucwords($locker->inventory_item->name).'</h6></a>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.ucwords($locker->site->name).'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$locker->locker->number.'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$locker->quantity.'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$locker->notes.'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.date_format($locker->created_at, 'M d ,Y  H:i A').'</h6>
                            </td>
                        </tr>
                    ';
                }
                return response()->json(['status'=>'success','rows'=>$html]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No Form Found!']);
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
    // pricing
    public function pricing(Request $request){
        try {
            $result = LockerSize::where('id',$request->size_id)->first();
            if ($result){
                return response()->json(['status'=>'success','msg'=>'Locker size pricing has been found','data'=>$result[$request->duration]]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No size pricing found!','data'=>$request->size_id]);
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

    // delete
    public function isAvailable(Request $request){
        try{
            $lockers = Locker::where('size_id',$request->size_id)->where('site_id',Auth::user()->site->id)->where('status','available')->get();
        
            if (isset($lockers) && sizeof($lockers) > 0){                
                return response()->json(['status'=>'success','msg'=> sizeof($lockers).' lockers are available','data'=>$lockers]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No available lockers are found','data'=>sizeof($lockers)]);
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

    // price
    public function price(Request $request){
        try{
            $locker = LockerSize::where('size_id',$request->size_id)->first();
        
            if ($locker){
                return response()->json(['status'=>'success','msg'=> 'Locker size has been found','data'=>$locker]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No size found','data'=>'']);
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
        if($status == 'available'){
            $html = '<badge class="badge bg-success">Available</badge>';
        }else if($status == 'occupied'){
            $html = '<badge class="badge bg-warning">Occupied</badge>';
        }else if($status == 'inactive'){
            $html = '<badge class="badge bg-danger">Inactive</badge>';
        }else{
            $html = '<badge class="badge bg-danger">Inactive</badge>';
        }

        return $html;
    }

    // pricing update
    public function pricingUpdate(Request $request){ 
        try {

            $validator = Validator::make($request->all(),[
                'size_id'=>'required',
                'hourly'=>'required',
                'daily'=>'required',
                'monthly'=>'required'
            ]);
    
            if($validator->fails()){
                return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
            }

            $saved = false;
            $historyArr = array();

            foreach ($request->size_id as $key => $size_id) {
                $lockerSize = LockerSize::find($size_id);
                if($lockerSize){
                    $oldHourly = $lockerSize->hourly;
                    $oldDaily = $lockerSize->daily;
                    $oldMonthly = $lockerSize->monthly;
                    $date = date('Y-m-d');
                    $lockerSize->hourly = $request->hourly[$key];
                    $lockerSize->daily = $request->daily[$key];
                    $lockerSize->monthly = $request->monthly[$key];

                    if($lockerSize->save()){
                        $historyArr[$key]["size_id"] = $size_id;
                        $historyArr[$key]["hourly"] = $oldHourly;
                        $historyArr[$key]["daily"] = $oldDaily;
                        $historyArr[$key]["monthly"] = $oldMonthly;
                        $saved = true;
                    }
                }
            }
    
            if($saved){
                $pricingHistory = new PricingHistory();
                $pricingHistory->history = json_encode($historyArr);
                $pricingHistory->date = $date;
                $pricingHistory->save();

                return response()->json([
                    'status'=>'success',
                    'msg'=>'Locker prices updated'
                ],200);
                
            }else{
                return response()->json([
                    'status'=>'fail',
                    'msg'=>'Failed to update the locker prices'
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

    // pricing history list
    public function pricingHistory(Request $request){
        try {
            $pricingHistory = PricingHistory::get();
            $i = 1;

            if (isset($pricingHistory) && sizeof($pricingHistory)>0){
                $html='';
                foreach ($pricingHistory as $history){
                    $html.='
                        <tr class="border-bottom"> 
                            <td>'.$i++.'</td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$history->date.'</h6>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a  href="/pricing/history/'.$history->id.'" class="btn btn-warning btnEdit">View</a>
                                    <a  class="btn btn-danger text-white btnDelete" id="'.$history->id.'">Delete</a>
                                </div>
                            </td>
                        </tr>
                    ';
                }
                return response()->json(['status'=>'success','rows'=>$html, 'data'=>$pricingHistory]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No history found!']);
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
    
    // view pricing history by id
    public function pricingHistoryView($id){
        $pricingHistory = PricingHistory::find($id);
        if (!empty($pricingHistory)){
            return view('templates.pricing.history_detail',['pricingHistory'=>$pricingHistory]);
        }else{
            return view('templates.404',['pricingHistory'=>$pricingHistory]);
        }
    }

    // delete pricing history
    public function pricingHistoryDelete($id){
        try{
            $pricingHistory = pricingHistory::find($id);
        
            if ($pricingHistory->delete()){
                return response()->json(['status'=>'success','msg'=>'History has been deleted']);
            }
            return response()->json(['status'=>'fail','msg'=>'Failed to delete the history']);
        }
        catch(Exception $e)
        {
            return response()->json([
                'status'=>'fail',
                'msg'=>$e->getMessage()
            ],200); 
        }
    }

    // relay status
    public function relayState(){
        try{
            $url = env('RELAY_IP').'/state.xml';
            $session = curl_init($url);
            // set some options for curl
            curl_setopt($session, CURLOPT_HEADER, false); // don't return the header
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // return the result as a string
            curl_setopt($session, CURLOPT_CONNECTTIMEOUT, 300); // timeout if we don't connect after 3 seconds to the device
            $xml = curl_exec($session);
            
            $error_msg = "";
            if (curl_errno($session)) {
                $error_msg = curl_error($session);
            }

            curl_close($session);
            if ($xml){                
                $xml = self::xmlToArray($xml);
                $relayArr = [];
                $i = 0;
                if(is_array($xml)){
                    foreach ($xml as $key => $relay) {
                        if (strpos($key, 'relay') !== false) { 
                            $relayArr[$i]["relay"] = substr($key,5);
                            $relayArr[$i++]["state"] = $xml[$key];
                        }
                    }
                }                
                return response()->json(['status'=>'success','msg'=>'Relay states has been found','data'=>$relayArr]);
            }else{
                return response()->json(['status'=>'fail','msg'=>$error_msg]);
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

    // relay status
    public function relayStateUpdate(Request $request){
        try{
            $locker = Locker::find($request->lockerId);
            if($locker){
                // $url = $locker->site->url.'/state.xml?relay'.$request->relay.'State='.$request->state;
                // $session = curl_init($url);
                // // set some options for curl
                // curl_setopt($session, CURLOPT_HEADER, false); // don't return the header
                // curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // return the result as a string
                // curl_setopt($session, CURLOPT_CONNECTTIMEOUT, 300); // timeout if we don't connect after 3 seconds to the device

                // $locker = Locker::find($request->lockerId);

                // $xml = curl_exec($session);
                
                // $error_msg = "";
                // if (curl_errno($session)) {
                //     $error_msg = curl_error($session);
                // }

                // curl_close($session);
                // if ($xml){                
                //     $xml = self::xmlToArray($xml);
                //     $relayArr = [];
                //     $i = 0;
                //     if(is_array($xml)){
                //         foreach ($xml as $key => $relay) {
                //             if (strpos($key, 'relay') !== false) { 
                //                 $relayArr[$i]["relay"] = substr($key,5);
                //                 $relayArr[$i++]["state"] = $xml[$key];
                //             }
                //         }
                //     }                
                //     return response()->json(['status'=>'success','msg'=>'Locker '.strtoupper($locker->number).($request->state == 0 ? ' closed' : ' opened').' successfully','data'=>$relayArr]);
                // }else{
                //     return response()->json(['status'=>'fail','msg'=>$error_msg]);
                // }
            }else{
                return response()->json(['status'=>'fail','msg'=>'Locker not found']);
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

    public function xmlToArray($xmlstring){
    
        $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
      
        return $array;
      
    }
}
