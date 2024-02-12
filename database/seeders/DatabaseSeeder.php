<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'nama' => 'f',
            'role' => 'user',
            'email' => 'f@gmail.com',
            'password' => bcrypt(1)
        ]);
        User::create([
            'nama' => 'superadmin',
            'role' => 'admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt(1)
        ]);
        User::create([
            'nama' => 'kasir',
            'role' => 'kasir',
            'email' => 'sir@gmail.com',
            'password' => bcrypt(1)
        ]);
        User::create([
            'nama' => 'own',
            'role' => 'owner',
            'email' => 'owner@gmail.com',
            'password' => bcrypt(1)
        ]);

        Category::create([
            'nama' => 'Musik'
        ]);

        Category::create([
            'nama' => 'Komedi'
        ]);

        Event::create([
            'nama' => 'Newjeans Concert',
            'harga' => 500000,
            'map' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15865.365076993963!2d106.8017727!3d-6.2186488!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f14d30079f01%3A0x2e74f2341fff266d!2sGelora%20Bung%20Karno%20Stadium!5e0!3m2!1sen!2sid!4v1706367318366!5m2!1sen!2sid',
            'foto' => 'img/enji.jpg',
            'status' => 'active',
            'lokasi' => 'Gelora bung karno',
            'tanggal' => date('Y-m-d', strtotime('2024-12-31')),
            'waktu' => date('H:i:s', strtotime('20:00:00')),
            'stok' => 50000,
            'Category_id' => 1,
        ]);

        Event::create([
            'nama' => 'Twice Concert',
            'harga' => 2000000,
            'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.0414705755475!2d106.85745967498951!3d-6.125121693861604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6a1fa3823b7263%3A0x9fc9c0986c6adaf9!2sJakarta%20International%20Stadium%20(JIS)!5e0!3m2!1sen!2sid!4v1706774167940!5m2!1sen!2sid',
            'foto' => 'img/2.jpg',
            'status' => 'active',
            'lokasi' => 'Jakarta International stadium',
            'tanggal' => date('Y-m-d', strtotime('2024-06-15')),
            'waktu' => date('H:i:s', strtotime('21:00:00')),
            'stok' => 50000,
            'Category_id' => 1,
        ]);
    }
}
