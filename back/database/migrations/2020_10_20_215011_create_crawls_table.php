<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

//        publisher name, domain name, assets name,
// ads.txt entry, app-ads.txt entry,
// date added, date status changed, current status,
        Schema::create('crawls', function (Blueprint $table) {
            $table->id();
            $table->integer('domain_id')->unsigned();
            $table->boolean('is_app');
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
        Schema::dropIfExists('crawls');
    }
}
