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
        \App\Http\Model\User::create([
        'name' => 'aaa',
        'pass' => \Illuminate\Support\Facades\Crypt::bcrypt('aaaaaa'),
        ]);
    }
}
