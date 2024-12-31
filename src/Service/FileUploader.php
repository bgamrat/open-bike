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

    public const IMAGES = 'images';

    public function __construct(
            private ?string $uploadDirectory,
            private SluggerInterface $slugger
    ) {

    }

    // this isn't a regular PHP file upload, it moves to support EasyAdmin
    public function uploadImageField(string $contentType, File $file): string {

        $safeFilename = $this->slugger->slug(pathinfo($file,PATHINFO_FILENAME));
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
        try {
            $file->move($this->getTargetDirectory($contentType), $fileName);
        } catch (FileException $e) {
            dd($this->getTargetDirectory($contentType),$file,$e);
            dd($e);
        }

        return $fileName;
    }

    public function getTargetDirectory(string $type): string {
        $dir = $this->uploadDirectory . '/' . $type;
        if (!is_dir($dir)) {
            throw new DirectoryNotFoundException($dir);
        }
        return $dir;
    }
}
