<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('meeting_id');
            $table->foreign('meeting_id')->references('id')->on('meetings');
            $table->string('email');
            $table->string('name');
            $table->text('agenda_items');
            $table->string('rsvp');
            $table->boolean('show_public');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registration');
    }
}
