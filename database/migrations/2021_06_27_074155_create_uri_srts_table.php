<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUriSrtsTable.
 */
class CreateUriSrtsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('uri_srt', function(Blueprint $table) {
            $table->increments('id');
			$table->string('srt', 10)->comment('短字串');
			$table->string('uri', 50)->comment('路徑');
			$table->text('go_url')->comment('對應網址');
			$table->integer('access')->default(0)->comment('訪問數');
			$table->tinyInteger('status')->default(0)->comment('狀態(0:停用,1:啟用)');
			$table->timestamp('expire_at')->nullable()->comment('期限時間');
            $table->timestamps();
			// 索引
			$table->index(['srt', 'status', 'expire_at'], 'query');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('uri_srt');
	}
}
