<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory as Faker;

class BlogsSeeder extends Seeder
{
    public function run()
    {
        helper(['text']);

        $faker = Faker::create();

        // Ensure categories and tags exist
        $this->call(CategoriesSeeder::class);
        $this->call(TagsSeeder::class);

        $db         = $this->db;
        $blogs      = $db->table('blogs');
        $blogTags   = $db->table('blog_tags');
        $categories = $db->table('categories')->get()->getResultArray();
        $tags       = $db->table('tags')->get()->getResultArray();

        if (empty($categories) || empty($tags)) {
            return; // nothing to seed
        }

        $categoryIds = array_column($categories, 'id');
        $tagIds      = array_column($tags, 'id');

        for ($i = 0; $i < 25; $i++) {
            $title = ucfirst($faker->unique()->words($faker->numberBetween(3, 7), true));
            $slug  = url_title($title, '-', true);

            $content = '';
            foreach (range(1, $faker->numberBetween(3, 6)) as $p) {
                $content .= '<p>' . $faker->paragraph($faker->numberBetween(3, 7)) . '</p>';
            }

            $now = date('Y-m-d H:i:s');
            $blogData = [
                'title'          => $title,
                'slug'           => $slug,
                'seo_title'      => $title,
                'seo_description'=> $faker->sentences(2, true),
                'summary'        => $faker->sentences(2, true),
                'content'        => $content,
                'blockquote'     => $faker->boolean(60) ? $faker->sentence(12) : null,
                'final_thoughts' => $faker->boolean(50) ? $faker->sentences(2, true) : null,
                'author_id'      => 1, // assume first user; adjust if needed
                'category_id'    => $faker->randomElement($categoryIds),
                'image_id'       => null,
                'status'         => 'published',
                'created_at'     => $now,
                'updated_at'     => $now,
                'published_at'   => $now,
            ];

            $blogs->insert($blogData);
            $blogId = $db->insertID();

            // Attach 2-4 random tags
            $attachTagIds = (array) array_unique($faker->randomElements($tagIds, $faker->numberBetween(2, 4)));
            foreach ($attachTagIds as $tagId) {
                $blogTags->ignore(true)->insert([
                    'blog_id' => $blogId,
                    'tag_id'  => $tagId,
                ]);
            }
        }
    }
}
