<?php

namespace Tactics\OpleidingsbudgetBundle\Converter;

use GuzzleHttp\Client;
use Tactics\OpleidingsbudgetBundle\Entity\Transaction;
use Money\Money;
use Money\CurrencyPair;

class XeTransactionConverter implements TransactionConverterInterface
{
    private $rates;
    private $price;

    public function convert(Transaction $transaction)
    {
        $this->rates = $this->getRates('http://openexchangerates.org/api/latest.json?app_id=0dfbf124decd45c6a65232b170d2aa0e');

        $handledPrice = $this->handleAmount($transaction);

        if ($transaction->getAmount()->getCurrency()->getName() == "EUR")
        {
            $this->price = $this->makeMoney($handledPrice, 1);
        }else if ($transaction->getAmount()->getCurrency()->getName() == "GBP")
        {
            $this->price = $this->calcGBP($handledPrice);
        }else if ($transaction->getAmount()->getCurrency()->getName() == "USD")
        {
            $this->price = $this->calcUSD($handledPrice);
        }

        $transaction->setAmount($this->price);
    }

    private function getRates($url)
    {
        $client = new Client();
        $res = $client->get($url);
        $currencies = $res->json();
        $rates = $currencies['rates'];

        return $rates;
    }

    private function calcUSD($amount)
    {
        $rate_euro = $this->rates['EUR'];

        return $this->makeMoney($amount, $rate_euro);
    }

    private function calcGBP($amount)
    {
        $rate_pond = $this->rates['GBP'];
        $rate_euro = $this->rates['EUR'];

        $to_usd = bcdiv($amount/100, $rate_pond, 2);

        return $this->makeMoney($to_usd*100, $rate_euro);

    }

    private function makeMoney($amount, $rate)
    {
        $pair = CurrencyPair::createFromIso('USD/EUR '.$rate);

        $money = Money::USD((int) $amount);

        $price_euro = $pair->convert($money);

        return $price_euro;
    }

    private function handleAmount($transaction)
    {
        if ($transaction->getType() == 'expense' || $transaction->getType() == 'endofyear')
        {
            $priceHandled = $transaction->getAmount()->getAmount() * -1 ;

            return $priceHandled;
        }
        return $transaction->getAmount()->getAmount();

    }
}