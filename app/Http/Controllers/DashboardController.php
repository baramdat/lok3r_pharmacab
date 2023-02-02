<?php

namespace App\Http\Controllers;

use App\Models\Inventory_record;
use Illuminate\Http\Request;
use App\Models\Locker_history;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index(){
    if(Auth::user()->hasRole('Super Admin')){
        $locker_history=Inventory_record::latest()->limit(5)->get();
        // $locker_history= Locker_history::join('users', 'users.id', '=', 'locker_history.user_id')
        // ->join('sites', 'sites.id', '=', 'locker_history.site_id')
        // ->join('lockers', 'lockers.id', '=', 'locker_history.locker_id')->latest()->limit(5)
        // ->get(['users.first_name','users.last_name', 'users.email','lockers.number', 'sites.name','locker_history.reason','locker_history.created_at']);
    }else{
        $locker_history=Inventory_record::where('site_id', Auth::user()->site_id)->latest()->limit(5)->get();
        // $locker_history= Locker_history::join('users', 'users.id', '=', 'locker_history.user_id')
        // ->join('sites', 'sites.id', '=', 'locker_history.site_id')
        // ->join('lockers', 'lockers.id', '=', 'locker_history.locker_id')->where('locker_history.site_id', Auth::user()->site_id)->latest()->limit(5)
        // ->get(['users.first_name','users.last_name', 'users.email','lockers.number', 'sites.name','locker_history.reason','locker_history.created_at']);
    }
   // dd($locker_history);
    return view('templates.dashboard',compact('locker_history'));
   }
}
