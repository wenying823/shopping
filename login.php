<?php
    include("title.php");
    if(isset($_POST['enter'])){                                 //當按下此登入按鈕
        $user_account = $_POST['account'];                      //設定變數user_account 為 使用者輸入帳號欄位
        $user_pwd = $_POST['pwd'];                              //設定變數user_pwd 為 使用者輸入密碼欄位
        $sql = "select *                                        
                  from users
                 where user_account = '".$user_account."'
                   and user_password = '".$user_pwd."'";       //在users這個資料庫裡搜尋有沒有相同的 account 跟 password
        $data = mysqli_query($link,$sql);                      //去執行 $link $sql
        $num = mysqli_num_rows($data);                         //設定num變數去找有幾比如果有符合 num 則會是1 不是 則會是0
        if ($num != 0){                                         //如果有搜尋到1比符合則是當入成功 否則 則會失敗
            echo '<b>登入成功</b>';
            $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
            $_SESSION['userno'] = $rs['user_no'];
            $_SESSION['user_name'] = $rs['user_name'];
            header("Location: http://localhost/shop_web/member_edit");
        }
        else{
            echo '<b>登入失敗</b>';
        }
    } 
    if( isset($_SESSION['userno'])){
        header("Location: http://localhost/shop_web/index");
    }
    else {
    }   
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>會員登入</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            .user_name_div{
            margin-top:14px;
        }
        .login_out_btn{
            font-size:18px;
            margin-top:8px;
            margin-left:10px;
            margin-right:5px;
        }
        nav{
            font-size:18px;
        }
        </style>
    </head>

    <body>
    
        <div class="container">
            <div style="text-align:center;">
                <h2>
                    <b>會員登入</b>
                </h2>
            </div>
            <form class="form-horizontal" method="POST">
                <div class="container">
                        <div class="form-group">
                            <label for="email">帳號:</label>
                            <input type="" class="form-control" placeholder="Enter email" name="account" >
                        </div>
                        <div class="form-group">
                            <label for="pwd">密碼:</label>
                            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" autocomplete="off">
                        </div>
                </div>

                <input type="submit" class="btn btn-success" name="enter" value="登入">
                <a href="register" class="btn btn-info" aria-label="Left Align" name="register">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    註冊
                </a>

            </form>
        </div>

    </body>
    </html>

    