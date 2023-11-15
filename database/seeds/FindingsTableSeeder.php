<?php

use Illuminate\Database\Seeder;
use App\Models\Finding;

class FindingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Finding::insert([
            [
                'name' => 'Myopia',
                'description' => "Nearsightedness; A vision condition in which near objects appear clear, but objects farther away look blurry. It occurs when the shape of the eye — or the shape of certain parts of the eye — causes light rays to bend (refract) inaccurately.",
            ],
            [
                'name' => 'Hyperopia',
                'description' => "Farsightedness; A vision condition in which distant objects are usually seen more clearly than close ones. Hyperopia occurs due to the shape of the eye and its components; it is not just a function of the aging of the lens, which occurs with presbyopia.",
            ],
            [
                'name' => 'Presbyopia',
                'description' => "Refractive error that makes it hard for middle-aged and older adults to see things up close. It happens because the lens (an inner part of the eye that helps the eye focus) stops focusing light correctly on the retina (a light-sensitive layer of tissue at the back of the eye).",
            ],
            [
                'name' => 'Astigmatism',
                'description' => "A common eye problem that can make your vision blurry or distorted. It happens when your cornea (the clear front layer of your eye) or lens (an inner part of your eye that helps the eye focus) has a different shape than normal.",
            ],
            [
                'name' => 'Strabismus',
                'description' => "A condition in which one eye is turned in a direction that's different from the other eye. It's usually found in children, but it can also happen in adults. Treatment may include glasses, patching, eye exercises, medication or surgery.",
            ],
            [
                'name' => 'Amblyopia/Lazy Eye',
                'description' => "A type of poor vision that usually happens in just 1 eye but less commonly in both eyes. It develops when there's a breakdown in how the brain and the eye work together, and the brain can't recognize the sight from 1 eye.",
            ],
            [
                'name' => 'Color Blind',
                'description' => "Occurs when you are unable to see colors in a normal way. It is also known as color deficiency. Color blindness often happens when someone cannot distinguish between certain colors. This usually happens between greens and reds, and occasionally blues.",
            ],
            [
                'name' => 'Low Vision',
                'description' => "vision loss that can't be corrected with glasses, contacts or surgery. It isn't blindness as limited sight remains. Low vision can include blind spots, poor night vision and blurry sight. The most common causes are age-related macular degeneration, glaucoma and diabetes.",
            ],
        ]);
    }
}
