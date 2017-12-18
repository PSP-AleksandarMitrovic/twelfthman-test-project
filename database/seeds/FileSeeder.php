<?php

use App\Modules\FileSystem\Events\MakeResizedImagesEvent;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $downloads = [
            "1" => [
                "image-1.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513586503/1/image-1_asml5k.jpg",
                "image-1_M.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587302/1/image-1_M_mkr6mf.jpg",
                "image-1_T.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587307/1/image-1_T_y5p17t.jpg"
            ],
            "2" => [
                "image-2.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587766/2/image-2.jpg",
                "image-2_M.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587770/2/image-2_M.jpg",
                "image-2_T.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587773/2/image-2_T.jpg"
            ],
            "3" => [
              "image-3.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587790/3/image-3.jpg",
                "image-3_M.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587802/3/image-3_M.jpg",
                "image-3_T.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587806/3/image-3_T.jpg"
            ],
            "4" => [
              "image-4.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587826/4/image-4.jpg",
                "image-4_M.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587832/4/image-4_M.jpg",
                "image-4_T.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587835/4/image-4_T.jpg"
            ],
            "5" => [
                "image-5.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587941/5/image-5.jpg",
                "image-5_M.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587945/5/image-5_M.jpg",
                "image-5_T.jpg" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513587949/5/image-5_T.jpg"
            ],
            "6" => [
                "image-5.png" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513588682/6/image-5.jpg",
                "image-5_M.png" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513588689/6/image-5_M.jpg",
                "image-5_T.png" => "http://res.cloudinary.com/dkt5t42kz/image/upload/v1513588694/6/image-5_T.jpg"
            ]
        ];

        foreach($downloads as $folder => $images){
            foreach($images as $filename => $link) {
                $fo = fopen($link, "r");

                \Storage::disk('public')->put("/{$folder}/{$filename}", $fo);

                fclose($fo);
            }
        }
    }
}
