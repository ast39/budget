<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedInteger('wallet_id');
            $table->unsignedFloat('amount', 11, 2)
                ->nullable();
            $table->tinyText('note')
                ->nullable();
            $table->unsignedTinyInteger('status')
                ->default(1);

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
        Schema::dropIfExists('wallet_payments');
    }
};
