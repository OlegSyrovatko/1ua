<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_recipients', function ($table) {
            $table->id();

            $table->string('email')->unique();

            $table->enum('status', [
                'ok',
                'temporary',
                'blocked'
            ])->default('ok');

            $table->unsignedSmallInteger('fail_count')->default(0);

            $table->timestamp('next_retry_at')->nullable();

            $table->string('last_error')->nullable();

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
        Schema::dropIfExists('mail_recipients');
    }
}
