<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LockerSize extends Model
{
    use HasFactory;
    protected $table = 'locker_sizes';

    /**
     * Get the comments for the blog post.
     */
    public function locker()
    {
        return $this->hasMany(Locker::class);
    }
}
