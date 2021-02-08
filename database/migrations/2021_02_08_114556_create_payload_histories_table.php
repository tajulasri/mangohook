<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayloadHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payload_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('webhook_id')->nullable();
            $table->string('request_id')->nullable();
            $table->text('payload')->nullable();
            $table->text('request_headers')->nullable();
            $table->dateTime('request_datetime')->nullable();
            $table->dateTime('received_datetime')->nullable();
            $table->boolean('received')->default(false);
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
        Schema::dropIfExists('payload_histories');
    }
}
