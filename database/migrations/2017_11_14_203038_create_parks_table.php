<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('parks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stakeholder_id');
            $table->double('value', 10, 2);
            $table->double('latitude', 10, 10);
            $table->double('longitude', 10, 10);
            $table->integer('available');
            $table->text('img')->nullable();
            $table->text('address');
            $table->integer('current')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('parks');
    }

}
