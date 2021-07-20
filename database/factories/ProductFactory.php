<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->numerify($this->faker->colorName . ' ###'),
            'price' => $this->faker->randomElement([25000, 35000, 50000, 75000, 85000, 150000]),
            'about' => $this->faker->realText(25, 1),
            'picture' => null,
            'category_id' => $this->faker->randomElement([1, 2, 3]),
        ];
    }
}
