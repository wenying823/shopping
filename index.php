<?php
    include("title.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>首頁</title>
        <style>
            #new_item{
                width: 300px; 
                height: 300px; 
                background-color: gray;
                border-radius: 50px;
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
        </style>
    </head>
    <body>
        <form method="post">
            <div class="container">
                <div id="new_item" style="width: 300px; height: 300px; background-color:gray;">
                    <div class="title">
                        最新上傳商品
                    </div>
                    <div class="item">
                        <div class="item_detail">
                            <a>iphone xs 256g</a>
                        </div>
                        <div class="item_detail">
                            <a>iphone xs 256g</a>
                        </div>
                        <div class="item_detail">
                            <a>iphone xs 256g</a>
                        </div>
                        <div class="item_detail">
                            <a>iphone xs 256g</a>
                        </div>
                        <div class="item_detail">
                            <a>iphone xs 256g</a>
                        </div>
                        <div class="item_detail">
                            <a>iphone xs 256g</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>

