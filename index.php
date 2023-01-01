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

    function __construct( public $bank, public $baseCurrency, public $baseCurrencyLit, PrivatCurrencyModel ...$exchangeRate)
    {
        $this->date = date("d-m-Y");
        $this->exchangeRate=$exchangeRate;
    }

    function __destruct()
    {
        echo "</br>Вызов деструктора";
    }


    function displayInfo()
    {
        echo "</br>name : $this->bank; $this->date";
    }

    public function __toString() {
        return $this->bank .'</br>'. $this->baseCurrency .'</br>'. $this->baseCurrencyLit;
    }


}

class PrivatCurrencyModel
{
    function __construct(public $baseCurrency, public $currency, public $saleRateNB, public $purchaseRateNB)
    {

    }

    public function __toString() {
        return $this->baseCurrency .'</br>'. $this->currency .'</br>'. $this->saleRateNB .'</br>'.  $this->purchaseRateNB;
    }

    function __destruct()
    {
        echo "</br>Вызов деструктора";
    }
}


$privatCurrencyModel = new PrivatCurrencyModel("UAH", "AUD", 24.4169000, 24.4169000);
$model = new PrivatModel( "PB", 980, "UAH");
$model->displayInfo();

$url = "https://api.privatbank.ua/p24api/exchange_rates?json&date=20.09.2022";
$json = getJsonCurrency($url);
$object = json_decode($json);

$date =  $object->{'exchangeRate'};
print_r($date);
$var = $date[0]->saleRateNB;
echo $var;

?>

</body>
</html>