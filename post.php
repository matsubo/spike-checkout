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
require 'vendor/autoload.php';

use FastPay\FastPay;

try {
    if (!isset($_POST["fastpayToken"])) {
        print 'invalid request';
        exit;
    }


    $token = $_POST["fastpayToken"];


    $fastpay = new FastPay(trim(file_get_contents('./secret.key')));


    // 課金を作成
    $charge = $fastpay->charge->create(array(
      "amount" => 666,
      "card" => $token,
      "description" => "fastpay@example.com",
      "capture" => "false",
    ));
    var_dump($charge);


    // 課金を確定
    $charge = $charge->capture();
    var_dump($charge);

    // 課金を取り消し
    $response3 = $charge->refund();
    var_dump($response3);


} catch (Exception $e) {
    // エラー
    var_dump($e);
}

?>

</pre>
    </body>
    </html>
