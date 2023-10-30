<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::insert([
            ['name'=>'Новое'],
            ['name'=>'Отменено'],
            ['name'=>'В работе'],
            ['name'=>'Выполнено'],
            ['name'=>'Провалено'],
        ]);
    }
}
