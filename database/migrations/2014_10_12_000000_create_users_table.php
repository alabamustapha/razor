<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('old_id')->nullable();
            $table->boolean('isAdmin')->default(false);
            $table->integer('aff_role_type')->nullable();
            $table->integer('aff_link');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('aff_date_inscription');
            $table->string('aff_last_connexion')->nullable();
            $table->integer('aff_status_approved');
            $table->string('aff_fname');
            $table->string('aff_lname');
            $table->boolean('aff_civility');
            $table->string('aff_adresse');
            $table->string('aff_city');
            $table->integer('aff_zip');
            $table->string('aff_tel');
            $table->integer('aff_orias');
            $table->string('aff_company');
            $table->string('aff_message');
            $table->string('aff_pwdrecovery')->nullable();
            $table->string('aff_ref')->nullable();
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
