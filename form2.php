<?php
session_start();

require './contactform_libs/functions.php';
require_once dirname(__FILE__) . '/securimage/securimage.php';

//POSTされたデータをチェック
$_POST = checkInput($_POST);

if (isset($_POST['ticket'], $_SESSION['ticket'])) {
    $ticket = $_POST['ticket'];
    if ($ticket!==$_SESSION['ticket']) {
        die('不正アクセスの疑いがあります。');
    }
} else {
    die('不正なアクセスの疑いがあります。');
}


$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$subject = $_POST['subject'] ?? null;
$body = $_POST['body'] ?? null;

$name = trim($name);
$email = trim($email);
$subject = trim($subject);
$body = trim($body);

// エラーメッセージを保存する配列の初期化
$error = [];

if ($name == '') {
    $error[] = 'お名前は必須項目です。';
} elseif (mb_strlen($name) > 100) {
    $error[] = 'お名前は100文字以内でお願いいたします。';
}

// $str = '123-4567';
// preg_match('/^[0-9]{3}-?[0-9]{4}$/', $str);
// // 郵便番号チェック
// preg_match('/^\d{3}-?\d{4}$/', $str);
// // 電話番号チェック
// preg_match('/^(070|080|090)-?\d{4}-?\d{4}/', $str);


// メールアドレスチェック
if ($email == '') {
    $error[] = 'メールアドレスは必須項目です。';
} else {
    $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD';

    if (!preg_match($pattern, $email)) {
        $error[] = 'メールアドレスの形式が正しくありません。';
    }
}

if ($subject == '') {
    $error[] = '件名は必須項目です。';
} elseif (mb_strlen($subject) > 100) {
    $error[] = '件名は100文字以内でお願い致します。';
}

if ($body == '') {
    $error[] = '内容は必須項目です。';
} elseif (mb_strlen($body) > 500) {
    $error[] = '内容は500文字以内でお願いします。';
}

$securimage = new Securimage();
if ($securimage->check($_POST['captcha_code']) == false) {
    $error[] = '画像認証エラーです。';
}


if (count($error) > 0) {
    $data = [];
    $data['error'] = $error;
    $data['name'] = $name;
    $data['email'] = $email;
    $data['subject'] = $subject;
    $data['body'] = $body;
    $data['ticket'] = $ticket;
    display('form1_view.php', $data);
} else {
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['subject'] = $subject;
    $_SESSION['body'] = $body;
    
    $data = [];
    $data['name'] = $name;
    $data['email'] = $email;
    $data['subject'] = $subject;
    $data['body'] = $body;
    $data['ticket'] = $ticket;
    display('form2_view.php', $data);
}