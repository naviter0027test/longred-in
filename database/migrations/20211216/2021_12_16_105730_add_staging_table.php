<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStagingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Staging', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('area')
                ->comment('區域 1:桃園區 2:竹苗區 3:台中區 4:高屏區 5:花東區 6:其他');
            $table->string('img')
                ->comment('上傳分期表的圖檔路徑');
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
        Schema::dropIfExists('Staging');
    }
}
