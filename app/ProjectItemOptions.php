<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectItemOptions extends Model
{
    use HasFactory;
    protected $table = "project_item_options";

    protected $fillable = ['project_id', 'project_version_id', 'item_id', 'project_items_id' ,'item_option_id'];

    protected $appends = [
        'option_name'
    ];

    public function getOptionNameAttribute()
    {
        $option_data = DB::table('items_options')
            ->where('id', $this->item_option_id)
            ->first();

        return $option_data ? $option_data->name : '';
    }
}
