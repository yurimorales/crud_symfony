<?php 

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function upload($uploadDir, $file, $filename)
    {

        try {

            $originalFilename = pathinfo($filename, PATHINFO_FILENAME);
            // Sanitiza nome do arquivo, antes de renomear
            $safeFilename = $this->slugger->slug($originalFilename);

            $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
            
            $file->move($uploadDir, $newFilename);

            return $newFilename;

        } catch (FileException $e){
            return null;
        }

    }

}