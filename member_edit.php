<?php
    include("title.php");
    if (isset($_SESSION['userno'])){
        $sql = "select *
                  from users
                 where user_no = '".$_SESSION['userno']."'";
        $data = mysqli_query($link,$sql);
        $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
        $user_name = $rs['user_name'];
    }
    else {
        header("Location: http://localhost/shop_web/login.php"); 
        exit;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>會員專區</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
        .new_item{
            width: 300px; 
            height: 300px; 
            background-color: gray;
            border-radius: 50px;
            display:inline-block;
        }
        .title{
            margin:0px auto; 
            width: 250px;
            background-color: white;
            text-align: center;
            border-radius: 50px;
            font-size: 30px;
        }
        .item{
            width:250px;
            background-color: white;
            text-align: center;
            border-radius:50px;
            height: 200px;
            margin: 0px auto;
            margin-top : 20px;
        }
        .item_detail{
            border-bottom-style: dashed; 
            width:205px; 
            margin:0px auto;
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .all{
            margin: 0px auto;
            width:1000px;
        }
    </style>
</head>
<body>
    <form method="post">
        <div class="container">
            <div class="all">
                <div class="new_item">
                    <div class="title">
                        會員服務
                    </div>
                    <div class="item">
                        <div class="item_detail">
                            <a href="user_edit" class="btn btn-info" aria-label="Left Align" name="">
                                會員修改資料
                            </a>
                        </div>
                    </div>
                </div>
                <div class="new_item">
                    <div class="title">
                        商品/訂單
                    </div>
                    <div class="item">
                        <div class="item_detail">
                            <a href="item_update" class="btn btn-warning" aria-label="Left Align" name="">
                                商品上傳
                            </a>
                            <a href="user_order" class="btn btn-info" aria-label="Left Align" name="">
                                訂單查詢
                            </a>
                        </div>
                    </div>
                </div>
                <div class="new_item">
                    <div class="title">
                        儲值專區
                    </div>
                    <div class="item">
                        <div class="item_detail">
                            <a href="user_addmoney" class="btn btn-primary" aria-label="Left Align" name="">
                                儲值服務
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</body>
</html>