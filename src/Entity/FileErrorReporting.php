<?php

namespace App\Entity;

use App\Repository\FileErrorReportingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=FileErrorReportingRepository::class)
 */
class FileErrorReporting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var UploadedFile $file
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\UploadedFiles", inversedBy="errorRows", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", nullable=false)
     */
    private $file;

    /**
     * @ORM\Column(type="integer")
     */
    private $error_row_id;

    /**
     * @ORM\Column(type="text")
     */
    private $error_row_string;

    /**
     * @ORM\Column(type="text")
     */
    private $error_detail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFiles $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getErrorRowId(): ?int
    {
        return $this->error_row_id;
    }

    public function setErrorRowId(int $error_row_id): self
    {
        $this->error_row_id = $error_row_id;

        return $this;
    }

    public function getErrorRowString(): ?string
    {
        return $this->error_row_string;
    }

    public function setErrorRowString(string $error_row_string): self
    {
        $this->error_row_string = $error_row_string;

        return $this;
    }

    public function getErrorDetail(): ?string
    {
        return $this->error_detail;
    }

    public function setErrorDetail(string $error_detail): self
    {
        $this->error_detail = $error_detail;

        return $this;
    }
}
