<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use function dd;

class FileUploader {

    public function __construct(
            private string $projectDir,
            private SluggerInterface $slugger
    ) {

    }

    // this isn't a regular PHP file upload, it moves images to support EasyAdmin
    public function uploadImageField(string $basePath, File $file, string $id): string {

        $targetDirectory = $this->getTargetDirectory('public/' . $basePath);

        $existingVersions = glob($targetDirectory.'/'.$id.'.*');
        foreach ($existingVersions as $f) {
            unlink($f);
        }
        $filename = $id . '.' . $file->guessExtension();

        try {
            $file->move($targetDirectory, $filename);

        } catch (FileException $e) {
            dd($this->getTargetDirectory($basePath), $file, $e);
            dd($e);
        }

        return $filename;
    }

    public function getTargetDirectory(string $basePath): string {

        $dir = $this->projectDir . '/' . $basePath;

        if (!is_dir($dir)) {
            throw new DirectoryNotFoundException($dir);
        }
        return $dir;
    }
}
