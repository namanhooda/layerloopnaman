<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CompressProductImages extends Command
{
    protected $signature = 'images:compress';
    protected $description = 'Compress all product images';

    public function handle()
    {
        $path = storage_path('app/public/product_featured');

        if (!File::exists($path)) {
            $this->error('Folder not found!');
            return Command::FAILURE;
        }

        $files = File::files($path);

        foreach ($files as $file) {

            $ext = strtolower($file->getExtension());

            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                continue;
            }

            $filePath = $file->getPathname();

            $before = round(filesize($filePath) / 1024, 2);

            if ($ext == 'jpg' || $ext == 'jpeg') {

                $image = imagecreatefromjpeg($filePath);

                imagejpeg($image, $filePath, 75);

                imagedestroy($image);

            } else {

                $image = imagecreatefrompng($filePath);

                imagepalettetotruecolor($image);

                imagealphablending($image, true);

                imagesavealpha($image, true);

                // PNG compression: 0 (none) to 9 (max)
                imagepng($image, $filePath, 8);

                imagedestroy($image);
            }

            clearstatcache();

            $after = round(filesize($filePath) / 1024, 2);

            $this->info("{$file->getFilename()} : {$before} KB -> {$after} KB");
        }

        $this->info('Done!');
    }
}