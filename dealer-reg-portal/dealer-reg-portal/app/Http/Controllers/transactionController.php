<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Contact;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str;

class transactionController extends Controller
{
    // add tansaction
    public function addTransaction(Request $request){

        // $validator=Validator::make($request->all(),[
        //     'as'=>'required',
        //     'description'=>'required',
        //     'photo'=>'required',
        // ]);
        // if($validator->fails()){
        //     return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
        // }
        $transactions =new Transaction();
        
        $transactions->trans_state = $request->trans_state; 
        $transactions->trans_type = $request->trans_type;
        $transactions->reg_type = $request->reg_type; 
        $transactions->is_finance = $request->is_finance; 
        $transactions->add_info = $request->add_info; 
        $transactions->num_lease = $request->num_lease; 
        $transactions->lien = $request->lien; 
        $transactions->on_lease = $request->on_lease; 
        $transactions->veh_type = $request->veh_type; 
        $transactions->veh_id_num = $request->veh_id_num; 
        $transactions->veh_year = $request->veh_year; 
        $transactions->veh_make = $request->veh_make; 
        $transactions->veh_model = $request->veh_model; 
        $transactions->veh_color = $request->veh_color; 
        $transactions->veh_mile = $request->veh_mile; 
        $transactions->total_price = $request->total_price; 
        $transactions->trade_ins = $request->trade_ins; 
        $transactions->amount = $request->amount; 
        $transactions->veh_weight = $request->veh_weight; 
        $transactions->cylinders = $request->cylinders; 
        $transactions->fuel_type = $request->fuel_type; 
        $transactions->gross_weight = $request->gross_weight; 
        $transactions->registrant_1 = $request->registrant_1; 
        $transactions->registrant_2 = $request->registrant_2; 
        $transactions->owner_1 = $request->owner_1; 
        $transactions->owner_2 = $request->owner_2; 
        $transactions->social = $request->social; 
        $transactions->transaction_for = $request->transaction_for; 
        $transactions->comapny_name = $request->comapny_name; 
        $transactions->customer_address = $request->customer_address; 
        $transactions->customer_address_2 = $request->customer_address_2; 
        $transactions->city = $request->city; 
        $transactions->state = $request->state; 
        $transactions->zip_code = $request->zip_code;  
        $transactions->save();

        return response()->json([
            'status'=>'success',
            'msg'=>'Service Created Successfully'
        ],200);
    }


     // pending transaction count
     public function pendingCount(Request $request){
        $filterStatus=$request->filterStatus;
        $filterTitle=$request->filterTitle;
        $filterLength=$request->filterLength;
        $result=Transaction::query();
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

    // pending transaction append data  
    public function pendings(Request $request){
        $filterStatus=$request->filterStatus;
        $filterTitle=$request->filterTitle;
        $filterLength=$request->filterLength;
        $result=Transaction::query();
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
                    <a class="dropdown-item btnEdit" href="/transaction/edit/'.$service->id.'"><i
                            class="fe fe-edit me-2"></i> Edit</a>

                    <a class="dropdown-item btnDelete" href="javascript:void(0)" id="'.$service->id.'"><i
                            class="fe fe-trash me-2"></i>
                        Delete</a>
                    ';

                    $html.='
                    <tr class="border-bottom " >
                    <td class="text-center">
                        <div class="mt-0 mt-sm-2 d-block">
                            <h6 class="mb-0 fs-14 ">
                            '.$service->id.'</h6>
                        </div>
                    </td>
                    <td class="detail" >
                        <div class="ms-3 mt-0 mt-sm-2 d-block">
                            <h6 class="mb-0 fs-14 ">
                                '.$service->registrant_1 .'</h6>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <div class="mt-0 mt-sm-3 d-block">
                                <h6 class="mb-0 fs-14 ">
                                '.$service->trans_state.'</h6>
                            </div>
                        </div>
                    </td>
                    <td><span class="mt-sm-2 d-block">Lien Correction</span></td>

                    <td>
                        <div id="steps" style="width:10% !important;">
                            <div class="step active" data-stepnum="0"
                                data-desc="Received"><i
                                    class="fas fa-shipping-fast"></i><i
                                    class="icon-ok"></i></div>
                            <div class="step" data-stepnum="1"
                                data-desc="Submitted for review"><i
                                    class="fas fa-shipping-fast"></i></div>
                            <div class="step" data-stepnum="2" data-desc="Sent to DMV">
                                <i class="fas fa-shipping-fast"></i></div>
                            <div class="step" data-stepnum="3"
                                data-desc="Pending Information"><i
                                    class="fas fa-shipping-fast"></i></div>
                            <div class="step" data-stepnum="4" data-desc="Completed"><i
                                    class="fas fa-shipping-fast"></i></div>
                        </div>
                    </td>
                    <td>
                    <div class="g-2">
                        <a href="/transaction/edit/'.$service->id.'"
                            class="btn text-primary btn-sm" data-bs-toggle="tooltip"
                            data-bs-original-title="Edit"><span
                                class="fe fe-edit fs-14"></span></a>
                        <a class="btn text-danger btn-sm btnDelete"
                            data-bs-toggle="tooltip"
                            data-bs-original-title="Delete"><span
                                class="fe fe-trash-2 fs-14"></span></a>
                    </div>
                </td>
                </tr>
                        ';
            }
            return response()->json(['status'=>'success','rows'=>$html]);
        }else{
            return response()->json(['status'=>'fail','msg'=>'No User Found!']);
        }
    } 

    // edit transaction 
    public function editTransaction($id){
        $transaction=Transaction::where('id',$id)->first();
        if (! empty($transaction) ){ 
            return view('templates.transactions.edit_transaction',['transaction'=>$transaction]);
        }else{
            return view('templates.404');
        }
    }
}
 