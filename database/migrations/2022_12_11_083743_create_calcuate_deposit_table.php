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
        Schema::create('tmp_deposits', function (Blueprint $table) {
            $table->id('deposit_id');
            $table->string('title', 64);
            $table->unsignedInteger('start_date');
            $table->unsignedFloat('amount', 11, 2)
                ->nullable();
            $table->unsignedFloat('percent', 9, 4)
                ->nullable();
            $table->unsignedInteger('period')
                ->nullable();
            $table->unsignedFloat('refill', 11, 2)
                ->default(0);
            $table->unsignedInteger('plow_back');
            $table->boolean('withdrawal');
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
        Schema::dropIfExists('tmp_deposits');
    }
};
