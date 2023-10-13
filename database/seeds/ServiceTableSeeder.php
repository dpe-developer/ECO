<?php

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert([
            [
                'name' => 'Preventive and Rehabilitative Optometry',
                'amount' => '0.00',
                'description' => ''
            ],
            [
                'name' => 'Sports Vision Optometry',
                'amount' => '0.00',
                'description' => ''
            ],
            [
                'name' => 'Low Vision Optometry',
                'amount' => '0.00',
                'description' => ''
            ],
            [
                'name' => 'Vision Therapy',
                'amount' => '0.00',
                'description' => ''
            ],
            [
                'name' => 'Color Vision Phototherapy',
                'amount' => '0.00',
                'description' => ''
            ],
            [
                'name' => 'Visual Therapy Flip Per Second',
                'amount' => '0.00',
                'description' => ''
            ]
        ]);
    }   
}
