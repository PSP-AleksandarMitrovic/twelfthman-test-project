<?php

use Illuminate\Database\Seeder;

class ImagesVersionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('images_versions')->insert([
            [
                'image_id' => 1,
                'type' => 'medium',
                'path' => '1/image-1_M.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'image_id' => 1,
                'type' => 'thumbnail',
                'path' => '1/image-1_T.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'image_id' => 2,
                'type' => 'medium',
                'path' => '2/image-2_M.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'image_id' => 2,
                'type' => 'thumbnail',
                'path' => '2/image-2_T.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'image_id' => 3,
                'type' => 'medium',
                'path' => '3/image-3_M.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'image_id' => 3,
                'type' => 'thumbnail',
                'path' => '3/image-3_T.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'image_id' => 4,
                'type' => 'medium',
                'path' => '4/image-4_M.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'image_id' => 4,
                'type' => 'thumbnail',
                'path' => '4/image-4_T.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'image_id' => 5,
                'type' => 'medium',
                'path' => '5/image-5_M.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'image_id' => 5,
                'type' => 'thumbnail',
                'path' => '5/image-5_T.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'image_id' => 6,
                'type' => 'medium',
                'path' => '6/image-5_M.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'image_id' => 6,
                'type' => 'thumbnail',
                'path' => '6/image-5_T.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]]);
    }
}
