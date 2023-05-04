<?php
    session_start();
    $link = mysqli_connect("localhost", "root", "", "shop_web");//登入資料庫
    mysqli_set_charset($link,"utf8");
    if (isset($_SESSION['userno'])){
        $sql = "select *
                  from users
                 where user_no = '".$_SESSION['userno']."'";
        $data = mysqli_query($link,$sql);
        $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
        $user_name = $rs['user_name'];
        $user_money = $rs['user_money'];
    }
    // $user_no = $_SESSION['userno'];
    if (isset($_POST['login_out'])){
        session_destroy();
        header("Location: http://localhost/shop_web/index.php"); 
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
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
        <form method="post">
            
        <a href="" name="title"></a>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="">php購物網</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">首頁</a></li>
                        <li><a href="item.php">商品</a></li>
                        <li><a href="member_edit.php">會員專區</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php 
                            if (isset($_SESSION['userno'])){
                                echo "<li>";
                                echo "<p class='user_name_div'>您好 ".$_SESSION['user_name']."</p>";
                                echo "</li>";
                                echo "<li>";
                                echo "<input type='submit' name='login_out' class='btn btn-sm btn-link login_out_btn' value='登出'>";
                                echo "</li>";
                            }
                            else{
                                echo "<li>";
                                echo "<a href='register.php'><span class='glyphicon glyphicon-user'></span>註冊</a>";
                                echo "</li>";
                                echo "<li>";
                                echo "<a href='login.php'><span class='glyphicon glyphicon-log-in'></span>登入</a>";
                                echo "</li>";
                            }
                        ?>
                    </ul>
                </div>
            </nav>
             

        </form>
        

    </body>
</html>

