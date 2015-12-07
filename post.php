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

try {
    if (!isset($_POST["card_token"])) {
        print 'invalid request';
        exit;
    }

    $card_token = $_POST["card_token"];

    $spike = new \Issei\Spike\Spike(trim(file_get_contents('./secret.key')));

    $token = new \Issei\Spike\Model\Token($card_token);

    // 課金を作成
    $request = new \Issei\Spike\ChargeRequest();
    $request
      ->setToken($token)
      ->setAmount(666, 'JPY')
      ->setCapture(false) // If you set false, you can delay capturing.
      ;

    $product = new \Issei\Spike\Model\Product('my-product-00001');
    $product
      ->setTitle('Product Name')
      ->setDescription('Description of Product.')
      ->setPrice(333, 'JPY')
      ->setLanguage('JA')
      ->setCount(2)
      ->setStock(97)
      ;

    $request->addProduct($product);

    $charge = $spike->charge($request);

    var_dump($charge);


    // 課金を確定
    $charge = $spike->capture($charge);
    var_dump($charge);

    // 課金を取り消し
    $response = $spike->refund($charge);
    var_dump($response);


} catch (Exception $e) {
    // エラー
    var_dump($e);
}

?>

</pre>
    </body>
    </html>
