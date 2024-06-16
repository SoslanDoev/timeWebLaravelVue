<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->insert([
            [
                "name" => "Иван",
                "surname" => "Петров",
                "patronymic" => "Сергеевич"
            ],
            [
                "name" => "Мария",
                "surname" => "Смирнова",
                "patronymic" => "Викторовна"
            ],
            [
                "name" => "Сергей",
                "surname" => "Иванов",
                "patronymic" => "Александрович"
            ],
            [
                "name" => "Анна",
                "surname" => "Кузнецова",
                "patronymic" => "Дмитриевна"
            ],
            [
                "name" => "Алексей",
                "surname" => "Сидоров",
                "patronymic" => "Михайлович"
            ],
            [
                "name" => "Екатерина",
                "surname" => "Романова",
                "patronymic" => "Андреевна"
            ],
            [
                "name" => "Максим",
                "surname" => "Васильев",
                "patronymic" => "Владимирович"
            ],
        ]);
    }
}
