<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $logger;
    private $slugger;

    public function __construct(LoggerInterface $logger, SluggerInterface $slugger)
    {
        $this->logger = $logger;
        $this->slugger = $slugger;
    }

    public function upload($uploadDir, UploadedFile $file)
    {
        try {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $fileName = $safeFilename.'-'.uniqid().'.'.$file->getClientOriginalExtension();

            $file->move($uploadDir, $fileName);
            return $fileName;
        } catch (FileException $e){
            $this->logger->error('failed to upload image: ' . $e->getMessage());
            throw new FileException('Failed to upload file');
        }
    }
}