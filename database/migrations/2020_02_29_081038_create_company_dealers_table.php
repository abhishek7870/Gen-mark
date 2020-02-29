<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyDealersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_dealers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dealer_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('company_dealer_id');
            $table->foreign('dealer_id')->references('id')->on('dealers');
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('company_dealers');
    }
}
