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
    // Process all images recursively inside storage/app/public
    $path = storage_path('app/public');

    if (!File::exists($path)) {
        $this->error('Storage folder not found!');
        return Command::FAILURE;
    }

    // Get all files from every subfolder
    $files = File::allFiles($path);

    $totalBefore = 0;
    $totalAfter = 0;
    $processed = 0;
    $skipped = 0;

    foreach ($files as $file) {

        $ext = strtolower($file->getExtension());

        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            continue;
        }

        $filePath = $file->getPathname();

        $before = filesize($filePath);

        try {

            switch ($ext) {

                case 'jpg':
                case 'jpeg':

                    $image = @imagecreatefromjpeg($filePath);

                    if (!$image) {
                        $skipped++;
                        continue 2;
                    }

                    imagejpeg($image, $filePath, 75);

                    imagedestroy($image);
                    break;

                case 'png':

                    $image = @imagecreatefrompng($filePath);

                    if (!$image) {
                        $skipped++;
                        continue 2;
                    }

                    imagealphablending($image, false);
                    imagesavealpha($image, true);

                    imagepng($image, $filePath, 8);

                    imagedestroy($image);
                    break;

                case 'webp':

                    if (!function_exists('imagecreatefromwebp')) {
                        $skipped++;
                        continue 2;
                    }

                    $image = @imagecreatefromwebp($filePath);

                    if (!$image) {
                        $skipped++;
                        continue 2;
                    }

                    imagewebp($image, $filePath, 80);

                    imagedestroy($image);
                    break;
            }

            clearstatcache(true, $filePath);

            $after = filesize($filePath);

            $totalBefore += $before;
            $totalAfter += $after;
            $processed++;

            $this->info(
                $file->getRelativePathname() . ' : ' .
                round($before / 1024, 2) . ' KB -> ' .
                round($after / 1024, 2) . ' KB'
            );

        } catch (\Throwable $e) {

            $skipped++;

            $this->error(
                $file->getRelativePathname() . ' : ' . $e->getMessage()
            );
        }
    }

    $saved = $totalBefore - $totalAfter;

    $this->newLine();

    $this->info('Image compression completed!');
    $this->info("Processed: {$processed}");
    $this->info("Skipped: {$skipped}");

    $this->info(
        'Original Size: ' . round($totalBefore / 1048576, 2) . ' MB'
    );

    $this->info(
        'Final Size: ' . round($totalAfter / 1048576, 2) . ' MB'
    );

    $this->info(
        'Space Saved: ' . round($saved / 1048576, 2) . ' MB'
    );

    if ($totalBefore > 0) {
        $this->info(
            'Reduction: ' . round(($saved / $totalBefore) * 100, 2) . '%'
        );
    }

    return Command::SUCCESS;
}

}