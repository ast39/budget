<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration  {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_credits', function (Blueprint $table) {
            $table->id('credit_id');
            $table->string('title', 64);
            $table->unsignedInteger('payment_type')
                ->default(1);
            $table->string('subject', 8)
                ->nullable();
            $table->unsignedFloat('amount',11, 2)
                ->nullable();
            $table->unsignedFloat('percent', 9, 4)
                ->nullable();
            $table->unsignedInteger('period')
                ->nullable();
            $table->unsignedFloat('payment', 11, 2)
                ->nullable();
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
        Schema::dropIfExists('tmp_credits');
    }
};
