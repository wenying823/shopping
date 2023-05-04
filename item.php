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
    if (isset($_POST['add_item'])){                         //當按下加入購物車按鈕
        if(isset($_SESSION['userno'])){
            $item_no = key($_POST['add_item']);                 //把我按下那個的編號設定成$item_no
            $had = $_SESSION['shop_cart'];                      //把session陣列設定成$had
            if(in_array($item_no,$had)){                        //當had陣列裡面有這個編號時
                // echo "購物車已有此商品";                         //就不能再加入購物車
            }
            else{
                $num = count($_SESSION['shop_cart']);           //計算shop_cart裡面有幾筆
                $_SESSION['shop_cart'][$num] = $item_no;        //把item_no給session shop_cart num裡面
            }
        }
        else{
            header("Location: http://localhost/shop_web/login.php"); 
            exit;
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
    $page_num = ceil(mysqli_num_rows($data)/10);
    $sql = $sql." limit ".(($page-1)*10).",10";
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
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>商品</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
        /* Note: Try to remove the following lines to see the effect of CSS positioning */
        
        a {
            text-decoration:none !important;
        }
        a:hover{
            color:#f00;
        }
            
        </style>
</head>
<body>
    <form method="post">
        
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">購物車</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered" >
                            <thead>
                                <tr>
                                    <th>商品圖片</th>
                                    <th>商品名稱</th>
                                     <th>商品價格</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    for($i = 0 ; $i < count($_SESSION['shop_cart']); $i++){
                                        $sql = "SELECT *
                                                  FROM items
                                                 WHERE item_no = '".$_SESSION['shop_cart'][$i]."'";
                                        $data = mysqli_query($link,$sql);
                                        $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
                                        echo "<tr>";
                                        echo    "<td>";
                                        echo        "<img style='width:100px' src = 'item_photo/".$rs['item_picture']."'>";
                                        echo    "</td>";
                                        echo    "<td>".$rs["item_name"]."</td>";
                                        echo    "<td class='item_single_money'>".$rs['item_price']."</td>";
                                        echo "</tr>";

                                    }
                                    
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer"> 
                        <input type="button" value="前往結帳" class="btn btn-warning" onclick="location.href='http://localhost/shop_web/shop_checkOut.php'">
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <nav class="col-sm-3">
                <ul class="nav nav-pills nav-stacked" data-spy="affix" data-offset-top="205">
                <i style="font-size:22px;" class="fa">&#xf0d6;
                    <?php
                        if(isset($_SESSION['userno'])){
                            echo $user_money;
                        }
                        else{
                            echo "0";
                        }
                    ?>
                     &nbsp;P幣</i>

                    <table class="table table-bordered">
                    
                    <thead>
                        <tr><th><a href="item.php?class=all">全部</a></th></tr>
                    
                            <?php
                                $sql = "select *
                                        from items_class";
                                $data = mysqli_query($link,$sql);
                                for ($i=0; $i < mysqli_num_rows($data); $i++){
                                    $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
                                    echo "<tr>";
                                    echo   "<th><a href='item.php?class=".$rs['class_no']."'>".$rs['class_name']."</a></th>";
                                    echo "</tr>";
                                }
                            ?>

                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">購物車</button>
                    <br><br>
                    <input type="button" value="結帳專區" class="btn btn-warning btn-lg" onclick="location.href='http://localhost/shop_web/shop_checkOut.php'">
                    <br><br>
                    <button class="btn btn-lg">
                        <a href="#title"<i style="font-size:16px" class="fa">&#xf0a6;回到頂端</i></a>
                    </button>   
                </ul>
                </nav>
                <div class="col-sm-9">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:20%;">商品圖片</th>
                                <th style="width:30%;">商品名稱</th>
                                <th style="width:40%;">商品說明</th>
                                <th style="width:10%;">商品價格</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for($i=0; $i < count($itemArray); $i++){
                            ?>
                            <tr>
                                <td>
                                    <img src="item_photo\<?php echo $itemArray[$i]['item_picture'] ?>" width="100%" style="display:block; margin:auto;">
                                </td>
                                <td>
                                    <a href="">
                                        <?php echo $itemArray[$i]['item_name'] ?>
                                    </a>
                                </td>
                                <td>
                                    <?php echo $itemArray[$i]['item_detail'] ?>
                                </td>
                                <td>
                                    NT$<?php echo $itemArray[$i]['item_price'] ?>
                                    <form>

                                        <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                                        <br>
                                    </form>
                                        <?php
                                            if($itemArray[$i]['in_shop'] == "F")
                                                echo "<button type='submit' class='btn btn-sm btn-info' name='add_item[".$itemArray[$i]['item_no']."]'>加入購物車</button>";
                                            else 
                                                echo "<button class='btn btn-sm btn-danger' name='remove_item[".$itemArray[$i]['item_no']."]'>移出購物車</button>";
                                        ?>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div style="text-align:center">
            <ul class="pagination">
            <?php 
                for ($i=1; $i <= $page_num; $i++) { 
                    if ($page == $i)
                        echo "<li class='active'><a href='item.php?class=".$item_class."&page=".$i."'>".$i."</a></li>";
                    else
                        echo "<li><a href='item.php?class=".$item_class."&page=".$i."'>".$i."</a></li>";
                }
            ?>
            </ul>
        </div>
    </form>
</body>
</html>