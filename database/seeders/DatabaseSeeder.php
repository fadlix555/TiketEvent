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
            'foto' => 'img/NJ.jpg',
            'status' => 'active',
            'lokasi' => 'GBK',
            'tanggal' => date('Y-m-d', strtotime('2024-12-31')),
            'waktu' => date('H:i:s', strtotime('20:00:00')),
            'stok' => 50000,
            'Category_id' => 1,
        ]);
    }
}
