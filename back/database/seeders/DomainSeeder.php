<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\Publisher;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    public function run()
    {
        $domains = new Domain;

        foreach ([
                     [1 =>'https://easybrain.com/'],
                     [1 => 'https://www.etermax.com/'],
                     [2 => 'https://www.forbes.com/'],
                     [2 => 'https://www.mobpals.com'],
                     [3 => 'https://www.cbs.com/'],
                     [1 => 'https://gizmodo.com/'],
                     [1 => 'https://www.vice.com/']
                 ] as $p) {

            $domains->create([
                'publisher_id' => key($p),
                'name' => current($p)
            ]);

        }
    }
}
