<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThemeColorsToGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->string('primary_color')->default('#053C6B')->after('droploo_username');
            $table->string('secondary_color')->default('#333333')->after('primary_color');
            $table->string('accent_color')->default('#f41127')->after('secondary_color');
            $table->string('category_bg_color')->default('#053C6B')->after('accent_color');
            $table->string('header_bg_color')->default('#ffffff')->after('category_bg_color');
            $table->string('footer_bg_color')->default('#333333')->after('header_bg_color');
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
            $table->dropColumn([
                'primary_color',
                'secondary_color',
                'accent_color',
                'category_bg_color',
                'header_bg_color',
                'footer_bg_color'
            ]);
        });
    }
}
