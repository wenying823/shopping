<?php
    include("title.php");
    $order_no =  $_GET['order_no'];
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <form method="post">
        <div class="container" style="width:60%;">
        <div style="text-align:center;">
            <h2><b>會員詳細訂單</b></h2>
        </div>
        <table class="table table-bordered" style="text-align:center;">
            <thead>
            <tr>
                <th style="text-align:center; width:20%;">商品圖片</th>
                <th style="text-align:center; width:40%;">商品名稱</th>
                <th style="text-align:center; width:20%;">商品單價</th>
                <th style="text-align:center; width:20%;">商品數量</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "select *
                              from orders_detail
                         left join items
                                on orders_detail.order_item_no = items.item_no
                             where order_no = $order_no";
                    $data = mysqli_query($link,$sql);
                    echo $sql;
                    for($i=1; $i <= mysqli_num_rows($data); $i++) { 
                        $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
                        echo "<tr>";
                        echo    "<td>";
                        echo        "<img style='width:100px' src = 'item_photo/".$rs['item_picture']."'>";
                        echo    "</td>";
                        echo    "<td>".$rs['item_name']."</td>";
                        echo    "<td>".$rs['item_price']."</td>";
                        echo    "<td>".$rs['order_item_num']."</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        <div style="text-align:center;">
            <button type="button" class="btn btn-default"  onclick="history.back()">返回</button>
        </div>
        </div>
    </form>
</body>
</html>