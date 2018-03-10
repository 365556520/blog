<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin= [
            [
                'user_name' => 'aaa',
                'user_pass' => bcrypt('aaaaaa'),
            ]
        ];
        DB::table('user')->insert($admin);

    }
}
