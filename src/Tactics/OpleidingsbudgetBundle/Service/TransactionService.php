<?php

namespace Tactics\OpleidingsbudgetBundle\Service;

use Tactics\OpleidingsbudgetBundle\Converter\TransactionConverterInterface;
use Tactics\OpleidingsbudgetBundle\Entity\Transaction;
use Tactics\OpleidingsbudgetBundle\Repository\ExpenseRequestRepositoryInterface;
use Tactics\OpleidingsbudgetBundle\Repository\TransactionRepositoryInterface;

class TransactionService
{
    private $transactionRepository, $expenseRequestRepository, $converter;

    public function __construct(TransactionRepositoryInterface $transactionRepository, ExpenseRequestRepositoryInterface $expenseRequestRepository, TransactionConverterInterface $converter)
    {
        $this->transactionRepository = $transactionRepository;
        $this->expenseRequestRepository = $expenseRequestRepository;
        $this->converter = $converter;
    }

    public function createTransaction(Transaction $transaction)
    {
       $this->converter->convert($transaction);
       $this->transactionRepository->save($transaction);

        if ($transaction->getExpenserequest()) {
            $expense = $this->expenseRequestRepository->find($transaction->getExpenserequest()->getId());
            $expense->execute();
            $this->expenseRequestRepository->save($expense);
        }
    }
}