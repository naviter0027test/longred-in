<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User', function (Blueprint $table) {
            $table->increments('id');
            $table->string('UserId')
                ->unique()
                ->comment('登入帳號');
            $table->string('Password')
                ->comment('密碼');
            $table->string('UserName')
                ->comment('使用者名稱');
            $table->string('Area')
                ->comment('使用者區域');
            $table->string('Privileges')
                ->comment('登入權限');
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
        Schema::dropIfExists('User');
    }
}
