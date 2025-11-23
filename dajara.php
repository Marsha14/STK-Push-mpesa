<?php
// daraja.php - STK Push Integration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $consumerKey = 'qBGQt1jY3XEGjUKc9Pv0mdv2XD3Imh2JXpVZ3hMeS0UoEYwi';
    $consumerSecret = 'zfKeFkkepWtG92XhYf5IdeyxOSBRJ5Xzi8LxJQ5gZDwhkq1TKYcSAWgAvAuxpccj';
    $shortcode = '174379'; // Sandbox
    $passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    $callbackURL = 'https://marsha14.github.io/STK-Push-mpesa/index.html/callback.php'; // Change to your callback URL

    $amount = $_POST['amount'];
    $phoneNumber = $_POST['phone'];
    $phoneNumber = preg_replace('/^0/', '254', $phoneNumber); // format to 2547XXXXXXXX

    // Get OAuth token
    function getAccessToken($consumerKey, $consumerSecret) {
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
        $result = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($result);
        return $data->access_token ?? null;
    }

    // STK Push
    function stkPush($accessToken, $shortcode, $passkey, $amount, $phoneNumber, $callbackURL) {
        $timestamp = date('YmdHis');
        $password = base64_encode($shortcode . $passkey . $timestamp);
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $curl_post_data = [
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phoneNumber,
            'PartyB' => $shortcode,
            'PhoneNumber' => $phoneNumber,
            'CallBackURL' => $callbackURL,
            'AccountReference' => 'TrouserPurchase',
            'TransactionDesc' => 'Purchase of Trouser'
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Bearer $accessToken", "Content-Type: application/json"]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    $accessToken = getAccessToken($consumerKey, $consumerSecret);

    if ($accessToken) {
        $response = stkPush($accessToken, $shortcode, $passkey, $amount, $phoneNumber, $callbackURL);
        echo '<pre>';
        print_r($response);
        echo '</pre>';
        echo '<a href="index.php">Back to product</a>';
    } else {
        echo "Failed to get access token.";
    }

} else {
    echo "Invalid request method.";
}
?>



