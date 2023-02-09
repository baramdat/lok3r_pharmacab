<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requested_product extends Model
{
    use HasFactory;
    protected $table = 'requested_products';
    public function inventory_item(){
        return $this->belongsTo(Inventory_items::class , 'product_id' , 'id');
    }
    public function site(){
        return $this->belongsTo(Site::class , 'site_id' , 'id');
    }
    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
