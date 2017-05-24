<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUploadsettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('uploadsettings', function( $setting ) {
            $setting->increments('id');
            $setting->bigInteger('maxFileSize')->unsigned();
            $setting->string('allowedFilesExt');
            $setting->string('storagePath');
            $setting->bigInteger('userDiskSpace')->unsigned();
            $setting->timestamps();
        });
        DB::table('uploadsettings')->insert([
            'id' => 1,
            'allowedFilesExt' => 'txt',
            'maxFileSize' => 16,
            'userDiskSpace' => 128,
            'storagePath' => '/uploadfiles/',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
