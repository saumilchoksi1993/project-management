<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectVersions extends Model
{
    use HasFactory;
    protected $table = "project_versions";

    protected $fillable = ['version_number', 'status','name', 'project_id', 'owner_address', 'dwelling_description', 'builder_address', 'site_address', 'contract_price', 'client_name', 'client_address', 'client_email', 'client_phone', 'extra_inclusions_variation_price'];

    public function project_version_items() {
        return $this->hasMany(ProjectItems::class, 'project_version_id', 'id');
    }
}
