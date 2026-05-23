<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Run: php artisan db:seed
     */
    public function run(): void
    {
        // Buat Admin User
        User::factory()->create([
            'name' => 'Admin NexaNews',
            'email' => 'admin@nexanews.com',
            'password' => bcrypt('admin123456'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Buat Regular User
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'status' => 'active',
        ]);

        // Buat Kategori
        $categories = [
            [
                'name' => 'Makanan',
                'slug' => 'makanan',
                'description' => 'Berita dan tips seputar makanan, resep, kuliner, dan keamanan pangan.',
                'color' => '#EF4444',
            ],
            [
                'name' => 'Teknologi',
                'slug' => 'teknologi',
                'description' => 'Perkembangan terbaru di dunia teknologi, gadget, software, dan inovasi digital.',
                'color' => '#3B82F6',
            ],
            [
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'description' => 'Informasi tentang pendidikan, beasiswa, tips belajar, dan pengembangan diri.',
                'color' => '#8B5CF6',
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Buat Sample Articles
        $admin = User::where('role', 'admin')->first();

        $articles = [
            [
                'title' => '5 Resep Makanan Sehat untuk Diet Seimbang',
                'slug' => '5-resep-makanan-sehat-untuk-diet-seimbang',
                'content' => 'Diet seimbang adalah kunci untuk hidup sehat. Berikut adalah 5 resep makanan sehat yang mudah dibuat di rumah...',
                'image' => null,
                'status' => 'published',
                'category_id' => 1,
                'user_id' => $admin->id,
            ],
            [
                'title' => 'AI dan Machine Learning Mengubah Masa Depan',
                'slug' => 'ai-dan-machine-learning-mengubah-masa-depan',
                'content' => 'Artificial Intelligence dan Machine Learning sedang merevolusi berbagai industri. Pelajari bagaimana teknologi ini bekerja...',
                'image' => null,
                'status' => 'published',
                'category_id' => 2,
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Panduan Lengkap Persiapan Ujian Nasional',
                'slug' => 'panduan-lengkap-persiapan-ujian-nasional',
                'content' => 'Ujian Nasional adalah momen penting dalam perjalanan pendidikan. Ikuti panduan lengkap ini untuk mempersiapkan diri...',
                'image' => null,
                'status' => 'published',
                'category_id' => 3,
                'user_id' => $admin->id,
            ],
        ];

        foreach ($articles as $article) {
            $article['published_at'] = now();
            Article::create($article);
        }
    }
}

