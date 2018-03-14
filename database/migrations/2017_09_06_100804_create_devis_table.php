<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('id_contrat');
            $table->integer('affiliate_users');
            $table->date('date_creation');
            $table->string('status', 255);
            $table->integer('type_product');
            $table->binary('data_product');
            $table->binary('data_proposant');
            $table->string('customer_nom', 255);
            $table->float('tarificateur_amount',8,2);
            $table->float('customer_amount');
            $table->float('partner_amount');
            $table->float('affiliate_amount');
            $table->float('customer_amount_rc');
            $table->integer('date_contract');
            $table->integer('periodicity');
            $table->string('formule',255);
            $table->text('clauses');
            $table->string('affiliate_lastname',255);
            $table->string('affiliate_firstname',255);
            $table->string('affiliate_company',255);
            $table->string('affiliate_address',255);
            $table->string('affiliate_city',255);
            $table->string('affiliate_zip',255);
            $table->string('affiliate_email',255);
            $table->string('affiliate_orias',255);
            $table->string('affiliate_tel',255);
            $table->string('affiliate_ref',255)->nullable();
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
        Schema::dropIfExists('devis');
    }
}
