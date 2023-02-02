<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table = 'categories';
    public function parent(){
        // return $this->belongsTo(Categories::class , 'parent_id' , 'id');
        return $this->belongsTo(Categories::class, 'parent_id');
    }
}
