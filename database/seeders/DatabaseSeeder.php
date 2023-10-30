<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
                ['name' => 'user'],
                ['name' => 'executor'],
            ]
        );

        Status::insert([
            ['name'=>'Новое'],
            ['name'=>'Отменено'],
            ['name'=>'В работе'],
            ['name'=>'Выполнено'],
            ['name'=>'Провалено'],
        ]);

        User::factory(1)->create();

        Task::factory(15)->create();
    }
}
