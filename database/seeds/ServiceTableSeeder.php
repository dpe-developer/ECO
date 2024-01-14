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
                'name' => 'Comprehensive Eye Exam',
                'amount' => '0.00',
                'description' => 'Comprehensive eye exams by a doctor of optometry are an important part of caring for your eyes, vision, and overall all health.'
            ],
            [
                'name' => 'Preventive and Rehabilitative Optometry',
                'amount' => '0.00',
                'description' => 'two aspects of eye care that focus on maintaining and improving the visual health of individuals. These areas of optometry involve different approaches and techniques to address various eye conditions.'
            ],
            [
                'name' => 'Sports Vision Optometry',
                'amount' => '0.00',
                'description' => 'also known as sports vision training or sports vision therapy, is a specialized field within optometry that focuses on enhancing the visual abilities and performance of athletes. The goal is to optimize visual skills that are crucial for success in various sports.'
            ],
            [
                'name' => 'Low Vision Optometry',
                'amount' => '0.00',
                'description' => ' specialized field within optometry that focuses on the assessment, management, and rehabilitation of individuals with low vision. Low vision refers to a significant visual impairment that cannot be fully corrected by conventional eyeglasses, contact lenses, medication, or surgery. People with low vision often experience difficulties with daily activities, such as reading, writing, driving, and recognizing faces.'
            ],
            [
                'name' => 'Vision Therapy',
                'amount' => '0.00',
                'description' => "also known as visual therapy or vision training, is a specialized program of eye exercises and activities designed to improve and enhance a person's visual skills and abilities. It is often prescribed by optometrists to address various vision problems that cannot be corrected with glasses, contact lenses, or surgery alone. Vision therapy is particularly beneficial for conditions related to eye coordination, binocular vision, and certain visual perceptual skills."
            ],
            [
                'name' => 'Color Vision Phototherapy',
                'amount' => '0.00',
                'description' => "also known as visual therapy or vision training, is a specialized program of eye exercises and activities designed to improve and enhance a person's visual skills and abilities. It is often prescribed by optometrists to address various vision problems that cannot be corrected with glasses, contact lenses, or surgery alone. Vision therapy is particularly beneficial for conditions related to eye coordination, binocular vision, and certain visual perceptual skills."
            ]
        ]);
    }   
}
