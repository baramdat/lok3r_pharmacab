<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Plan;
use App\Models\Violation;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class authController extends Controller
{
    // register user
    public function registerUser(Request $request){
        

        $validator=Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
        ]);
        if($validator->fails()){

            return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
        }

        $user =new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $usr=User::where('id',$user->id)->first();
        $usr->assignRole('Member');
     
        if($user){
            return response()->json([
                'status'=>'success',
                'msg'=>'User Account Created Successfully'
            ],200);
            
        }else{
            

            // if(! empty($user)){
            //     Auth::login($user);
            // }

            Mail::send('templates.email.register_user', ['user' => $user,'password'=>$request->password ], function ($message) use ($user) {
                $message->to($user->email)
                    ->from('noreply@baramdatsol.com','Buzono')
                    ->subject("User Account");
            });

            return response()->json([
                'status'=>'fail',
                'msg'=>'Email has been already exist'
            ],200);
        } 
           
    }

    // login
    public function login(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required',

        ]);
        if($validator->fails()){
            return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
        }
        try {

            if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
                if (Auth::user()->status=='1'){
                    $user=Auth::user();

                    $responseArray=$user->createToken('app')->accessToken;


                    return response()->json(['status'=>'success','token'=>$responseArray, 'msg'=>'You have successfully login']);
                }else{
                    Auth::logout();
                    return response()->json(['status'=>'fail','msg'=>'Your account is not active Yet']);
                }

            }
        }catch(\Exception $exception ){
            return response()->json([
                'status'=>'server',
                'msg'=>$exception->getMessage()
            ],400);
        }

        return response()->json([
            'status'=>'fail',
            'msg'=>'Invalid Email/Password'
        ]);

    }

    public function logout(Request $request)
    {
            Auth::logout();
            return redirect()->route('login');
    }

    ///---------Forgot Password--------------///


    public function submitForgetPasswordForm(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'email' => 'required|email|exists:users',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
        }
        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        $user = User::where('email',$request->email)->first();

        Mail::send('templates.email.forgot_password', ['token' => $token, 'user' => $user], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
            $message->from('noreply@baramdatsol.com','Dealer Reg');
        });

        return response()->json(['status'=>'success','msg'=> 'We have emailed your password reset link, please checkout your mail']);
    }

    public function showResetPasswordForm($token){
        return view('templates.auth.reset_password', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
        }

        $updatePassword = DB::table('password_resets')
            ->where([
                'token' => $request->token
            ])
            ->first();

        if(empty($updatePassword)){

            return response()->json(['status'=>'fail','msg'=>'Invalid token']);
        }else{

            $user = User::where('email', $updatePassword->email)
                ->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')->where(['email'=> $updatePassword->email])->delete();


            return response()->json(['status'=>'success','msg'=>'Your password has been changed']);

        }

    }
}
