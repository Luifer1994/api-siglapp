<?php

namespace Database\Seeders;

use App\Models\TypeDocument;
use App\Models\TypeUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $type_users = ["Admin", "Funcionario"];
        foreach ($type_users as $rol) {
            DB::table('type_users')->insert([
                "name" => $rol,
            ]);
        }
        $type_documents = ['Cédula de Ciudadanía', 'Cédula de Extranjería', 'NIT'];
        foreach ($type_documents as $type) {
            DB::table('type_documents')->insert([
                "name" => $type,
            ]);
        }
        User::factory(1)->create();
    }
}