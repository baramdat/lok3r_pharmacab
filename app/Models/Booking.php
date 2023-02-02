<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';

    /**
     * Get the comments for the blog post.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class,'site_id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function locker()
    {
        return $this->belongsTo(Locker::class,'locker_id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id');
    }
}
