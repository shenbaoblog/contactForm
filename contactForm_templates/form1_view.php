<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メールフォーム</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/validationEngine.jquery.css">

</head>

<body>
    <div>
        <h1>お問い合わせフォーム</h1>
    </div>
    <div>
        <?php
                if (isset($error)):
                    foreach ($error as $val):
            ?>
        <font color="red"><?php echo $val; ?>
        </font><br>
        <?php
                    endforeach;
                endif;
            ?>


        <p>残りの必須入力項目 <span class="inputCount"></span> / <span class="requiredCount"></span></p>

        <form id="form" action="form2.php" method="post" novalidate>
            <dl>
                <dt>お名前【必須】（jquery-validation-engineインラインバリデーション）</dt>
                <dd><label>
                        <input class="validate[required]" type="text" name="name"
                            value="<?php echo $name ?>" size="50"
                            id="" autocomplete="name" required>
                    </label></dd>
                <dt>メール【必須】（jquery-validation-engineインラインバリデーション）</dt>
                <dd><label for="">
                        <input class="validate[required,custom[email]]" type="email" name="email"
                            value="<?php echo $email ?>" size="50"
                            id="" autocomplete="email" required>
                    </label></dd>
                <dt>件名【必須】</dt>
                <dd><label>
                        <input type="text" name="subject"
                            value="<?php echo $subject ?>" size="50"
                            id="" required>
                    </label></dd>
                <dt>内容【必須】</dt>
                <dd><label>
                        <textarea name="body" id="" cols="50" rows="10"
                            required><?php echo $body ?></textarea>
                    </label></dd>
            </dl>
            <p><img id="captcha" src="./securimage/securimage_show.php"></p>
            <p><input type="text" name="captcha_code" placeholder="表示されている文字を入力してください"></p>
            <p><button type="button" id="button">画像再生成</button></p>
            <p><input type="submit" value="確認画面へ"></p>
            <input type="hidden" name="ticket"
                value="<?php echo $ticket; ?>">
        </form>
    </div>
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/jquery.validationEngine.js"></script>
    <script src="./js/languages/jquery.validationEngine-ja.js"></script>
    <script>
        // --------------------------------------
        // 画像認証
        const button = document.getElementById('button');
        button.addEventListener('click', function() {
            const captcha = document.getElementById('captcha');
            captcha.src = './securimage/securimage_show.php?' + Math.random();
        }, false);

        // --------------------------------------
        // インラインバリデーション
        $("#form").validationEngine('attach', {
            promptPosition: "bottomLeft" //アラートの吹き出しを左下に設定
        });

        // --------------------------------------
        // 離脱前に確認
        let confirmationMessage = "ページを閉じようとしています。/n入力した情報が失われますがよろしいですか？";
        changeFlg = false;
        window.addEventListener("beforeunload", function(e) {
            if (changeFlg) {
                e.returnValue = confirmationMessage;
                return confirmationMessage;
            }
        });
        // デフォルトでフォームに中身が入っていたらフラグを立てる
        let value = $("form input, form textarea, form select").val();
        if (value != "") {
            changeFlg = true;
            console.log("デフォルトでフォームに値が入っています：" + changeFlg);
        }
        // フォームの内容が変更されたらフラグを立てる
        $("form input, form textarea, form select").change(function() {
            changeFlg = true
            console.log("フォームに値が入力されました：" + changeFlg);
        });
        //特定のボタンが押された場合はフラグを落とす
        $("input[type=submit]").click(function() {
            changeFlg = false;
            console.log("ボタンが押されました：" + changeFlg);
        });

        // --------------------------------------
        // 必須項目に入力が行われているかチェック＆必須項目数のチェック＆必須項目未入力の場合、submitをdisable
        // 入力のありなし判定（ngなら背景赤）：バリデーション
        let $required = $('#form').find('input[required], textarea[required], select[required]')
        $required.on('blur', function() {
            let value = $(this).val();
            if (value == "") {
                $(this).removeClass('ok');
                $(this).addClass('ng');
            } else {
                $(this).addClass('ok');
                $(this).removeClass('ng');
            }
        });
        // メールアドレスの正誤判定：バリデーション（判定が甘い）
        $('#form').find('[type="email"][required]').on('blur', function() {
            let value = $(this).val();
            if (value.match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)) {
                $(this).addClass('ok');
                $(this).removeClass('ng');
            } else {
                $(this).removeClass('ok');
                $(this).addClass('ng');
            }
        });

        // 必須項目の数をカウント
        let requiredCount = $required.length;
        $('.requiredCount').html(requiredCount);

        // 必須項目の中で、入力したものをカウント
        function calc() {
            i = 0;
            $required.each(function() {
                if ($(this).hasClass('ok')) i++;
            });
            $('.inputCount').html(requiredCount - i);
            // 残りの必須フォーム数が0だった場合に、submitの文字と、disabledを変更する
            if ($('.inputCount').text() == 0) {
                $('input[type="submit"]').val('確認する').prop('disabled', false);
            } else {
                $('input[type="submit"]').val('入力が完了していません').prop('disabled', true);
            }
        }


        // サイト読み込み時に入力チェック
        $(window).on('load', function() {
            $required.each(function() {
                let value = $(this).val();
                if (value == "") {
                    $(this).removeClass('ok');
                } else {
                    $(this).addClass('ok');
                }
            });
            calc();
        });
        // 入力フィールドから離脱したときに入力チェック
        $required.on('blur', function() {
            calc();
        });
    </script>
</body>

</html>