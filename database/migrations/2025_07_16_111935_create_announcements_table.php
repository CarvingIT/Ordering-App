<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::table('events', function (Blueprint $table) {
                $table->renameColumn('announcement','description')->nullable();
                $table->dropColumn('show_till')->useCurrent();
                $table->datetime('start_date')->useCurrent();
                $table->datetime('end_date')->useCurrent();
        });
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
		$table->string('title')->nullable();
                $table->longText('announcement')->nullable();
                $table->datetime('show_till')->useCurrent();
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
        Schema::dropIfExists('announcements');
    }
}
