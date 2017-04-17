<?php
/**
 * Created by PhpStorm.
 * User: muhammedzaimtr
 * Date: 17.04.2017
 * Time: 23:05
 */
session_start();

try {
    $baglan = new PDO("mysql:host=localhost;dbname=link_delisi", "root", "");
    $baglan->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
} catch ( PDOException $e ){
    print $e->getMessage();
}


if (@$_POST["giris"]){
    $kadi = strip_tags(htmlspecialchars(trim(@$_POST["kadi"])));
    $sifre = strip_tags(htmlspecialchars(trim(@$_POST["sifre"])));

    $user = $baglan->prepare("select * from user where name=? and pass=?");
    $user->execute([$kadi,$sifre]);
    if ($user->rowCount() > 0){
        $_SESSION["Giris"] = true;
        header("location: index.php");
    }
}

if (@$_POST["paylas"]){
    $link = strip_tags(htmlspecialchars(trim(@$_POST["link"])));
    $title = strip_tags(htmlspecialchars(trim(@$_POST["title"])));
    $data = $baglan->prepare("insert into link(link,title) value (?,?)");
    $data->execute([$link,$title]);
    if ($data->rowCount() > 0){
        header("location: index.php");
    }else{
        echo "400";
    }
}

?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Link Delisi</title>
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/zeroCss.css">
    <link rel="stylesheet" href="css/zeroGrid.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

<div class="header">
    <div class="cotainer">
        <div class="row">
            <div class="col-4">
                <p class="header-title">
                    Link Delisi
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <?php

    $data = $baglan->query("select * from link Order by id Desc", PDO::FETCH_ASSOC);
    if ($data->rowCount() > 0){
        $data2 = $data->fetchAll();
        foreach ($data2 as $row){
            ?>

            <div class="row">
                <div class="bos"></div>
                <div class="col-12 box">
                    <a href="<?php echo $row['link'] ?>">
                        <p class="container-data">
                            <?php echo $row['title'] ?>
                        </p>
                    </a>
                </div>
            </div>

            <?php
        }
    }else{
        ?>

        <div class="row">
            <div class="bos"></div>
            <div class="col-12 box">
                <a href="index.php">
                    <p class="container-data">
                        Maalesef hiçbir veri bulunmuyor...
                    </p>
                </a>
            </div>
        </div>

        <?php
    }
    ?>

</div>

<div id="paylas" class="pop">
    <img class="letspop" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDUxMiA1MTIiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48bGluZWFyR3JhZGllbnQgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIGlkPSJTVkdJRF8xXyIgeDE9IjI1NiIgeDI9IjI1NiIgeTE9IjUxMiIgeTI9Ii05LjA5NDk0N2UtMDEzIj48c3RvcCBvZmZzZXQ9IjAiIHN0eWxlPSJzdG9wLWNvbG9yOiM3NkI4NTIiLz48c3RvcCBvZmZzZXQ9IjEiIHN0eWxlPSJzdG9wLWNvbG9yOiM4REMyNkYiLz48L2xpbmVhckdyYWRpZW50PjxjaXJjbGUgY3g9IjI1NiIgY3k9IjI1NiIgZmlsbD0idXJsKCNTVkdJRF8xXykiIHI9IjI1NiIvPjxwYXRoIGQ9Ik0zODEuNywyNDQuMkgyNjcuOFYxMzAuM2MwLTYuNS01LjMtMTEuOC0xMS44LTExLjhjLTYuNSwwLTExLjgsNS4zLTExLjgsMTEuOHYxMTMuOUgxMzAuMyAgYy02LjUsMC0xMS44LDUuMy0xMS44LDExLjhzNS4zLDExLjgsMTEuOCwxMS44aDExMy45djExMy45YzAsNi41LDUuMywxMS44LDExLjgsMTEuOGM2LjUsMCwxMS44LTUuMywxMS44LTExLjhWMjY3LjhoMTEzLjkgIGM2LjUsMCwxMS44LTUuMywxMS44LTExLjhTMzg4LjIsMjQ0LjIsMzgxLjcsMjQ0LjJ6IiBmaWxsPSIjRkZGRkZGIi8+PC9zdmc+" alt="">
</div>

<!-- Overlay -->
<div class="overlay"></div>
<!-- Popup -->
<div class="popup">
    <?php

    if (@$_SESSION["Giris"]){
        ?>

        <div class="full">
            <div class="row">
                <h1>Link Paylaş</h1>
            </div>
            <div class="row">
                    <form action="" method="POST">
                        <div class="row">
                            <label>Başlık</label><br>
                            <input name="title" type="text">
                        </div>
                        <div class="row">
                            <label>Link</label><br>
                            <input name="link" type="text">
                        </div>
                        <div class="row">
                            <input type="submit" name="paylas" value="Paylaş">
                        </div>
                    </form>
            </div>
        </div>
        <div class="close">X</div>

        <?php
    }else{
        ?>

        <div class="full">
            <div class="row">
                <h1>Giriş</h1>
            </div>
            <div class="row">
                    <form action="" method="POST">
                        <div class="row">
                            <label>Kullanıcı Adı</label><br>
                            <input name="kadi" type="text">
                        </div>
                        <div class="row">
                            <label>Şifre</label><br>
                            <input name="sifre" type="password">
                        </div>
                        <div class="row">
                            <input type="submit" name="giris" value="Giriş">
                        </div>
                    </form>
            </div>
        </div>
        <div class="close">X</div>

    <?php
    }
    ?>

</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
    $('.pop').on('click', function() {
        $(".overlay").fadeIn(200, function() {});
        $(".popup").fadeIn(600, function() {});
    });

    $('.overlay, .close').on('click', function() {
        $(".overlay").fadeOut(600, function() {});
        $(".popup").fadeOut(200, function() {});
    });
</script>

</body>
</html>
