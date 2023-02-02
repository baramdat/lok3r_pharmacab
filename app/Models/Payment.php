<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';

    /**
     * Get the locker details for the payment.
     */
    public function locker()
    {
        return $this->belongsTo(Locker::class,'locker_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class,'site_id');
    }

    /**
     * Get the user details for the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Get the booking details for the payment.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class,'booking_id');
    }
}
