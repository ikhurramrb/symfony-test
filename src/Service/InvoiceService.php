<?php

namespace App\Service;

use App\Entity\Invoice;
use App\Entity\UploadedFiles;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class InvoiceService
{
    protected $em;
    protected $invoiceRepository;

    public function __construct(EntityManagerInterface $em, InvoiceRepository $invoiceRepository)
    {
        $this->em = $em;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function create($data)
    {
        $invoice = new Invoice();
        $invoice->setInvoiceId($data['id']);
        $invoice->setFile($data['file']);
        $invoice->setAmount($data['amount']);
        $invoice->setDueAt($data['due_at']);

        $this->em->persist($invoice);
        $this->em->flush();
    }

    /**
     * @param $id
     * @return Invoice|null
     */
    public function get($id): ?Invoice
    {
        return $this->invoiceRepository->find($id);
    }
}