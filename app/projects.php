<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectVersions;


class Projects extends Model
{
    protected $table = "projects";
    protected $fillable = ['name', 'owner_address', 'dwelling_description', 'builder_address', 'site_address', 'contract_price', 'client_name', 'client_address', 'client_email', 'client_phone', 'extra_inclusions_variation_price'];

    public function project_versions() {
        return $this->hasMany(ProjectVersions::class, 'project_id', 'id');
    }
}
