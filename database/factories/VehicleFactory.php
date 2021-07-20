<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'name' => $this->faker->secondaryAddress,
            'brand' => $this->faker->cityPrefix,
            'year' => $this->faker->year(),
            'plate_number' => $this->faker->numerify("AA ##### XX"),
            'chassis_number' => $this->faker->unixTime(),
        ];
    }
}
