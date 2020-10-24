<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(PublisherSeeder::class);

         $this->call(DomainSeeder::class);

         $this->call(EntrySeeder::class);

         $this->call(AssetSeeder::class);
    }
}
