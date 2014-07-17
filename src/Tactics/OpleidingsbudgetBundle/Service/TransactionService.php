<?php

namespace Tactics\OpleidingsbudgetBundle\Service;

use Tactics\OpleidingsbudgetBundle\Converter\TransactionConverterInterface;
use Tactics\OpleidingsbudgetBundle\Entity\Transaction;
use Tactics\OpleidingsbudgetBundle\Repository\TransactionRepositoryInterface;

class TransactionService
{
    private $transactionRepository, $converter;


    public function __construct(TransactionRepositoryInterface $transactionRepository, TransactionConverterInterface $converter)
    {
        $this->transactionRepository = $transactionRepository;
        $this->converter = $converter;
    }

    public function createTransaction(Transaction $transaction)
    {
       $this->converter->convert($transaction);
       $this->transactionRepository->save($transaction);
    }


}