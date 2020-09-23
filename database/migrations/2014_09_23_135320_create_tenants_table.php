<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('subdomain')->unique();
            $table->uuid('uuid');
            $table->string('name')->unique();
            $table->timestamps();

        });

        //Create master Tenant
        DB::table('tenants')->insert(
            array(
                'subdomain' => 'master',
                'name' => 'master',
                'uuid' => 'da3435b3-19e4-4b2e-929a-7d6f0202d5e5'
            )
        );

        DB::table('tenants')->insert(
            array(
                'subdomain' => 'client1',
                'name' => 'client1',
                'uuid' => 'da8714b3-19e4-4b2e-929a-7d6f0202d5e5'
            )
        );

        DB::table('tenants')->insert(
            array(
                'subdomain' => 'client2',
                'name' => 'client2',
                'uuid' => 'da1582b3-19e4-4b2e-929a-7d6f0202d5e5'
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
        Schema::dropIfExists('tenants');
    }
}
