<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Concerts', 'icon' => 'fa-microphone'],
            ['name' => 'Parties', 'icon' => 'fa-cake-candles'],
            ['name' => 'Business', 'icon' => 'fa-briefcase'],
            ['name' => 'Sports', 'icon' => 'fa-soccer-ball'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                ['name' => $cat['name'], 'icon' => $cat['icon']]
            );
        }

        // Assign random categories to existing events
        $allCats = Category::all();
        foreach (Event::all() as $event) {
            if (!$event->category_id) {
                $event->update(['category_id' => $allCats->random()->id]);
            }
        }
    }
}
