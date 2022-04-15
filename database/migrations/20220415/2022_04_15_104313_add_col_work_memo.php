<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColWorkMemo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SalesWorkMemo', function (Blueprint $table) {
            $table->increments('WorkMemoID');
            $table->integer('SubId')
                ->comment('廠商代碼');
            $table->string('SubName')
                ->nullable()
                ->comment('廠商名稱');
            $table->date('VisitDate')
                ->nullable()
                ->comment('拜訪日期');
            $table->string('SalesName')
                ->nullable()
                ->comment('登入者姓名');
            $table->string('WorkMemo', 300)
                ->nullable()
                ->comment('日誌內容');
            $table->string('RandomName')
                ->nullable()
                ->comment('CSV產生對應值，避免重複覆蓋問題');
            $table->datetime('CreateDate')
                ->nullable()
                ->comment('建立時間日期');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SalesWorkMemo');
    }
}
