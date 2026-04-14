<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Distributor;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            ['nama' => 'PT Aman farmasindo abadi', 'alamat' => 'jl. lawanggada no.54 cirebon'],
            ['nama' => 'PT carmella gustavindo', 'alamat' => 'jl. lawanggada no.3 cirebon'],
            ['nama' => 'PT kudamas jaya makmur sentosa', 'alamat' => 'bandung'],
            ['nama' => 'PT Jaya bakti Raharja', 'alamat' => 'cirebon'],
            ['nama' => 'PT Elnaz berkah bersama', 'alamat' => 'cirebon'],
            // dst...
        ];

        foreach ($data as $item) {
            Distributor::create($item);
        }
    }
}
