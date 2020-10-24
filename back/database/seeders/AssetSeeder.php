<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assets = new Asset;

        foreach ([
            [3, 'Forbes', 'forbes.com'],
            [3, 'Gizmodo', 'gizmodo.com'],
            [3, 'EuroGamer', 'eurogamer.net'],
            [4, 'Dir App', 'com.mobpubs.dir'],
            [4, 'Drer App', 'com.mobpubs.drer'],
            [4, 'Delviner Suday App', 'com.delivnr'],
            [5, 'CBS Us App', 'com.cbc.us'],
            [5, 'CBS UK App', 'com.cbc.intel.uk'],
            [5, 'CBS Local App', 'com.local.train.cbs'],
            [5, 'CBS US Website', 'cbs.com'],
            [5, 'CBS UK Website', 'CBS UK Website'],
                 ] as $a) {

            $assets->create([
                'domain_id' => $a[0],
                'asset_name' => $a[1],
                'asset_id' => $a[2],
            ]);

        }
    }
}
