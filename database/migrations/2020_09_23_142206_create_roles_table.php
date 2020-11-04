<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('label', 191);
            $table->timestamps();
        });

        DB::table('roles')->insert(
            array(
                'name' => 'admin',
                'label' => 'system administrator'
            )
        );

        DB::table('roles')->insert(
            array(
                'name' => 'master',
                'label' => 'tenant administrator'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
