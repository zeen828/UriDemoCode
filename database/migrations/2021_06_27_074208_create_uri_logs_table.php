<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUriLogsTable.
 */
class CreateUriLogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('uri_log', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('srt_id')->comment('短網址ID');
			$table->string('srt', 10)->comment('短字串');
			$table->string('uri', 50)->comment('路徑');
			$table->text('url')->comment('連線網址');
			$table->ipAddress('ip')->comment('IP');
            $table->timestamps();
			// 索引
			$table->index(['srt_id', 'srt'], 'query');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('uri_log');
	}
}
