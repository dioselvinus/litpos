<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File as HttpFile;
use Ramsey\Uuid\Uuid;

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
        $this->faker->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($this->faker));
        $this->faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($this->faker));
        $image = $this->faker->image(null, 750, 400, ['products']);
        return [
            'id' => Uuid::uuid4()->toString(),
            'name' => $this->faker->foodName(),
            'image' => Storage::putFile('images/products', new HttpFile($image)),
            'category' => $this->faker->randomElement(['food', 'drink']),
            'price' => $this->faker->numberBetween(1000, 10000),
            'status' => $this->faker->randomElement(['available', 'unavailable']),
        ];
    }
}
