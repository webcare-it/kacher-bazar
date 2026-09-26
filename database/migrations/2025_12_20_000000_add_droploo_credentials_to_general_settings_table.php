<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDroplooCredentialsToGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->string('droploo_app_key')->nullable()->after('logo');
            $table->string('droploo_app_secret')->nullable()->after('droploo_app_key');
            $table->string('droploo_username')->nullable()->after('droploo_app_secret');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn(['droploo_app_key', 'droploo_app_secret', 'droploo_username']);
        });
    }
}
