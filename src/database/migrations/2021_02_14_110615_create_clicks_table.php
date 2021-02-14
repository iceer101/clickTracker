<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicks', function (Blueprint $table) {
            $table->char('id', 40);
            $table->text('ua');
            $table->string('ip');
            $table->text('ref')->nullable();
            $table->string('param1')->nullable();
            $table->string('param2')->nullable();
            $table->unsignedBigInteger('error')->default(0);
            $table->unsignedSmallInteger('bad_domain')->default(0);

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clicks');
    }
}
