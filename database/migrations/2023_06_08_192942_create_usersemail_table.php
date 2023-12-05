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
        Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('email_address');
    $table->string('order_status');
    $table->unsignedInteger('quantity');
    $table->timestamp('order_date');
    $table->timestamps();
});

    }
    public function down()
    {
        Schema::dropIfExists('usersemail');
    }
};
