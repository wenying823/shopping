<?php
    include("title.php");
    if (isset($_SESSION['userno'])){
        $sql = "select *
                  from users
                 where user_no = '".$_SESSION['userno']."'";
        $data = mysqli_query($link,$sql);
        $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
        $user_account = $rs['user_account'];
        $user_name = $rs['user_name'];
        $user_id = $rs['user_id'];
        $user_gender = $rs['user_gender'];
        $user_phone = $rs['user_phone'];
        $user_email = $rs['user_email'];
        $user_address = $rs['user_address'];
        
    }
    else {
        header("Location: http://localhost/shop_web/login.php"); 
        exit;
    }
    
    if (isset($_POST['edit'])){
        $upd_name = $_POST['name'];
        $upd_gender = $_POST['gender'];
        $upd_phone = $_POST['phone'];
        $upd_email = $_POST['email'];
        $upd_address = $_POST['address'];
        $upd = ("update users
                          set 
                              user_name='$upd_name', 
                              user_gender='$upd_gender', 
                              user_phone='$upd_phone', 
                              user_email='$upd_email', 
                              user_address='$upd_address'
                              where user_no = '".$_SESSION['userno']."'");
        $data = mysqli_query($link,$upd);
        header("Location: http://localhost/shop_web/user_edit.php"); 
    }

    // echo $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>會員資料修改</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <style>
    </style>
</head>
<body>
    <form method="post">
    
        <div style="width:100%">
        <div style="background-color:#F5F5F5; width:80%; margin:0px auto; text-align:center">
            會員資料修改
        </div>
        <div style="width:60%;margin-left:20%">
        <table style="width:100%;">
                <tr>
                    <td>會員帳號:</td>
                    <td><?php echo $user_account;?></td>
                    <td>身分證字號:</td>
                    <td><?php echo $user_id;?></td>
                </tr>
                <tr>
                    <td>會員姓名:</td>
                    <td>
                        <?php
                            echo '<input type="text" name="name" class="form-control" value="'.$user_name.'">';
                        ?>
                    </td>
                    <td>性別:</td>
                    <td>
                        <?php
                            echo '<input type="text" name="gender" class="form-control" value="'.$user_gender.'">';
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>會員電話:</td>
                    <td>
                        <?php
                            echo '<input type="text" name="phone" class="form-control" value="'.$user_phone.'">';
                        ?>
                    </td>
                    <td>會員email:</td>
                    <td>
                        <?php
                            echo '<input type="text" name="email" class="form-control" value="'.$user_email.'">';
                        ?>
                    </td>
                    <tr >
                        <td>會員地址:</td>
                        <td colspan="3">
                            <?php
                                echo '<input type="text"  name="address" class="form-control" value="'.$user_address.'">';
                            ?>
                        </td>
                    </tr>
                </table>
                <div>
                    <input type="submit" class="btn btn-success" name="edit" value="修改">
                    <a href="member_edit" class="btn btn-default" name="cancel">
                        返回
                    </a>
                </div>
            </div>
        </div>
    </from>
    
</body>
</html>