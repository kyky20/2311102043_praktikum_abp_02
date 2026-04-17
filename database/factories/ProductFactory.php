<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            'Beras Premium 5kg', 'Beras Ramos 5kg', 'Minyak Goreng Bimoli 1L', 'Minyak Goreng Sunco 2L',
            'Indomie Goreng', 'Indomie Kari Ayam', 'Indomie Soto Mie', 'Mie Sedap Goreng',
            'Gula Pasir Gulaku 1kg', 'Gula Kristal Putih 1kg', 'Kopi Kapal Api 380g', 'Kopi ABC Susu (Renceng)',
            'Teh Celup Sosro (Isi 30)', 'Sariwangi Teh Asli', 'Susu Kental Manis Frisian Flag', 'Susu Kental Manis Indomilk',
            'Tepung Terigu Segitiga Biru', 'Tepung Terigu Cakra Kembar', 'Sabun Lifebuoy Lemon', 'Sabun Nuvo Family',
            'Shampo Clear 160ml', 'Shampo Pantene 130ml', 'Pasta Gigi Pepsodent 190g', 'Pasta Gigi CloseUp 160g',
            'Deterjen Rinso 700g', 'Deterjen Daia 850g', 'Pewangi Downy 900ml', 'Molto All-in-1',
            'Aqua Botol 600ml', 'Le Minerale 600ml', 'Teh Pucuk Harum 350ml', 'Sprite Botol 390ml',
            'Taro Net Seaweed', 'Chitato Sapi Panggang', 'Biskuit Roma Kelapa', 'Oreo Chocolate 133g',
            'Kecap Bango 520ml', 'Kecap ABC 520ml', 'Saus Sambal ABC 340ml', 'Saus Tomat Indofood 340ml',
            'Telur Ayam Kampung 1kg', 'Telur Ayam Negeri 1kg', 'Garam Kapal 250g', 'Garam Dolphin 500g',
            'Mentega Blue Band 200g', 'Susu Dancow Instan 400g', 'Sirup Marjan Melon', 'Energen Cokelat (Renceng)',
            'Korek Gas Tokai', 'Obat Nyamuk Hit (Semprot)', 'Wipol Karbol 750ml', 'Mama Lemon 780ml'
        ];

        return [
            'sku' => $this->faker->unique()->numerify('PRD-#####'),
            'name' => $this->faker->unique()->randomElement($products),
            'price' => $this->faker->numberBetween(10, 150) * 500, // prices like 5000, 7500, 12000...
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
