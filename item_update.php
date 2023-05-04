<?php
    include("title.php");
    if(isset($_POST['enter'])){
        if(isset($_POST['item_name']) && $_POST['item_class'] 
                                      && $_POST['item_price']
                                      && $_POST['item_detail']){
            

            $sql = "select item_no
                    from items
                order by item_no DESC";
            $data = mysqli_query($link,$sql);
            
            if(mysqli_num_rows($data)!=0){
                $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
                $img_name = $rs['item_no']+1;
            }
            else
                $img_name = 1;
            $dir = "item_photo/";
            $uploadfile = $dir.$img_name.".jpg";
            if(move_uploaded_file($_FILES['item_picture']['tmp_name'],$uploadfile)){
                $item_name = $_POST['item_name'];                                        
                $item_class = $_POST['item_class']; 
                $item_detail = $_POST['item_detail'];
                $item_price = $_POST['item_price'];
                echo $item_class;
                $sql = "select class_no
                      from items_class
                     where class_name = '".$item_class."'";
                $data = mysqli_query($link,$sql);
                //代表已有此商品分類
                if(mysqli_num_rows($data) != 0){
                    $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
                    $item_class_no = $rs['class_no'];
                }
                //代表尚未有此商品分類
                else{
                    $sql = "select max(class_no) as class_no
                            from items_class";
                    $data = mysqli_query($link,$sql);
                    $rs = mysqli_fetch_array($data,MYSQLI_ASSOC);
                    $item_class_no = $rs['class_no'] + 1;
                    $sql = "INSERT INTO items_class(class_no,
                                                    class_name)
                                            values(".$item_class_no.",
                                                  '".$item_class."')";
                    mysqli_query($link,$sql);
                }
                $sql = "INSERT INTO `items`(`item_no`,
                                            `item_class`, 
                                            `item_name`, 
                                            `item_detail`, 
                                            `item_picture`, 
                                            `item_price`) 
                                    VALUES ('".$img_name."',
                                            '".$item_class_no."',
                                            '".$item_name."',
                                            '".$item_detail."',
                                            '".$img_name.".jpg',
                                            '".$item_price."')";
                mysqli_query($link,$sql);  
                echo '<b>上傳成功</b>';
                
            }
        }
        else echo '<b>上傳失敗</b>';
    }
        

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>商品上傳</title>
    
    <style>

    </style>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <div style="width:100%">
            <div style="background-color:#F5F5F5; width:80%; margin:0px auto; text-align:center">
                商品上傳
            </div>
            <div style="width:60%;margin-left:20%">
            <table class="table">
                <tbody>
                    <tr>
                        <td>商品名稱</td>
                        <td>
                            <input type="text" class="form-control" id="item_name" placeholder="請輸入商品名稱" name="item_name">
                        </td>
                    </tr>
                    <tr>
                        <td>商品類別</td>
                        <td>
                            <input type="text" class="form-control" id="item_class" placeholder="請輸入類別代號" name="item_class">
                        </td>
                    </tr>
                    <tr>
                        <td>商品內容</td>
                        <td> 
                            <input type="text" class="form-control" id="item_detail" placeholder="請輸入商品內容" name="item_detail">
                        </td>
                    </tr>
                    <tr>
                        <td>商品價格</td>
                        <td> 
                            <input type="number" class="form-control" id="item_price" placeholder="請輸入商品價格" name="item_price">
                        </td>
                    </tr>
                    <tr>
                        <td>商品圖片</td>
                        <td>
                        　      <input type="file" name="item_picture" id="item_picture" /><br />
                        </td>
                    </tr>
                </tbody>
            </table>
                    <div>
                        <input type="submit" class="btn btn-success" name="enter" value="上傳">
                        <a href="member_edit" class="btn btn-default" name="cancel">
                            返回
                        </a>
                    </div>
                </div>
        </div>

    </from>

</body>
</html>