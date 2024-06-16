<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisciplineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('disciplines')->insert([
            ["name" => "Основы программирования"],
            ["name" => "Алгоритмы и структуры данных"],
            ["name" => "Объектно-ориентированное программирование"],
            ["name" => "Операционные системы"],
            ["name" => "Базы данных"],
            ["name" => "Сетевые технологии"],
            ["name" => "Веб-разработка"],
            ["name" => "Мобильная разработка"],
            ["name" => "Разработка игр"],
            ["name" => "Машинное обучение"],
            ["name" => "Криптография"],
            ["name" => "Математика для программистов"],
            ["name" => "Инженерия программного обеспечения"],
            ["name" => "Тестирование программного обеспечения"],
            ["name" => "Управление проектами"],
        ]);
    }
}
