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
        <h1>入力内容の確認</h1>
    </div>
    <div>
        <dl>
            <dt>お名前【必須】（jquery-validation-engineインラインバリデーション）</dt>
            <dd><?php echo $name; ?>
            </dd>
            <dt>メール【必須】（jquery-validation-engineインラインバリデーション）</dt>
            <dd><?php echo $email; ?>
            </dd>
            <dt>件名</dt>
            <dd><?php echo $subject; ?>
            </dd>
            <dt>内容</dt>
            <dd><?php echo nl2br($body); ?>
            </dd>
        </dl>

        <form action="form1.php" method="post">
            <p>
                <input type="submit" value="入力画面に戻る">
            </p>
            <input type="hidden" name="ticket"
                value="<?php echo $ticket; ?>">
        </form>
        <form action="form3.php" method="post">
            <input type="hidden" name="ticket"
                value="<?php echo $ticket; ?>">
            <p>
                <input type="submit" value="送信する">
            </p>
        </form>
    </div>
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/jquery.validationEngine.js"></script>
    <script src="./js/languages/jquery.validationEngine-ja.js"></script>
    <script>
        // 画像認証
        // const button = document.getElementById('button');
        // button.addEventListener('click', function() {
        //     const captcha = document.getElementById('captcha');
        //     captcha.src = './securimage/securimage_show.php?' + Math.random();
        // }, false);
        // インラインバリデーション
        // $(document).ready(function() {
        //     $("#form").validationEngine('attach', {
        //         promptPosition: "bottomLeft" //アラートの吹き出しを左下に設定
        //     });
        // });
        // 離脱前に確認
        // window.addEventListener("beforeunload", function(e) {
        //     let confirmationMessage = "入力内容を破棄しますがよろしいですか？";
        //     e.returnValue = confirmationMessage;
        //     return confirmationMessage;
        // });
    </script>
</body>

</html>