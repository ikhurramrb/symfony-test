<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\UploadedFiles;

/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false, unique=true)
     */
    private $invoice_id;

    /**
     * @var UploadedFiles $file
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\UploadedFiles", inversedBy="invoices", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", nullable=false)
    */
    private $file;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $due_at;

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

    public function getInvoiceId(): ?int
    {
        return $this->invoice_id;
    }

    public function setInvoiceId(int $invoice_id): self
    {
        $this->invoice_id = $invoice_id;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDueAt(): ?\DateTime
    {
        return $this->due_at;
    }

    public function setDueAt(\DateTime $due_at): self
    {
        $this->due_at = $due_at;

        return $this;
    }
}
