<?php

// クロスサイトスクリプティング（XSS）対策のためエスケープシーケンス
function h($var)
{
    if (is_array($var)) {
        return array_map('h', $var);
    } else {
        return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
    }
}

// テンプレートにデータを当てはめる関数
function display($_template, $data)
{
    foreach ($data as $key => $val) {
        $$key = h($val);
    }
    unset($data);
    include dirname(__FILE__). '/../contactform_templates/'. $_template;
}

// 入力値に不正なデータがないかどうかなどをチェックする関数
function checkInput($var)
{
    if (is_array($var)) {
        return array_map('checkInput', $var);
    } else {
        if (get_magic_quotes_gpc()) {
            $var = stripslashes($var);
        }
        // NULLバイト攻撃対策
        if (preg_match('/\0/', $var)) {
            die('不正な入力です。');
        }
        // 文字エンコード確認
        if (!mb_check_encoding($var, 'UTF-8')) {
            die('不正な入力です。');
        }
        return $var;
    }
}