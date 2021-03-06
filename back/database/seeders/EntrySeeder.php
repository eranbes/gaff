<?php

namespace Database\Seeders;

use App\Models\Entry;
use Illuminate\Database\Seeder;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entry = new Entry;

        foreach ([
                     [3, 'pubmatic.com, 156371, direct, 5d62403b186f2ace', false],
                     [3, 'pubmatic.com, 156371, direct, 5d62403b186f2a4e', false],
                     [3, 'Yahoo.com, 54798, direct, e1a5b5b6e3255540', false],
                     [4, 'cedato.com, 159323656, RESELLER', true],
                     [4, 'cedato.com, 25944061, RESELLER', true],
                     [4, 'cedato.com, 501446106, RESELLER', true],
                     [4, 'cedato.com, 67407424, RESELLER', true],
                     [4, 'freewheel.tv, 1089345, RESELLER', true],
                     [4, 'freewheel.tv, 1089345, RESELLER', false],
                     [4, 'appnexus.com, 1314, RESELLER, f5ab79cb980f11d1', false],
                     [4, 'cmcm.com, 104, RESELLER', false],
                     [4, 'cmcm.com, 72, RESELLER,', false],
                     [4, 'fair-trademedia.com, 88, DIRECT', false],
                     [4, 'pubmatic.com, 157181, DIRECT, 5d62403b186f2ace', true],
                     [4, 'rhythmone.com, 1708260210, DIRECT, a670c89d4a324e47', true],
                     [4, 'rubiconproject.com, 10970, DIRECT, 0bfd66d529a55807', true],
                 ] as $e) {

            $entry->create([
                'domain_id' => $e[0],
                'name' => $e[1],
                'is_app' => $e[2]
            ]);

        }
    }
}
