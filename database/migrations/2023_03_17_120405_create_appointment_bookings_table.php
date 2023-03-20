<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_bookings', function (Blueprint $table) {
            $table->id();
            $table->date('appointment_date');
            $table->string('appointment_time');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('appointment_type_id')->references('id')->on('appointment_types')->onDelete('cascade');
            $table->text('contact_address')->nullable();
            $table->text('complaint')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('appointment_bookings');
    }
}
