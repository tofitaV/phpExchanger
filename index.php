<!DOCTYPE html>
<html>
<head>
    <title>METANIT.COM</title>
    <meta charset="utf-8"/>
</head>
<body>
<?php

function getJsonCurrency(string $url): string
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $html = curl_exec($ch);
    curl_close($ch);

    return $html;
}

class PrivatModel
{

    public $date;
    public array $exchangeRate;

    function __construct(public $bank, public $baseCurrency, public $baseCurrencyLit, PrivatCurrencyModel ...$exchangeRate)
    {
        $this->date = date("d-m-Y");
        $this->exchangeRate = $exchangeRate;
    }

    function __destruct()
    {
        echo "</br>Вызов деструктора";
    }

    public function __toString()
    {
        return $this->bank . '</br>' . $this->baseCurrency . '</br>' . $this->baseCurrencyLit;
    }


}

class PrivatCurrencyModel
{
    function __construct(public $baseCurrency, public $currency, public $saleRateNB, public $purchaseRateNB)
    {

    }

    public function __toString()
    {
        return $this->baseCurrency . '</br>' . $this->currency . '</br>' . $this->saleRateNB . '</br>' . $this->purchaseRateNB;
    }

    function __destruct()
    {
        echo "</br>Вызов деструктора";
    }
}

$url = "https://api.privatbank.ua/p24api/exchange_rates?json&date=20.09.2022";
$json = getJsonCurrency($url);
$decoded_object = json_decode($json);

$currencies_list = $decoded_object->{'exchangeRate'};
$result = null;

foreach ($currencies_list as $currency_item) {
    if ($currency_item->currency == 'USD') {
        $result = $currency_item;
    }
}
print_r("Currency value is : " . $result->saleRateNB);

?>

</body>
</html>