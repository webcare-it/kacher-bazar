<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generalsetting = [
            ['logo'=>'logo.png', 'phone'=>'+8801648177071',
            'email'=>'banggomartbd@gmail.com', 'facebook'=>'https://fb.com',
            'twitter'=>'https://twitter.com', 'instagram'=>'https://www.instagram.com',
            'youtube'=>'https://youtube.com','address'=>'House#06, Level#03 Road-1/A, Sector#09 Housebuilding, Uttara Dhaka-1230.']
        ];

        GeneralSetting::insert($generalsetting);
    }
}
