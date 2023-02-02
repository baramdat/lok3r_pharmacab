<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Contact;
use App\Models\Generalcontact;
use App\Models\Mailingaddress;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str;

class contactController extends Controller
{
    #################### Contact form ###################
     
    public function contact(Request $request){

        $validator=Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'message'=>'required',
            'email'=>'required|email',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
        }

        
        $contact =new Contact();
        
        $contact->first_name = $request->first_name; 
        $contact->last_name = $request->last_name;
        $contact->email = $request->email; 
        $contact->message=$request->message;
        $contact->save();

        // Mail::send('templates.email.add_user', ['user' => $user,'password'=>$pin ], function ($message) use ($user) {
        //     $message->to($user->email)
        //         ->from('noreply@baramdatsol.com','Dealer Reg')
        //         ->subject("User Account");
        // });

        // $responseArray=[];
        // $responseArray['token']=$usr->createToken('dealer reg')->accessToken;


        return response()->json([
            'status'=>'success',
            'msg'=>'Message has sent successfully'
        ],200);
    }


    ######################## General contact #######################
    public function addGeneral(Request $request){
        // return "hello";  
        $gen_contact =new Generalcontact();
        $gen_contact->email =$request->email;
        $gen_contact->ph_number =$request->ph_number;
        $gen_contact->fax_number =$request->fax_number;
        $gen_contact->website =$request->website;

        $gen_contact->save();

        return response()->json(['status'=>'success','msg'=>'General Contact has been added successfully']);
    }

    public function editGeneral(Request $request){
        $gen_contact = Generalcontact::where('id',$request->general)->first();        // $request->general  request to ajax
        // dd($gen_contact);
        if(!$gen_contact){
            return response()->json([
                'status'=>'error',
                'message'=>'General contact not Found'
            ],400);
        }else{
            return response()->json([
                'status'=>'success',
                'data'=>$gen_contact
            ]);
        }

    }

    public function updateGeneral(Request $request){
        $gen_contact= Generalcontact::where('id',$request->general_id)->first();
        $gen_contact->email =$request->email;
        $gen_contact->ph_number =$request->ph_number;
        $gen_contact->fax_number =$request->fax_number;
        $gen_contact->website =$request->website;
        if($gen_contact->save()){
            return response()->json([
                'status'=>'success',
                'msg'=>'General Contact Updated Successfully'
            ],200);
            
        }else{
            return response()->json([
                'status'=>'fail',
                'msg'=>'something went wrong'
            ],200);
        }

    }

    public function deleteGeneral(Request $request)
    {

        $gen_contact = Generalcontact::find($request->general);  // $request->role  request to ajax

        if (!$gen_contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'General contact not found'
            ], 400);
        }

        if ($gen_contact->delete()) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'General contact can not be deleted'
            ], 500);
        }
    }

     ######################## Mailing information #######################
     public function addMailing(Request $request){
        // return "hello";  
        $mailing_info =new Mailingaddress();
        $mailing_info->dealer_reg_address =$request->dealer_reg_address;
        $mailing_info->suite_number =$request->suite_number;
        $mailing_info->eip_code =$request->eip_code;
        $mailing_info->save();

        return response()->json(['status'=>'success','msg'=>'Mailing information has been added successfully']);
    }

    public function editMailing(Request $request){
        $mailing_info = Mailingaddress::where('id',$request->mailing)->first();        // $request->general  request to ajax
        // dd($gen_contact);
        if(!$mailing_info){
            return response()->json([
                'status'=>'error',
                'message'=>'Mailing information not Found'
            ],400);
        }else{
            return response()->json([
                'status'=>'success',
                'data'=>$mailing_info
            ]);
        }

    }

    public function updateMAiling(Request $request){
        $mailing_info= Mailingaddress::where('id',$request->mailing_id)->first();
        $mailing_info->dealer_reg_address =$request->dealer_reg_address;
        $mailing_info->suite_number =$request->suite_number;
        $mailing_info->eip_code =$request->eip_code;
        if($mailing_info->save()){
            return response()->json([
                'status'=>'success',
                'msg'=>'Mailing Information Updated Successfully'
            ],200);
            
        }else{
            return response()->json([
                'status'=>'fail',
                'msg'=>'something went wrong'
            ],200);
        }

    }

    public function deleteMailing(Request $request)
    {

        $mailing_info = Mailingaddress::find($request->mailing);  // $request->role  request to ajax

        if (!$mailing_info) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mailing information not found'
            ], 400);
        }

        if ($mailing_info->delete()) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Mailing information can not be deleted'
            ], 500);
        }
    }
}
 