<?php

namespace App\Controller;

use App\Entity\UploadedFiles;
use App\Repository\UploadedFilesRepository;
use App\Service\UploadedFileService;
use ContainerCgKZUeN\getUploadedFileServiceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/files", name="files")
     */
    public function files(UploadedFileService $uploadedFileService): Response
    {
        return $this->render('home/files.html.twig', [
            'files' => $uploadedFileService->getAll()
        ]);
    }

    /**
     * @Route("/files/detail/{id}", name="files.detail")
     */
    public function detail(UploadedFileService $uploadedFileService, int $id): Response
    {
        return $this->render('home/detail.html.twig', $uploadedFileService->getDetail($id));
    }
}