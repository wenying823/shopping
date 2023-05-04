<?php
    include("title.php");
    if(isset($_POST['detail'])){
        // header("Location: http://localhost/shop_web/user_order_detail.php");
    }
    $order_no = 0;
    if (isset($_GET['order_no'])){ 
        $order_no = $_GET['order_no'];
    }
    $today = date("Y-m-d");
    $year = date('Y');
    $month = date('m');
    $day = date('d');
    $sevenday = date("Y-m-d", mktime(0,0,0,$month,$day-7,$year));
    $onemonth = date("Y-m-d", mktime(0,0,0,$month-1,$day,$year));
    $halfyear = date("Y-m-d", mktime(0,0,0,$month-6,$day,$year));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>訂單查詢</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-*.min.js"></script>
  <style>
    a{
        color:white;
    }
    a:hover {
        text-decoration: none;
        color:white;
    }
  </style>
</head>
<body>
    <form method="post">
        <div class="container" style="width:60%;">
        <div style="text-align:center;">
            <h2><b>會員訂單</b></h2>
        </div>
        <?php
            if(isset($_GET['date'])){
                $date = $_GET['date'];
                if($date == 'sevenday'){
                    echo'<select name="date" class="selectpicker" onChange="location = this.value;">
                    <option value="">請選擇</option>
                    <option value="user_order.php?date=all">全部</option>
                    <option selected="selected"  value="user_order.php?date=sevenday">一個禮拜內</option>
                    <option value="user_order.php?date=onemonth">一個月內</option>
                    <option value="user_order.php?date=halfyear">半年內</option> 
                </select>';
                }
                if($date == 'onemonth'){
                    echo'<select name="date" class="selectpicker" onChange="location = this.value;">
                    <option value="">請選擇</option>
                    <option value="user_order.php?date=all">全部</option>
                    <option value="user_order.php?date=sevenday">一個禮拜內</option>
                    <option selected="selected" value="user_order.php?date=onemonth">一個月內</option>
                    <option value="user_order.php?date=halfyear">半年內</option> 
                </select>';
                }
                if($date == 'halfyear'){
                    echo'<select name="date" class="selectpicker" onChange="location = this.value;">
                    <option value="">請選擇</option>
                    <option value="user_order.php?date=all">全部</option>
                    <option value="user_order.php?date=sevenday">一個禮拜內</option>
                    <option value="user_order.php?date=onemonth">一個月內</option>
                    <option selected="selected" value="user_order.php?date=halfyear">半年內</option> 
                </select>';
                }
                if($date == 'all'){
                    echo'<select name="date" class="selectpicker" onChange="location = this.value;">
                    <option value="">請選擇</option>
                    <option selected="selected" value="user_order.php?date=all">全部</option>
                    <option value="user_order.php?date=sevenday">一個禮拜內</option>
                    <option value="user_order.php?date=onemonth">一個月內</option>
                    <option value="user_order.php?date=halfyear">半年內</option> 
                </select>';
                }
            }
            else{
                echo'<select name="date" class="selectpicker" onChange="location = this.value;">
                    <option selected="selected" value="" >請選擇</option>
                    <option value="user_order.php?date=all">全部</option>
                    <option value="user_order.php?date=sevenday">一個禮拜內</option>
                    <option value="user_order.php?date=onemonth">一個月內</option>
                    <option value="user_order.php?date=halfyear">半年內</option> 
                </select>';
            }
        ?>
        <table class="table table-bordered" style="text-align:center;">
            <thead>
            <tr>
                <th style="text-align:center;">訂單日期</th>
                <th style="text-align:center;">訂單金額</th>
                <th style="text-align:center;">訂單內容</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($_GET['date'])){
                        $date = $_GET['date'];
                        if($date == 'sevenday'){
                            $sql = "SELECT * 
                                      FROM orders 
                                     WHERE (order_date BETWEEN '$sevenday' AND '$today') 
                                       AND (order_user = '".$_SESSION['userno']."') 
                                  order by order_date DESC";
                            $data = mysqli_query($link,$sql);
                        }
                        if($date == 'onemonth'){
                            $sql = "SELECT * 
                                      FROM orders 
                                     WHERE (order_date BETWEEN '$onemonth' AND '$today') 
                                       AND (order_user = '".$_SESSION['userno']."') 
                                  order by order_date DESC";                    
                            $data = mysqli_query($link,$sql);
                        }
                        if($date == 'halfyear'){
                            $sql = "SELECT * 
                                      FROM orders 
                                     WHERE (order_date BETWEEN '$halfyear' AND '$today') 
                                       AND (order_user = '".$_SESSION['userno']."') 
                                  order by order_date DESC";    
                            $data = mysqli_query($link,$sql);
                        }
                        if($date=='all'){
                            $sql = "SELECT * 
                                      FROM orders 
                                     WHERE order_user = '".$_SESSION['userno']."' 
                                  order by order_date DESC";
                        $data = mysqli_query($link,$sql);
                        }
                    }
                    else{
                        $sql = "SELECT * 
                                  FROM orders 
                                 WHERE order_user = '".$_SESSION['userno']."' 
                              order by order_date DESC";
                        $data = mysqli_query($link,$sql);
                    }
                    for($i=1; $i <= mysqli_num_rows($data); $i++) { 
                        $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
                        echo "<tr>";
                        echo    "<td>";
                        echo        $rs['order_date'];
                        echo    "</td>";
                        echo    "<td>".$rs['order_money']."</td>";
                        echo    "<td><a class='btn btn-primary btn-xs' href='user_order_detail.php?order_no=".$rs['order_no']."'>詳細</a></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        
        </div>
    </form>
</body>
</html>
