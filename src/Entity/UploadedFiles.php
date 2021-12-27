<?php

namespace App\Entity;

use App\Repository\UploadedFilesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UploadedFilesRepository::class)
 */
class UploadedFiles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invoice", mappedBy="file", fetch="EXTRA_LAZY")
     */
    protected $invoices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FileErrorReporting", mappedBy="file", fetch="EXTRA_LAZY")
     */
    protected $errorRows;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->errorRows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getInvoices()
    {
        return $this->invoices;
    }

    /**
     * @return ArrayCollection
     */
    public function getErrorRows()
    {
        return $this->errorRows;
    }

}
