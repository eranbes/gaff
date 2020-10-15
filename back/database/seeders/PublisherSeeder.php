<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publishers = new Publisher;

        foreach ([
            'YANDEX',
            'ABCNetwork',
            'CBSNetwork'
        ] as $p ) {

            $publishers->create(['name' => $p]);

        }
    }
}
