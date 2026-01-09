<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use StaticKidz\BedcaAPI\BedcaClient;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $client = new BedcaClient();
        
        // Obtenemos las categorías
        $categories = Category::whereNotNull('bedca_id')->get();

        foreach ($categories as $category) {
            $this->command->info("--- Procesando categoría: " . $category->name . " ---");

            try {
                // Pedimos lista de alimentos de esa categoría
                $foodsInGroup = $client->getFoodsInGroup($category->bedca_id);

                if (!isset($foodsInGroup->food)) {
                    continue; 
                }

                // Forzamos array y limitamos a 3 para ir rápido
                $listaAlimentos = is_array($foodsInGroup->food) ? $foodsInGroup->food : [$foodsInGroup->food];
                $limitedFoods = array_slice($listaAlimentos, 0, 3);

                foreach ($limitedFoods as $simpleFood) {
                    
                    // Evitar duplicados por ID de BEDCA
                    if(Product::where('bedca_id', $simpleFood->f_id)->exists()){
                        continue;
                    }

                    $this->command->info("   -> Descargando nutrientes de: " . $simpleFood->f_ori_name);

                    // Pedimos el detalle COMPLETO
                    $fullFood = $client->getFood($simpleFood->f_id);
                    
                    // Primero verificamos si existe la propiedad 'food' contenedora
                    $foodData = $fullFood->food ?? null;

                    if (!$foodData) {
                        $this->command->warn("      (Saltado: Estructura de datos inesperada)");
                        continue;
                    }

                    // Función auxiliar corregida: Busca dentro de $foodData->foodvalue
                    $getVal = function($id) use ($foodData) {
                        if (!isset($foodData->foodvalue)) return 0;
                        
                        // Aseguramos que sea array
                        $values = is_array($foodData->foodvalue) ? $foodData->foodvalue : [$foodData->foodvalue];

                        foreach ($values as $val) {
                            // Convertimos c_id a entero para comparar seguro
                            if ((int)$val->c_id === (int)$id) {
                                return is_numeric($val->best_location) ? $val->best_location : 0;
                            }
                        }
                        return 0;
                    };

                    // 4. Guardamos
                    Product::create([
                        'name' => $simpleFood->f_ori_name,
                        'bedca_id' => $simpleFood->f_id,
                        'category_id' => $category->id,
                        'user_id' => null,

                        // IDs Nutrientes BEDCA:
                        'calories' => $getVal(409),
                        'fat' => $getVal(410),
                        'saturated_fat' => $getVal(299),
                        'monounsaturated_fat' => $getVal(282),
                        'polyunsaturated_fat' => $getVal(287),
                        'trans_fat' => 0,           
                        'cholesterol' => $getVal(433),
                        'carbohydrates' => $getVal(53),
                        'fiber' => $getVal(307),
                        'protein' => $getVal(416),
                        'sodium' => $getVal(323),
                    ]);
                }

            } catch (\Exception $e) {
                $this->command->error("Error: " . $e->getMessage());
            }
        }
    }
}
