<?php
    include("title.php");
    
    $item_class = "all";
    if (isset($_SESSION['shop_cart'])){
    }
    else{
        $_SESSION['shop_cart']= [];
    }

    if (isset($_GET['class'])){ 
        $item_class = $_GET['class'];
    }
    $page = 1;
    if (isset($_GET['page'])){
        $page = $_GET['page'];
    }
    if (isset($_POST['login_out'])){
        session_destroy();
        header("Location: http://localhost/shop_web/login.php"); 
    }
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
    if (isset($_POST['add_item'])){                         //當按下加入購物車按鈕
        $item_no = key($_POST['add_item']);                 //??
        if (isset($_SESSION['shop_cart'])){                 //??
            $num = count($_SESSION['shop_cart']);           //計算shop_cart裡面有幾筆
            $_SESSION['shop_cart'][$num] = $item_no;        //把item_no給session shop_cart num裡面
        }
        else {
            $_SESSION['shop_cart'][0] = $item_no;           //>
        }
    } 
    if (isset($_POST['remove_item'])){
        $item_no = key($_POST['remove_item']);
        if (isset($_SESSION['shop_cart'])){
            $del_no = array_search($item_no,$_SESSION['shop_cart']);
            unset($_SESSION['shop_cart'][$del_no]);
            $_SESSION['shop_cart'] = array_values($_SESSION['shop_cart']);
        }
    }
    if($item_class == "all"){
        $sql = "select *
                  from items";
    }
    else{
        $sql = "select *
                   from items
                 where item_class = '$item_class'";
    }
    $data = mysqli_query($link,$sql);
    $page_num = ceil(mysqli_num_rows($data)/5);
    $sql = $sql." limit ".(($page-1)*5).",5";
    $data = mysqli_query($link,$sql);
    for ($i=0; $i < mysqli_num_rows($data); $i++) {
        $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
        if (in_array($rs["item_no"], $_SESSION['shop_cart']))
            $in_shop = "T";
        else
            $in_shop = "F";
        $itemArray[$i] = array("item_no" => $rs['item_no'],
                            "item_picture" => $rs['item_picture'],
                            "item_name" => $rs['item_name'],
                            "item_detail" => $rs['item_detail'],
                            "item_price" => $rs['item_price'],
                            "in_shop" => $in_shop);
    }
    if(isset($_POST['pay'])){
        $today = date("Y-m-d H:i:s");
        $order_money=0;
        for ($i=0 ; $i<count($_SESSION['shop_cart']); $i++){
            $item_amount = $_POST['item_amount_'.$_SESSION['shop_cart'][$i]];
            $sql = "select item_price
                      from items
                     where item_no = ".$_SESSION['shop_cart'][$i];
            $data = mysqli_query($link,$sql);
            $rs = mysqli_fetch_assoc($data);
            $order_money += intval($rs['item_price']) * $item_amount;
        }
        $_SESSION['order_money'] = $order_money;
        $sql = "select user_money
                  from users
                 where user_no = ".$_SESSION['userno'];
                 $data = mysqli_query($link,$sql);

        $rs = mysqli_fetch_assoc($data);
        $user_money = $rs['user_money'];
        if($user_money >=$order_money){    
            $order_no = 0;
            $sql = "select max(order_no) as order_no
                    from orders";
            $data = mysqli_query($link,$sql);
            $rs = mysqli_fetch_assoc($data);
            if ($rs['order_no'] != null) 
                $order_no = $rs['order_no'] + 1;
            $sql = "insert into orders (order_no,
                                        order_date,
                                        order_user,
                                        order_money)
                                values ('".$order_no."',
                                        '".$today."',
                                        '".$_SESSION['userno']."',
                                        '".$order_money."')";
            mysqli_query($link,$sql);
            $order_detail_no = 0;
            $sql = "select max(order_detail_no) as order_detail_no
                      from orders_detail";
            $data = mysqli_query($link,$sql);
            $rs = mysqli_fetch_assoc($data);
            if ($rs['order_detail_no'] != null)
                $order_detail_no = $rs['order_detail_no'] + 1;
            for ($i=0 ; $i<count($_SESSION['shop_cart']);$i++){
                $item_amount = $_POST['item_amount_'.$_SESSION['shop_cart'][$i]];
                $sql = "select item_price
                          from items
                         where item_no = ".$_SESSION['shop_cart'][$i];
                $data = mysqli_query($link,$sql);
                $rs = mysqli_fetch_assoc($data);
                $sql2 = "insert into orders_detail (order_no,
                                                   order_detail_no,
                                                   order_item_no,
                                                   order_item_num,
                                                   order_item_money)
                                           values (".$order_no.",
                                                   ".$order_detail_no.",
                                                   ".$_SESSION['shop_cart'][$i].",
                                                   ".$item_amount.",
                                                   ".($rs['item_price'] * $item_amount).")";
                // echo $sql2;
                mysqli_query($link,$sql2);
                $order_detail_no++;
            }
            $total = $user_money-$order_money;
            $upd = ("UPDATE `users` 
                        SET `user_money`=$total 
                    WHERE user_no = '".$_SESSION['userno']."'");
            $data = mysqli_query($link,$upd);
            
            unset($_SESSION['shop_cart']);
            echo "<script>alert('購買成功!');location.href='http://localhost/shop_web/user_order.php'; </script>";
        }
        else{
            echo '<script type="text/javascript">alert("餘額不足");</script>';

        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>商品</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  /* Note: Try to remove the following lines to see the effect of CSS positioning */
    .affix {
      top: 20px;
      z-index: 9999 !important;}
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
        a {
            text-decoration:none !important;
        }
        a:hover{
            color:#f00;
        }
        .all_money{
            color:red;
        }
        
  }
  </style>
  <script>
        function change_amount(elmt){           //建立 change_amount 的 function
            var all_money = 0;                  //設定變數 all_money 等於0
            var amount = $(elmt).val();          //設定變數
            var item_single_money = $(elmt).parent().parent().children(".item_single_money").html();//parent 上一層的意思 children下一層裡面找()裡面東西
            var item_all_money = item_single_money * amount;
            $(elmt).parent().parent().children(".item_all_money").html(item_all_money);
            var item_all_moneys = $('#shop_cart_box').find('.item_all_money');
            for (var i = 0; i < item_all_moneys.length; i++) {
                var item_all_money = item_all_moneys[i];
                all_money += parseInt($(item_all_money).html());
            }
            $(".all_money").html("總金額："+all_money+" 元 ");
        }
    </script>
