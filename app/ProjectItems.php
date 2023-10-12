<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectItems extends Model
{
    use HasFactory;
    protected $table = "project_items";

    protected $fillable = ['project_id', 'project_version_id', 'item_id', 'notes'];

    protected $appends = [
        'item_name',
        'item_display_name'
    ];

    public function project_version_items_options() {
        return $this->hasMany(ProjectItemOptions::class, 'project_items_id', 'id');
    }

    public function getItemNameAttribute()
    {
        $item_data = DB::table('items')
            ->where('id', $this->item_id)
            ->first();

        return $item_data ? $item_data->name : '';
    }

    public function getItemDisplayNameAttribute()
    {
        $item_data = DB::table('items')
            ->where('id', $this->item_id)
            ->first();

        return $item_data ? $item_data->display_name : '';
    }
}
