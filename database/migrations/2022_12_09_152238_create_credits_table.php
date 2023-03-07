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
        Schema::create('credits', function (Blueprint $table) {
            $table->id('credit_id');
            $table->unsignedInteger('owner_id');
            $table->string('title', 64);
            $table->string('creditor', 64);
            $table->unsignedFloat('amount',11, 2)
                ->nullable();
            $table->unsignedFloat('percent', 9, 4)
                ->nullable();
            $table->unsignedInteger('period')
                ->nullable();
            $table->unsignedFloat('payment', 11, 2)
                ->nullable();
            $table->unsignedInteger('start_date');
            $table->unsignedInteger('payment_date');
            $table->timestamps();
            $table->unsignedTinyInteger('status')
                ->default(0);

            $table->softDeletes();

            $table->index('owner_id', 'owner_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credits');
    }
};
