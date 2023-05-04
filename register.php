<?php
    session_start();
    
    if( isset($_SESSION['userno'])){
        // echo $_SESSION['userno'];
    }
    else {
        // echo "no session";
    }
    if(isset ($_POST['enter'])){                      
        if(isset($_POST['account']) && $_POST['pwd'] && $_POST['name'] && $_POST['id']
                                    && $_POST['gender'] && $_POST['phone'] && $_POST['email'] 
                                    && $_POST['address']){        //偵測此三欄是否有東西
            $link = mysqli_connect("localhost", "root", "", "shop_web");        //連接資料庫
            mysqli_set_charset($link,"utf8");
            $user_account = $_POST['account'];                                  //令$user_account 是 欄位裡面的字串
            $sql = "select *
                    from users
                    where user_account = '".$user_account."'";                  //搜尋有沒有相同的account
            $data = mysqli_query($link,$sql);                                   //執行
            $num = mysqli_num_rows($data);                                      //查詢有幾筆
            if($num != 0){                                                      //如果有重複則查到一筆則echo帳號重複
                echo '<b>帳號重複</b>';
            }
            else{                                                           
                $sql = "SELECT MAX(user_no) as No                               
                        FROM users";                                            //去找資料庫裏面user_no最大的那一筆的數字
                $data = mysqli_query($link,$sql);                               //執行
                $number = 1;                                                    //????
                while($result = $data->fetch_object())    
                    $number = ($result->No) + 1;                                //加一變成新的資料的user_no
                    $ac = $_POST['account'];                                        
                    $pwd = $_POST['pwd']; 
                    $name = $_POST['name'];
                    $id = $_POST['id'];
                    $gender = $_POST['gender'];
                    $phone = $_POST['phone'];
                    $email = $_POST['email'];
                    $address = $_POST['address'];
                
                    $sql = "INSERT INTO `users` (`user_no`, 
                                                `user_account`, 
                                                `user_password`,
                                                `user_name`,
                                                `user_id`,
                                                `user_gender`,
                                                `user_phone`,
                                                `user_email`,
                                                `user_address`) 
                                        VALUES (".$number.",
                                                '".$ac."',
                                                '".$pwd."',
                                                '".$name."',
                                                '".$id."',
                                                '".$gender."',
                                                '".$phone."',
                                                '".$email."',
                                                '".$address."')";
                    mysqli_query($link,$sql);                                   //??????
                    
                    echo '<b>註冊成功</b>';
            }
        }
        else{
            echo '<b>註冊失敗</b>';                                             
        }
    };
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>會員註冊</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container">
        <div style="text-align:center;"><h2><b>會員註冊</b></h2></div>
        <form class="form-horizontal" method="POST" action="register.php">
            <div class="container">
                <div class="form-group">
                    <label for="">帳號:</label>
                    <input type="" class="form-control" placeholder="請輸入帳號" name="account" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="pwd">密碼:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="請輸入密碼" name="pwd" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="pwd">姓名:</label>
                    <input type="" class="form-control" id="name" placeholder="請輸入姓名" name="name" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="pwd">身分證:</label>
                    <input type="" class="form-control" id="id" placeholder="請輸入身分證" name="id" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="pwd">性別:</label>
                    <input type="" class="form-control" id="gener" placeholder="請輸入性別" name="gender" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="pwd">電話:</label>
                    <input type="" class="form-control" id="phone" placeholder="請輸入電話" name="phone" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="pwd">電子郵件:</label>
                    <input type="" class="form-control" id="email" placeholder="請輸入電子郵件" name="email" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="pwd">住址:</label>
                    <input type="" class="form-control" id="address" placeholder="請輸入住址" name="address" autocomplete="off">
                </div>
            </div>
            
            <input type="submit" class="btn btn-success" name="enter" value="註冊">
            <a href="login" class="btn btn-info" aria-label="Left Align" name="login">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                會員登入
            </a>
        </form>

    </div>
</body>
</html>
