<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CompressProductFeaturedImages extends Command
{
    protected $signature = 'images:compress-featured';

    protected $description = 'Compress images to 200-400 KB without changing filename or extension';

    private int $minSize = 200 * 1024; // 200 KB
    private int $maxSize = 400 * 1024; // 400 KB

    public function handle()
    {
        $folder = storage_path('app/public/product_featured');

        if (!is_dir($folder)) {
            $this->error("Folder not found: {$folder}");
            return self::FAILURE;
        }

        $files = glob($folder . '/*');

        $compressed = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($files as $file) {

            if (!is_file($file)) {
                continue;
            }

            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                continue;
            }

            $originalSize = filesize($file);

            /*
             * Do NOT compress files under 200 KB.
             */
            if ($originalSize < $this->minSize) {

                $skipped++;

                $this->line(
                    basename($file) .
                    ' | SKIPPED | ' .
                    $this->formatBytes($originalSize)
                );

                continue;
            }

            /*
             * Already inside 200-400 KB.
             */
            if ($originalSize <= $this->maxSize) {

                $skipped++;

                $this->line(
                    basename($file) .
                    ' | OK | ' .
                    $this->formatBytes($originalSize)
                );

                continue;
            }

            try {

                /*
                 * Detect actual image type.
                 * This fixes files where .jpg actually contains PNG data.
                 */
                $info = @getimagesize($file);

                if (!$info || empty($info['mime'])) {
                    throw new \Exception('Invalid or unreadable image');
                }

                $mime = $info['mime'];

                /*
                 * Load according to ACTUAL image type.
                 */
                switch ($mime) {

                    case 'image/jpeg':
                        $image = @imagecreatefromjpeg($file);
                        break;

                    case 'image/png':
                        $image = @imagecreatefrompng($file);
                        break;

                    case 'image/webp':
                        $image = @imagecreatefromwebp($file);
                        break;

                    default:
                        throw new \Exception(
                            'Unsupported image type: ' . $mime
                        );
                }

                if (!$image) {
                    throw new \Exception('Could not load image');
                }

                /*
                 * Get dimensions.
                 */
                $width = imagesx($image);
                $height = imagesy($image);

                /*
                 * Start with original dimensions.
                 */
                $currentWidth = $width;
                $currentHeight = $height;

                $bestData = null;
                $bestSize = PHP_INT_MAX;

                /*
                 * Try progressively smaller dimensions.
                 */
                for ($resizeStep = 0; $resizeStep < 8; $resizeStep++) {

                    /*
                     * Recreate image at current dimensions.
                     */
                    if ($currentWidth != $width || $currentHeight != $height) {

                        $resized = imagecreatetruecolor(
                            $currentWidth,
                            $currentHeight
                        );

                        /*
                         * Preserve transparency for PNG/WebP.
                         */
                        if ($extension === 'png' || $extension === 'webp') {

                            imagealphablending($resized, false);
                            imagesavealpha($resized, true);

                            $transparent = imagecolorallocatealpha(
                                $resized,
                                255,
                                255,
                                255,
                                127
                            );

                            imagefilledrectangle(
                                $resized,
                                0,
                                0,
                                $currentWidth,
                                $currentHeight,
                                $transparent
                            );
                        }

                        imagecopyresampled(
                            $resized,
                            $image,
                            0,
                            0,
                            0,
                            0,
                            $currentWidth,
                            $currentHeight,
                            $width,
                            $height
                        );

                        $workingImage = $resized;

                    } else {
                        $workingImage = $image;
                    }

                    /*
                     * For JPEG/WebP:
                     * search for the highest quality that gets
                     * the file below 400 KB.
                     */
                    if ($extension === 'jpg' || $extension === 'jpeg' || $extension === 'webp') {

                        $low = 20;
                        $high = 90;

                        $candidateData = null;
                        $candidateSize = PHP_INT_MAX;

                        while ($low <= $high) {

                            $quality = intdiv($low + $high, 2);

                            ob_start();

                            if ($extension === 'webp') {
                                imagewebp(
                                    $workingImage,
                                    null,
                                    $quality
                                );
                            } else {
                                imagejpeg(
                                    $workingImage,
                                    null,
                                    $quality
                                );
                            }

                            $data = ob_get_clean();

                            $size = strlen($data);

                            if (
                                $size >= $this->minSize &&
                                $size <= $this->maxSize
                            ) {
                                $candidateData = $data;
                                $candidateSize = $size;

                                /*
                                 * Try higher quality.
                                 */
                                $low = $quality + 1;

                            } elseif ($size > $this->maxSize) {

                                /*
                                 * Need more compression.
                                 */
                                $high = $quality - 1;

                            } else {

                                /*
                                 * Below 200 KB.
                                 */
                                $low = $quality + 1;
                            }
                        }

                        /*
                         * If we found a 200-400 KB version,
                         * use it.
                         */
                        if ($candidateData !== null) {

                            if ($candidateSize < $bestSize) {
                                $bestData = $candidateData;
                                $bestSize = $candidateSize;
                            }

                            if ($candidateSize >= $this->minSize) {
                                break;
                            }
                        }

                    } else {

                        /*
                         * PNG is lossless.
                         * Quality cannot be used to reduce PNG
                         * enough, so we resize it.
                         */
                        ob_start();

                        imagepng(
                            $workingImage,
                            null,
                            9
                        );

                        $data = ob_get_clean();

                        $size = strlen($data);

                        if (
                            $size >= $this->minSize &&
                            $size <= $this->maxSize
                        ) {
                            $bestData = $data;
                            $bestSize = $size;
                            break;
                        }

                        if (
                            $size < $bestSize &&
                            $size >= $this->minSize
                        ) {
                            $bestData = $data;
                            $bestSize = $size;
                        }
                    }

                    /*
                     * Clean resized image.
                     */
                    if (
                        isset($resized) &&
                        is_object($resized)
                    ) {
                        imagedestroy($resized);
                        unset($resized);
                    }

                    /*
                     * Reduce dimensions by 15%.
                     */
                    $currentWidth = max(
                        300,
                        (int) ($currentWidth * 0.85)
                    );

                    $currentHeight = max(
                        300,
                        (int) ($currentHeight * 0.85)
                    );
                }

                /*
                 * Destroy original GD image.
                 */
                imagedestroy($image);

                /*
                 * No suitable compression found.
                 */
                if ($bestData === null) {

                    $errors++;

                    $this->error(
                        basename($file) .
                        ' | Could not reach 200-400 KB'
                    );

                    continue;
                }

                $newSize = strlen($bestData);

                /*
                 * Safety check:
                 * never replace with something larger.
                 */
                if ($newSize >= $originalSize) {

                    $skipped++;

                    $this->line(
                        basename($file) .
                        ' | KEPT | ' .
                        $this->formatBytes($originalSize) .
                        ' | compressed version not smaller'
                    );

                    continue;
                }

                /*
                 * Write temporary file first.
                 */
                $tempFile = $file . '.tmp';

                file_put_contents($tempFile, $bestData);

                /*
                 * Replace original.
                 */
                rename($tempFile, $file);

                $compressed++;

                $this->info(
                    basename($file) .
                    ' | ' .
                    $this->formatBytes($originalSize) .
                    ' → ' .
                    $this->formatBytes($newSize)
                );

            } catch (\Throwable $e) {

                $errors++;

                $this->error(
                    basename($file) .
                    ' | ERROR | ' .
                    $e->getMessage()
                );
            }
        }

        $this->newLine();

        $this->info('================================');
        $this->info('Compression completed');
        $this->info('Compressed: ' . $compressed);
        $this->info('Skipped: ' . $skipped);
        $this->info('Errors: ' . $errors);
        $this->info('================================');

        return self::SUCCESS;
    }

    private function formatBytes($bytes)
    {
        if ($bytes >= 1024 * 1024) {
            return number_format(
                $bytes / 1024 / 1024,
                2
            ) . ' MB';
        }

        return number_format(
            $bytes / 1024,
            2
        ) . ' KB';
    }
}