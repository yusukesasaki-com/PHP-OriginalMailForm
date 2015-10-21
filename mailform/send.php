<?php

require_once('config.php');
require_once('functions.php');

session_start();

// ----------CSRF対策開始---------- //

checkToken();

// ----------CSRF対策終了---------- //


$submitContent = array();
$submitContent = $_POST;



// ----------ADMIN_MAILへの送信開始---------- //

// メールの言語・文字コードの設定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

// タイトルの設定
$sendTitle = "{$submitContent["name"]}様よりお問い合わせ";
mb_encode_mimeheader($sendTitle, "ISO-2022-JP");

// メッセージの設定
$sendMessage = "{$submitContent["name"]}様より、下記内容でお問い合わせが届いています。\n";
$sendMessage .= "\n";
$sendMessage .= "■メールアドレス\n";
$sendMessage .= "{$submitContent["mailaddress"]}\n\n";
$sendMessage .= "■お問い合わせ内容\n";
$sendMessage .= "{$submitContent["message"]}";
$sendMessage = mb_convert_encoding($sendMessage, "ISO-2022-JP","UTF-8");

// メールの送信 (宛先, 件名, 本文, 送り主(From:が必須))
@mb_send_mail(ADMIN_MAIL, $sendTitle, $sendMessage, "From:{$submitContent["mailaddress"]}");


// ----------ADMIN_MAILへの送信完了---------- //


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メールフォーム</title>
    <link rel="stylesheet" href="../css/html5reset-1.6.1.css">
    <link rel="stylesheet" href="../css/ini.css">
    <link rel="stylesheet" href="../css/mailform.css">
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
    <![endif]-->
</head>
<body>
    
<div class="container">
    
    <h1><span>送信完了</span></h1>
    
    <p class="completion">
        <?php echo nl2br(h($completionMessage)); ?>
    </p>
    
    <div class="submit_area">
        <input class="single" type="button" value="戻る" onclick="window.location='<?php echo RE_URL; ?>';">
    </div>
    
</div>
    
</body>
</html>