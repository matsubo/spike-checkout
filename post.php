<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Sample Page</title>
        <meta name="author" content="Yuki Matsukura">
        <link rel="stylesheet" href="css/styles.css?v=1.0">
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>


<pre>

<?php
require_once(__DIR__ . "/src/FastPay.php");

try {
    if (!isset($_POST["fastpayToken"])) {
        print 'invalid request';
        exit;
    }

    $token = $_POST["fastpayToken"];
    FastPay::setSecret(trim(file_get_contents('./secret.key')));
    $response = FastPay_Charge::create(array(
        "amount" => 1000000,
        "card" => $token,
        "description" => "bob@customer.com",
    ));
    // 決済成功
    var_dump($response);
} catch (Exception $e) {
    // エラー
    var_dump($e);
}

?>

</pre>
    </body>
    </html>
