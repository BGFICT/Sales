<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            'description'=>"Better Globe Forestry Ltd,
Olenguruone Ave Kileleshwa, Likoni Rd,
Total Petrol Station Building, 2nd Floor
Kileleshwa

Nairobi, Kenya

P.O Box 823-00606",
            'short_des'=>"Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.",
            'photo'=>"image.jpg",
            'logo'=>'logo.jpg',
            'address'=>"P.O Box 823-00606   Nairobi, Kenya",
            'email'=>"bgfmitibetterglobe@gmail.com",
            'phone'=>"+254 110 066 043

",
        );
        DB::table('settings')->insert($data);
    }
}
