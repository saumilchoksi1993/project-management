<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_versions', function (Blueprint $table) {
            $table->id();
            $table->integer('version_number');
            $table->integer('project_id');
            $table->string('name');
            $table->string('owner_address')->nullable();
            $table->string('dwelling_description')->nullable();
            $table->string('builder_address')->nullable();
            $table->string('site_address')->nullable();
            $table->integer('contract_price')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('extra_inclusions_variation_price')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_versions');
    }
};
