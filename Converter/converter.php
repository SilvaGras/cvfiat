<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $fromCurrency = $_POST['from_currency'];
    $toCurrency = $_POST['to_currency'];

    // Fetch conversion rates from CoinGecko API
    $apiUrl = "https://api.coingecko.com/api/v3/simple/price?ids=$fromCurrency&vs_currencies=$toCurrency";
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    if (isset($data[$fromCurrency][$toCurrency])) {
        $rate = $data[$fromCurrency][$toCurrency];
        $convertedAmount = $amount * $rate;
        header('Location: index.html?result=' . urlencode($convertedAmount . ' ' . strtoupper($toCurrency)));
        exit();
    } else {
        header('Location: index.html?result=Conversion rate not available.');
        exit();
    }
} else {
    header('Location: index.html');
    exit();
}
?>