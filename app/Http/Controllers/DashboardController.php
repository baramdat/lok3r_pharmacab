<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Inventory_record;
use Illuminate\Http\Request;
use App\Models\Locker_history;
use App\Models\Requested_product;
use Carbon\Cli\Invoker;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index(){
    if(Auth::user()->hasRole('Super Admin')){
        $locker_history=Inventory_record::latest()->limit(5)->get();
        $product_request=Requested_product::latest()->limit(5)->get();
        // $locker_history= Locker_history::join('users', 'users.id', '=', 'locker_history.user_id')
        // ->join('sites', 'sites.id', '=', 'locker_history.site_id')
        // ->join('lockers', 'lockers.id', '=', 'locker_history.locker_id')->latest()->limit(5)
        // ->get(['users.first_name','users.last_name', 'users.email','lockers.number', 'sites.name','locker_history.reason','locker_history.created_at']);
    }else if(Auth::user()->hasRole('Site User')){
        $locker_history=Inventory_record::where('user_id', Auth::user()->id)->latest()->limit(5)->get();
        $product_request=Requested_product::where('user_id', Auth::user()->id)->latest()->limit(5)->get();
    }else{
        $locker_history=Inventory_record::where('site_id', Auth::user()->site_id)->latest()->limit(5)->get();
        $product_request=Requested_product::where('site_id', Auth::user()->site_id)->latest()->limit(5)->get();
    }
    $products = Inventory::where('site_id',Auth::user()->site_id)->latest()->skip(0)->take(5)->get();
    $oldproduct = Inventory::where('site_id',Auth::user()->site_id)->latest()->skip(5)->take(7)->get();
    return view('templates.dashboard',compact('locker_history','products','oldproduct','product_request'));
   }
}
