<?php

namespace Tactics\OpleidingsbudgetBundle\Converter;

use GuzzleHttp\Client;
use Tactics\OpleidingsbudgetBundle\Entity\Transaction;
use Money\Money;
use Money\CurrencyPair;

class XeTransactionConverter implements TransactionConverterInterface
{
    private $rates;

    public function convert(Transaction $transaction)
    {
        // http://www.xe.com/datafeed/faq.php
        // 1. retrieve xe xml
        // 2. retrieve correct conversion rate from the xml
        // 3. create currency pair with that conversion rate
        // 4. convert the transaction

        $this->rates = $this->getRates('http://openexchangerates.org/api/latest.json?app_id=0dfbf124decd45c6a65232b170d2aa0e');

        if ($transaction->getAmount()->getCurrency()->getName() == "EUR")
        {
            //just save that fucker
        }else if ($transaction->getAmount()->getCurrency()->getName() == "GBP")
        {
            $price = $this->calcGBP($transaction->getAmount()->getAmount());
            $transaction->setAmount($price);
        }else if ($transaction->getAmount()->getCurrency()->getName() == "USD")
        {
            $price = $this->calcUSD($transaction->getAmount()->getAmount());
            $transaction->setAmount($price);
        }
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

        //$usd_amount = bcmul($amount, $rate_euro, 6);

        return $this->makeMoney($amount, $rate_euro);
    }

    private function calcGBP($amount)
    {
        $rate_pond = $this->rates['GBP'];
        $rate_euro = $this->rates['EUR'];

        $to_usd = bcdiv($amount/100, $rate_pond, 2);

        //$gbp_amount = bcmul($to_usd, $rate_euro, 6);

        return $this->makeMoney($to_usd*100, $rate_euro);

    }

    private function makeMoney($amount, $rate)
    {
        $pair = CurrencyPair::createFromIso('USD/EUR '.$rate);

        $money = Money::USD((int) $amount);

        $price_euro = $pair->convert($money);

        return $price_euro;
    }


}