<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str; // Importar la clase Str

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Acción', 'Aventura', 'Estrategia', 'Deportes', 'Simulación'];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category) // Utilizar la clase Str correctamente
            ]);
        }
    }
}
