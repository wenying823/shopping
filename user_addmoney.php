<?php
    include("title.php");
    if (isset($_SESSION['userno'])){
        $sql = "select *
                  from users
                 where user_no = '".$_SESSION['userno']."'";
        $data = mysqli_query($link,$sql);
        $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
        $user_money = $rs['user_money'];
    }
    else {
        header("Location: http://localhost/shop_web/login.php"); 
        exit;
    }
    if(isset($_POST['edit'])){
        // echo $_POST['addmoney'];
        echo "您儲值後的點數為";
        $total = $user_money+$_POST['addmoney'];
        echo $total; 
        $upd = ("UPDATE `users` 
                    SET `user_money`=$total 
                  WHERE user_no = '".$_SESSION['userno']."'");
        $data = mysqli_query($link,$upd);
        header("Location: http://localhost/shop_web/item.php"); 
    }
    else{
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>儲值專區</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <style>
        
    </style>
</head>
<body>
    <form method="post">
        <div style="width:100%">
            <div style="background-color:#F5F5F5; width:80%; font-size:30px; height:50px; margin:0px auto; text-align:center">
                儲值專區
            </div>
            <div style="width:60%;margin-left:20%">
                <p style="font-size:30px;">您的點數為&nbsp; <b><?php echo $user_money;?></b>&nbspP幣</P>
                <p>
                    您要儲值&nbsp;
                    <?php
                        echo '<input type="number" name="addmoney" class="form-control" maxlength="11" required>';
                    ?>
                    &nbspP幣(1P幣=NT$1)
                </P>
                    <div>
                        <input type="submit" class="btn btn-success" name="edit" value="儲值">
                        <a href="member_edit" class="btn btn-default" name="cancel">
                            返回
                        </a>
                    </div>
                </div>
            </div>
    </from>

</body>
</html>