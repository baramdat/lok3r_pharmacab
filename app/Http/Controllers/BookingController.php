<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Locker;
use App\Models\LockerSize;
use App\Models\PricingHistory;
use App\Models\Booking;
use App\Models\Inventory_items;
use App\Models\Payment;

Use Exception;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str;
use Stripe;

class BookingController extends Controller
{
    // count
    public function count(Request $request){
        try {
            $filterLocker = $request->filterLocker;
            $filterDuration = $request->filterDuration;
            $filterStatus = $request->filterStatus;
            $filterUser = $request->filterUser;
            
            $result = Booking::query();
            if ($filterLocker !='all'){
                $result = $result->where('locker_id',$filterLocker);
            }

            if ($filterDuration !='all'){
                $result = $result->where('duration',$filterDuration);
            }

            if ($filterStatus !='all'){
                $result = $result->where('status',$filterStatus);
            }

            if($filterUser == 'User'){
                $result = $result->where('user_id',Auth::user()->id);
            }

            if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff')){
                $result = $result->where('site_id',Auth::user()->site->id);
            }
            
            $count = $result->count();
            if ($count > 0){
                return response()->json(['status'=>'success','data'=>$count]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No count found']);
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
            $filterLocker = $request->filterLocker;
            $filterDuration = $request->filterDuration;
            $filterStatus = $request->filterStatus;
            $filterLength = $request->filterLength;
            $filterUser = $request->filterUser;

            $result = Booking::query();
            if ($filterLocker !='all'){
                $result = $result->where('locker_id',$filterLocker);
            }

            if ($filterDuration !='all'){
                $result = $result->where('duration',$filterDuration);
            }

            if ($filterStatus !='all'){
                $result = $result->where('status',$filterStatus);
            }

            if($filterUser == 'User'){
                $result = $result->where('user_id',Auth::user()->id);
            }

            if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff')){
                $result = $result->where('site_id',Auth::user()->site->id);
            }
            
            $i = 1;

            $bookings = $result->take($filterLength)->skip($request->offset)->orderBy('id','DESC')->get();
            if (isset($bookings) && sizeof($bookings)>0){
                $html='';
                foreach ($bookings as $booking){
                    $html.='
                        <tr class="border-bottom"> 
                            <td>'.$i++.'</td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 fw-semibold">
                                '.$booking->id.'
                                    </h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.ucwords($booking->site->name).'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$booking->locker->number.'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.ucwords($booking->user->first_name)." ".$booking->user->last_name.'<br><small>'.$booking->user->email.'</small></h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$booking->duration.'</h6>
                            </td>

                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                From: <badge class="badge bg-success">'.date('m/d/Y h:i A',strtotime($booking->from)).'</badge> <br> Until: <badge class="badge bg-warning">'.date('m/d/Y h:i A',strtotime($booking->to)).'</badge></h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.self::status($booking->status).'</h6>
                            </td>
                            <td>
                                '.(strtotime($booking->to) > strtotime(date('m/d/Y H:i')) ? '<a  href="javascript:;" state="2" lockerId="'.$booking->locker->id.'" relay="'.$booking->locker->relay.'" class="btn btn-danger btn-sm relayState">Open Locker</a>' : '').'
                                <div class="btn-group btn-group-sm" role="group">
                                    <a  href="/booking/details/'.$booking->id.'" class="btn btn-info">View</a>
                                    <a  href="/booking/edit/'.$booking->id.'" class="btn btn-warning btnEdit">Edit</a>
                                    <a  class="btn btn-danger text-white btnDelete" id="'.$booking->id.'">Delete</a>
                                </div>
                            </td>
                        </tr>
                    ';
                }
                return response()->json(['status'=>'success','rows'=>$html]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No data found!']);
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
   // booking list view
   public function bookingList(Request $request){
    $inventory_item=Inventory_items::all();
    return view('templates.booking.list',compact('inventory_item'));
}
    // count
    public function countLocker(Request $request){
        try {
            $filterLocker = $request->filterLocker;
            
            $result = Booking::query();
            $result = $result->where('locker_id',$filterLocker);

            $count = $result->count();
            if ($count > 0){
                return response()->json(['status'=>'success','data'=>$count]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No count found']);
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

    // list by locker
    public function listLocker(Request $request){
        try {
            $filterLocker = $request->filterLocker;
            $filterLength = $request->filterLength;

            $result = Booking::query();
            $result = $result->where('locker_id',$filterLocker);
            
            $i = 1;

            $bookings = $result->take($filterLength)->skip($request->offset)->orderBy('id','DESC')->get();
            if (isset($bookings) && sizeof($bookings)>0){
                $html='';
                foreach ($bookings as $booking){
                    $html.='
                        <tr class="border-bottom"> 
                            <td>'.$i++.'</td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 fw-semibold">
                                '.$booking->id.'
                                    </h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$booking->locker->number.'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.ucwords($booking->user->first_name)." ".$booking->user->last_name.'<br><small>'.$booking->user->email.'</small></h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$booking->duration.'</h6>
                            </td>

                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                From: <badge class="badge bg-success">'.date('m/d/Y h:i A',strtotime($booking->from)).'</badge> <br> Until: <badge class="badge bg-warning">'.date('m/d/Y h:i A',strtotime($booking->to)).'</badge></h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.self::status($booking->status).'</h6>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a target="_blank" href="/booking/details/'.$booking->id.'" class="btn btn-info">View Booking</a>
                                </div>
                            </td>
                        </tr>
                    ';
                }
                return response()->json(['status'=>'success','rows'=>$html]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No data found!']);
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
    public function delete($id){
        try{
            $booking = Booking::find($id);
            $payment = Payment::where('booking_id',$id)->first();
            $locker = Locker::where('id',$booking->locker_id)->first();

            if($locker && $booking->status == 'new'){
                $locker->status = 'available';
                $locker->booking_id = 0;
                $locker->occupied_by = 0;
                $locker->occupied_until = '';
                $locker->save();  
            }

            if($booking){
                if ($booking->delete()){
                    if($payment){
                        $payment->delete();
                    }
                    
                    return response()->json(['status'=>'success','msg'=>'Booking has been deleted']);
                }else{
                    return response()->json(['status'=>'fail','msg'=>'Failed to delete the booking']);
                }
            }else{
                return response()->json(['status'=>'fail','msg'=>'Booking not found']);
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

    public function viewDetails($id){
        $booking = Booking::where('id',$id)->first();
        if (!empty($booking) ){ 
            $payment = Payment::where('booking_id',$id)->first();
            $inventory_item=Inventory_items::all();
            return view('templates/booking/detail',['booking'=>$booking,'payment'=>$payment,'inventory_item'=>$inventory_item]);
        }else{
            return view('templates.404');
        }
    }

    public function viewEdit($id){
        $booking = Booking::where('id',$id)->first();
        if (!empty($booking) ){ 
            return view('templates/booking/edit',['booking'=>$booking]);
        }else{
            return view('templates.404');
        }
    }

    public static function status($status){
        $html = '';
        if($status == 'new'){
            $html = '<badge class="badge bg-primary">New</badge>';
        }else if($status == 'completed'){
            $html = '<badge class="badge bg-success">Competed</badge>';
        }else if($status == 'cancelled'){
            $html = '<badge class="badge bg-danger">Cancelled</badge>';
        }else if($status == 'refunded'){
            $html = '<badge class="badge bg-danger">refunded</badge>';
        }else if($status == 'occupied'){
            $html = '<badge class="badge bg-warning">Occupied</badge>';
        }

        return $html;
    }

    // update
    public function update(Request $request){ 
        try {

            $validator = Validator::make($request->all(),[
                'status'=>'required'
            ]);
    
            if($validator->fails()){
                return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);
            }
            
            $booking = Booking::find($request->id);
       
            $booking->status = $request->status;
    
            if($booking->save()){
                return response()->json([
                    'status'=>'success',
                    'msg'=>'Booking updated'
                ],200);
                
            }else{
                return response()->json([
                    'status'=>'fail',
                    'msg'=>'Failed to update the booking'
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

    // update status
    public function cron(){ 
        try {
            
            $bookingArr = Booking::all();
    
            if($bookingArr){
                foreach ($bookingArr as $key => $booking) {
                    if(strtotime($booking->to) < strtotime(date('m/d/Y H:i '))){
                        $book = Booking::find($booking->id);
                        $book->status = 'completed';
                        $book->save();
                        $locker = Locker::find($booking->locker_id);
                        if($locker){
                            $locker->status = 'available';
                            $locker->booking_id = 0;
                            $locker->occupied_by = 0;
                            $locker->occupied_until = '';
                            $locker->save();
                        }
                    }
                }
                return response()->json([
                    'status'=>'success',
                    'msg'=>'Bookings updated'
                ],200);
                
            }else{
                return response()->json([
                    'status'=>'fail',
                    'msg'=>'No bookings are found'
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

    // *** PAYMENTS *** //

    // create payment
    public function paymentCreate(Request $request){
        try {
            $user = User::find(Auth::user()->id);

            $locker = Locker::where('size_id',$request->locker_size_id)->where('site_id',Auth::user()->site->id)->where('status','available')->first();

            if($locker){
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $stripe = Stripe\Charge::create ([
                        "amount" => $request->total_amount * 100,
                        "currency" => "usd",
                        "source" => $request->stripeToken,
                        "description" => "This payment is for booking locker #".$locker->number." for user #".$user->id." ".ucwords($user->first_name)." ".ucwords($user->last_name)
                ]);
    
                if($stripe){
                    $booking = new Booking();
                    $payment = new Payment();

                    // save booking details
                    $booking->locker_id = $locker->id;
                    $booking->user_id = $user->id;
                    $booking->size_id = $locker->size_id;
                    $booking->site_id = $locker->site_id;
                    $booking->duration = $request->duration;
                    $currentDateTime = date('Y-m-d H:i:s');
                    $booking->from = $currentDateTime;
                    $carbon_date = Carbon::parse($currentDateTime);
                    if($request->duration == 'hourly'){
                        $booking->to = $carbon_date->addHours(1);
                    }else if($request->duration == 'daily'){
                        $booking->to = $carbon_date->addHours(24);
                    }else if($request->duration == 'monthly'){
                        $booking->to = $carbon_date->addMonths(1);
                    }
                    $booking->status = 'new';
                    $booking->save();

                    // save payment details
                    $payment->locker_id = $locker->id;
                    $payment->user_id = $user->id;
                    $payment->site_id = $locker->site_id;
                    $payment->booking_id = $booking->id;
                    $payment->payment_id = $stripe["id"];
                    $payment->receipt_url = $stripe["receipt_url"];
                    $payment->amount = $request->total_amount;
                    $payment->status = 'completed';
                    $payment->save();

                    // save locker details
                    $locker->status = 'available';
                    $locker->booking_id = $booking->id;
                    $locker->occupied_by = $user->id;
                    $locker->occupied_until = $booking->to;
                    $locker->save();

                    return response()->json([
                        'status'=>'success',
                        'msg'=>'Your booking has been completed',
                        'data'=>["lockerNumber"=>ucwords($locker->number),'bookingId'=>$booking->id]
                    ],200);
                }else{
                    return response()->json([
                        'status'=>'fail',
                        'msg'=>'Failed to create the payment'
                    ],200);
                }
            }else{
                return response()->json([
                    'status'=>'fail',
                    'msg'=>'All lockers are occupied'
                ],200);
            }
            
        }
        catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'msg'=>$e->getMessage()
            ],200);
        }
    }

    public function paymentIntent(Request $request){
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $stripe = $stripe->paymentIntents->create([
                [
                    'amount' => $request->amount * 100,
                    'currency' => 'usd',
                    'automatic_payment_methods' => ['enabled' => true],
                    // 'payment_method_types' => [
                    //     'us_bank_account',
                    //     'card',
                    //     'bacs_debit',
                    //     'giropay',
                    //     'ideal',
                    //     'p24',
                    //     'sepa_debit',
                    //     'sofort',
                    //     'acss_debit'
                    //   ],
                ]
            ]);

            if($stripe){
                

                return response()->json([
                    'status'=>'success',
                    'msg'=>'Payment intent has been created',
                    'data'=>$stripe->client_secret
                ],200);
            }else{
                return response()->json([
                    'status'=>'fail',
                    'msg'=>'Failed to create the payment'
                ],200);
            }
            
        }
        catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'msg'=>$e->getMessage()
            ],200);
        }
    }

    // refund
    public function paymentRefund(Request $request){
        try {

            $validator = Validator::make($request->all(),[
                'confirm'=>'required'
            ]);
    
            if($validator->fails()){
                return response()->json(['status'=>'fail','msg'=>$validator->errors()->all()]);

            }


            $payment = Payment::where('id',$request->id)->first();
            
            if($payment){

                $booking = Booking::where('id',$payment->booking_id)->first();
                $locker = Locker::where('booking_id',$booking->id)->first();

                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

                $stripe = $stripe->refunds->create([
                    'charge' => $payment->payment_id,
                ]);

                $payment->status = "refunded";


                if($payment->save()){
                    if($booking){
                        $booking->status = 'refunded';
                        $booking->save();
                    }

                    if($locker){
                        $locker->booking_id = 0;
                        $locker->occupied_by = 0;
                        $locker->occupied_until = '';
                        $locker->status = 'available';
                        $locker->save();
                    }

                    return response()->json([
                        'status'=>'success',
                        'msg'=>'Payment has been refunded'
                    ],200);
                }else{
                    return response()->json([
                        'status'=>'fail',
                        'msg'=>'Failed to refund the payment'
                    ],200);
                }
            }else{
                return response()->json([
                    'status'=>'fail',
                    'msg'=>'Payment not found'
                ],200);
            }
        }
        catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'msg'=>$e->getMessage()
            ],200);
        }
    }

    // details
    public function paymentDetails($id){
        try {
            $payment = Payment::where('id',$id)->first();
            $payment = true;
            if($payment){

                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

                $stripe = $stripe->charges->retrieve(
                    $id,
                    []
                );

                return response()->json([
                    'status'=>'true',
                    'msg'=>'Payment has been refunded',
                    'data'=>$stripe
                ],200);

                // $payment->payment_id=NULL;
                // $payment->status="refunded";

                // if($payment->save()){
                //     return response()->json([
                //         'status'=>'true',
                //         'msg'=>'Payment has been refunded'
                //     ],200);
                // }else{
                //     return response()->json([
                //         'status'=>'fail',
                //         'msg'=>'Failed to refund the payment'
                //     ],200);
                // }
            }else{
                return response()->json([
                    'status'=>'fail',
                    'msg'=>'Payment not found'
                ],200);
            }
        }
        catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'msg'=>$e->getMessage()
            ],200);
        }
    }

    // delete
    public function paymentDelete($id){
        try{
            $payment = Payment::find($id);
            if($payment){
                if ($payment->delete()){
                    return response()->json(['status'=>'success','msg'=>'Payment has been deleted']);
                }else{
                    return response()->json(['status'=>'fail','msg'=>'Failed to delete the payment']);
                }
            }else{
                return response()->json(['status'=>'fail','msg'=>'Payment not found']);
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

    // count
    public function paymentCount(Request $request){
        try {
            $filterStatus = $request->filterStatus;
            $filterUser = $request->filterUser;
            
            $result = Payment::query();

            if ($filterStatus !='all'){
                $result = $result->where('status',$filterStatus);
            }

            if($filterUser == 'User'){
                $result = $result->where('user_id',Auth::user()->id);
            }

            if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff')){
                $result = $result->where('site_id',Auth::user()->site->id);
            }

            $count = $result->count();
            if ($count > 0){
                return response()->json(['status'=>'success','data'=>$count]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No count found']);
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
    public function paymentList(Request $request){
        try {
            $filterStatus = $request->filterStatus;
            $filterLength = $request->filterLength;
            $filterUser = $request->filterUser;
            
            $result = Payment::query();

            if ($filterStatus !='all'){
                $result = $result->where('status',$filterStatus);
            }

            if($filterUser == 'User'){
                $result = $result->where('user_id',Auth::user()->id);
            }
            
            if(Auth::user()->hasRole('Site Admin') || Auth::user()->hasRole('Staff')){
                $result = $result->where('site_id',Auth::user()->site->id);
            }

            $i = 1;

            $payments = $result->take($filterLength)->skip($request->offset)->orderBy('id','DESC')->get();
            if (isset($payments) && sizeof($payments)>0){
                $html='';
                foreach ($payments as $payment){
                    $html.='
                        <tr class="border-bottom"> 
                            <td>'.$i++.'</td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 fw-semibold">
                                '.$payment->id.'<br>
                                <small>Stripe #: <b>'.$payment->payment_id.'</b></small>
                                    </h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.$payment->booking->id.'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.ucwords($payment->site->name).'</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.ucwords($payment->user->first_name)." ".$payment->user->last_name.'<br><small>'.$payment->user->email.'</small></h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.date('m/d/Y H:i a',strtotime($payment->created_at)).'</h6>
                            </td>

                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">$'.$payment->amount.'</h6>
                            </td>

                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                <a target="_blank" href="'.$payment->receipt_url.'">View Receipt</a>
                                </h6>
                            </td>
                            <td>
                                <h6 class="mb-0 m-0 fs-14 ">
                                '.self::status($payment->status).'</h6>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    '.($payment->status == 'completed' ? '<a  href="/payment/refund/'.$payment->id.'" class="btn btn-warning btnEdit">Refund</a>' : '<a  class="btn btn-danger text-white btnDelete" id="'.$payment->id.'">Delete</a>').'
                                </div>
                            </td>
                        </tr>
                    ';
                }
                return response()->json(['status'=>'success','rows'=>$html]);
            }else{
                return response()->json(['status'=>'fail','msg'=>'No data found!']);
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

    public function viewPaymentRefund($id){
        $payment = Payment::where('id',$id)->first();
        if (!empty($payment) ){ 
            return view('templates/payment/refund',['payment'=>$payment]);
        }else{
            return view('templates.404');
        }
    }
}
