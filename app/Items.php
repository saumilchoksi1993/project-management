<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $table = "items";
    protected $fillable = ['name', 'display_name', 'default_available_while_create_project'];

    public function itemOptions(){
        return $this->hasMany(ItemOptions::class, 'item_id', 'id');
    }

}
