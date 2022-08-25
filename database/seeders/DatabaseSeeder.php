<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\Admin::create([
            'name'  => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'P@ssw0rd'
        ]);
        \App\Models\User::create([
            'name'  => 'test1',
            'email' => 'test1@gmail.com',
            'password' => 'P@ssw0rd'
        ]);
        \App\Models\User::factory(30)->create();
        $categories = [
            'Korea',
            'Japan',
            'Sexy'
        ];
        foreach ($categories as $c) {
            \App\Models\Category::create([
                'name' => $c
            ]);
        }
        \App\Models\Product::factory(1)->create();
    }
}
