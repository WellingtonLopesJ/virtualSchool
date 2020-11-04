<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('label', 191);
            $table->timestamps();
        });

        DB::table('permissions')->insert(
            array(
                'name' => 'admin_area',
                'label' => 'system administrator'
            )
        );

        DB::table('permissions')->insert(
            array(
                'name' => 'master_area',
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
        Schema::dropIfExists('permissions');
    }
}
