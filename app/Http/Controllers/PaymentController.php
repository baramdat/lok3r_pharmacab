<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User; 
use App\Models\Locker;
use App\Models\LockerSize;
use App\Models\PricingHistory;
use App\Models\Booking;
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

class PaymentController extends Controller
{
    
}
