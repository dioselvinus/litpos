<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File as HttpFile;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
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
     * @return array<string, mixed>
     */
    public function definition()
    {
        $image = $this->faker->image(null, 750, 400, 'nightlife');
        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->name,
            'image' => Storage::putFile('public/images/products', new HttpFile($image), 'public'),
            'category' => $this->faker->randomElement(['food', 'drink']),
            'price' => $this->faker->numberBetween(1000, 10000),
            'status' => $this->faker->randomElement(['available', 'unavailable']),
        ];
    }
}
