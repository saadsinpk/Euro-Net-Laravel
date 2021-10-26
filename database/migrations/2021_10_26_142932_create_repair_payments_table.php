<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_payments', function (Blueprint $table) {
            $table->id();
            $table->string("number");
            $table->string("name");
            $table->string("email");
            $table->text("phone");
            $table->text("serial_num");
            $table->text("problem");
            $table->integer("bitmain_id");
            $table->integer("user_id");
            $table->integer("status");
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
        Schema::dropIfExists('repair_payments');
    }
}
