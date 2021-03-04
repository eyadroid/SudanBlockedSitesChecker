<?php

namespace Database\Factories;

use App\Models\WebsiteRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebsiteRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WebsiteRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'available' => $this->faker->boolean(0.1)
        ];
    }
}
