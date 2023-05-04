<?php
    include("title.php");
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
        <div style="text-align:center;">
            <h2>已經完成結帳，您的訂單總額為<?php echo $_SESSION['order_money']; ?>元</h2>
            <h3>已從您的P幣值扣除</h1>
            <?php
                unset($_SESSION['order_money']);
            ?>

        </div>
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
                                echo        "<select class='item_amount' onchange='change_amount(this)'>";
                                for ($j=1; $j <= 10; $j++) 
                                    echo "<option value='".$j."'>".$j."</option>";
                                echo        "</select>";
                                echo    "</td>";
                                echo    "<td class='item_all_money'>".$rs['item_price']."</td>";
                                echo "</tr>";
                                $all_money += $rs['item_price'];
                            }
                            
                            unset($_SESSION['shop_cart']);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </from>
</body>
</html>
