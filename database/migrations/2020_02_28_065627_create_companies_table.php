<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('key');
            $table->string('company_code')->nullable();
            $table->string('image_name')->nullable();
            $table->text('image_url')->nullable();
            $table->string('name');
            $table->string('api_url');
            $table->text('sms_registration_url');
            $table->text('sms_verification_url');
            $table->text('dealer_verification_url');
            $table->text('dealer_registration_url'); 
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
        Schema::dropIfExists('companies');
    }
}
