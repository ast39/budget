<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fraud_credits', function (Blueprint $table) {
            $table->id('calc_id');
            $table->string('title', 64);
            $table->unsignedFloat('amount',11, 2);
            $table->unsignedFloat('percent', 9, 4);
            $table->unsignedInteger('period');
            $table->unsignedFloat('payment', 11, 2);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fraud_credits');
    }
};