</head>
<body>
    <form method="post">
        
        <div class="container">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:20%">商品圖片</th>
                            <th style="width:30%">商品名稱</th>
                            <th style="width:20%">商品單價</th>
                            <th style="width:10%">商品數量</th>
                            <th style="width:20%">總價</th>
                        </tr>
                    </thead>
                    <tbody id="shop_cart_box">
                    <?php
                        $all_money = 0;
                        for($i=0; $i < count($_SESSION['shop_cart']); $i++) { 
                            $sql = "select *
                                        from items
                                        where item_no = '".$_SESSION['shop_cart'][$i]."'";
                            $data = mysqli_query($link,$sql);
                            $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
                            echo "<tr>";
                            echo    "<td>";
                            echo        "<img style='width:200px' src='item_photo/".$rs['item_picture']."'>";
                            echo    "</td>";
                            echo    "<td>".$rs['item_name']."</td>";
                            echo    "<td class='item_single_money'>".$rs['item_price']."</td>";
                            echo    "<td>";  
                            echo        "<select class='item_amount' name='item_amount_".$rs['item_no']."' onchange='change_amount(this)'>";
                            for ($j=1; $j <= 10; $j++) 
                                echo "<option value='".$j."'>".$j."</option>";
                            echo        "</select>";
                            echo    "</td>";
                            echo    "<td class='item_all_money'>".$rs['item_price']."</td>";
                            echo "</tr>";
                            $all_money += $rs['item_price'];
                            // $_SESSION['all_money']=$all_money;
                        }
                    ?>
                    <?php
    
                        
                        
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan='4' class="all_money" style="text-align:right">總金額： <?php echo $all_money?> 元</td>
                            
                            <td>
                                <input type="submit" value="結帳" name="pay" class="btn btn-danger">
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </from>
</body>
</html>