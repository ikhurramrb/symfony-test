<?php

namespace App\Controller;

use App\Entity\FileErrorReporting;
use App\Entity\Invoice;
use App\Entity\UploadedFiles;
use App\Service\FileErrorReportService;
use App\Service\FileUploader;
use App\Service\InvoiceService;
use App\Service\UploadedFileService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use PHPUnit\Framework\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    /**
     * @Route("/doUpload", name="do-upload")
     * @param Request $request
     * @param string $uploadDir
     * @param FileUploader $uploader
     * @param LoggerInterface $logger
     * @return Response
     */
    public function index(Request $request, string $uploadDir, FileUploader $uploader,
                          UploadedFileService $uploadedFileService, InvoiceService $invoiceService,
                          FileErrorReportService $fileErrorReportService, LoggerInterface $logger): Response
    {
        $token = $request->get("token");

        if (!$this->isCsrfTokenValid('upload', $token)) {
            $logger->info("CSRF failure");

            return new Response("Operation not allowed", Response::HTTP_BAD_REQUEST,
                ['content-type' => 'text/plain']);
        }

        $file = $request->files->get('myFile');

        if (empty($file)) {
            return new Response("No file specified",
                Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }

        $fileName = $uploader->upload($uploadDir, $file);

        $uploadedFile = $uploadedFileService->create([
            'fileName' => $fileName,
            'created_at' => new \DateTimeImmutable()
        ]);

        $validator = Validation::createValidator();

        $constraint = new Assert\Collection([
            'id' => new Assert\Type('int'),
            'amount' => new Assert\Type('float'),
            'due_at' => new Assert\DateTime()
        ]);

        if (($handle = fopen($uploadDir . '/' . $fileName, "r")) !== false) {
            $rowNumber = 0;

            while (($data = fgetcsv($handle, 0, ",")) !== false) {
                try {
                    $row = [
                        'id' => is_numeric($data[0]) ? intval($data[0]) : $data[0],
                        'amount' => is_numeric($data[1]) || is_float($data[1]) ? floatval($data[1]) : $data[1],
                        'due_at' => \DateTime::createFromFormat('Y-m-d', $data[2])->format('Y-m-d h:i:s')
                    ];

                    $violations = $validator->validate($row, $constraint);

                    if ($violations->count() > 0) {
                        $formatedViolationList = [];
                        for ($i = 0; $i < $violations->count(); $i++) {
                            $violation = $violations->get($i);
                            $formatedViolationList[] = array($violation->getPropertyPath() => $violation->getMessage());
                        }

                        throw new Exception(json_encode($formatedViolationList));
                    }

                    if ($invoiceService->get($row['id'])) {
                        continue;
                    }

                    $invoiceService->create([
                        'id' => $row['id'],
                        'file' => $uploadedFile,
                        'amount' => $row['amount'],
                        'due_at' => \DateTime::createFromFormat('Y-m-d h:i:s', $row['due_at'])
                    ]);
                } catch (Exception $ex) {
                    $fileErrorReportService->create([
                        'file' => $uploadedFile,
                        'error_detail' => $ex->getMessage(),
                        'error_row_id' => $rowNumber + 1,
                        'error_row_string' => json_encode($data)
                    ]);
                } finally {
                    $rowNumber++;
                }
            }
            fclose($handle);
        }

        return new Response("File uploaded <a href='/files'>Check File</a>", Response::HTTP_OK,
            ['content-type' => 'text/html']);
    }
}