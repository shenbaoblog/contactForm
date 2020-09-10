<?php
    session_start();
    session_regenerate_id(true);

    // require '../../contactform_libs/functions.php';
    require dirname(__FILE__). './contactform_libs/functions.php';

    $data = [];

    $data['name'] = $_SESSION['name'] ?? null;
    $data['email'] = $_SESSION['email'] ?? null;
    $data['subject'] = $_SESSION['subject'] ?? null;
    $data['body'] = $_SESSION['body'] ?? null;

    // CSRF対策の固定トークンを生成
    if (!isset($_SESSION['ticket'])) {
        $_SESSION['ticket'] = sha1(uniqid(mt_rand(), true));
    }
    // トークンをテンプレートに渡す
    $data['ticket'] = $_SESSION['ticket'];

    display('form1_view.php', $data);