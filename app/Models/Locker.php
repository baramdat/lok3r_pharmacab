<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;
    protected $table = 'lockers';
    /**
     * Get the post that owns the comment.
     */
    public function size()
    {
        return $this->belongsTo(LockerSize::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function occupied()
    {
        return $this->belongsTo(User::class,'occupied_by');
    }
}
