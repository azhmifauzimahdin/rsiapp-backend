<?php

namespace Database\Seeders;

use App\Models\Guarantor;
use App\Models\IpAddress;
use App\Models\Patient;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Guarantor::create([
            'code' => '1000000',
            'name' => 'PRIBADI'
        ]);
        Guarantor::create([
            'code' => '9999999',
            'name' => 'RS ISLAM KOTA MAGELANG'
        ]);
        Guarantor::create([
            'code' => 'G0001',
            'name' => 'PT ASURANSI BINA DANA ARTA'
        ]);
        Guarantor::create([
            'code' => 'G0002',
            'name' => 'BPD JATENG SUKOHARJO'
        ]);
        Guarantor::create([
            'code' => 'G0003',
            'name' => 'BNI LIFE'
        ]);
        Guarantor::create([
            'code' => 'G0004',
            'name' => 'KEMENTRIAN KESEHATAN'
        ]);
        Guarantor::create([
            'code' => 'G0007',
            'name' => 'JASA RAHARJA'
        ]);
        Guarantor::create([
            'code' => 'G0008',
            'name' => 'IN-HEALTH'
        ]);
        Guarantor::create([
            'code' => 'G0009',
            'name' => 'GARDA MEDIKA'
        ]);
        Guarantor::create([
            'code' => 'G0010',
            'name' => 'AD MEDIKA'
        ]);
        Guarantor::create([
            'code' => 'G0184',
            'name' => 'BPJS KESEHATAN'
        ]);
        Guarantor::create([
            'code' => 'G0185',
            'name' => 'BPJS KETERNAGAKERJAAN'
        ]);

        // IpAddress::create([
        //     'name' => '180.246.111.203'
        // ]);

        // Patient::create([
        //     'rm' => '12345',
        //     'episode' => '1',
        //     'name' => 'Test User 1',
        //     'guarantor_code' => 'G0184'
        // ]);

        // Patient::create([
        //     'rm' => '12346',
        //     'episode' => '1',
        //     'name' => 'Test User 2',
        //     'guarantor_code' => '1000000'
        // ]);
    }
}
