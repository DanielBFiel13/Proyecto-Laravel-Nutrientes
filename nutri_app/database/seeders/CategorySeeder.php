<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use StaticKidz\BedcaAPI\BedcaClient;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Conectando a BEDCA...');

        try {
            $client = new BedcaClient();
            $data = $client->getFoodGroups();

            $listaGrupos = $data->food;


            foreach ($listaGrupos as $grupo) {

                Category::updateOrCreate(
                    ['bedca_id' => $grupo->fg_id],
                    ['name' => $grupo->fg_ori_name]
                );
            }

            $this->command->info('¡Categorías importadas correctamente!');

        } catch (\Exception $e) {
            $this->command->error('Error: ' . $e->getMessage());
        }
    }
}
