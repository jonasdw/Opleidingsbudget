<?php

namespace Tactics\OpleidingsbudgetBundle\Helper;

class Summary
{
    private $data;

    public function __construct($users, $transactions, $requests)
    {
        foreach ($users as $user)
        {
            $userTransactions = array_filter($transactions, function($t) use ($user) {return $t->getUser() === $user; });
            $userRequests = array_filter($requests, function($r) use ($user) {return $r->getUser() === $user; });
            $balans = new Balans($userTransactions);

            $this->data[] = [
                'user' => [
                    'id' => $user->getId(),
                    'name' => $user->getFirstname(),
                ],
                'transactions' => [
                    'count' => count($userTransactions),
                    'balans' => $balans->getUserBalans(),
                ],
                'requests' => [
                    'count' => count($userRequests),
                ]
            ];
        }
    }

    public function getData()
    {
        return $this->data;
    }
}