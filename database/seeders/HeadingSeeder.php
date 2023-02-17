<?php

namespace Database\Seeders;

use App\Models\Marquee;
use Illuminate\Database\Seeder;

class HeadingSeeder extends Seeder
{
    public function run()
    {
        $user = Marquee::create([
            'headings' => 'Testing testing',
        ]);
    }
}
