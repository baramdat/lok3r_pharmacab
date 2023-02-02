<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventories';

    public function inventory_item(){
        return $this->belongsTo(Inventory_items::class , 'item_id' , 'id');
    }
    public function categories(){
        return $this->belongsTo(Categories::class , 'parent_category_id' , 'id');
    }
}
