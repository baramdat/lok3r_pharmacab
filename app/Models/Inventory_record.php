<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory_record extends Model
{
    use HasFactory;
    protected $table = 'inventory_records';
    public function inventory_item(){
        return $this->belongsTo(Inventory_items::class , 'item_id' , 'id');
    }
    public function site(){
        return $this->belongsTo(Site::class , 'site_id' , 'id');
    }
    public function locker(){
        return $this->belongsTo(Locker::class , 'locker_id' , 'id');
    }
    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
