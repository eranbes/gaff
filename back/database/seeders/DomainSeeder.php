<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\Publisher;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    public function run()
    {
        $pub_counter = Publisher::all()
            ->count();

        $domains = new Domain;

        foreach ([
                     'https://easybrain.com/',
                     'https://www.etermax.com/',
                     'https://www.forbes.com/',
                     'https://gizmodo.com/',
                     'https://www.vice.com/'
                 ] as $name) {

            $domains->create([
                'publisher_id' => random_int(1, $pub_counter),
                'name' => $name
            ]);

        }
    }
}
