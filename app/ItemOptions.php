<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOptions extends Model
{
    use HasFactory;
    protected $table = "items_options";
    protected $fillable = ['item_id', 'name'];
}
