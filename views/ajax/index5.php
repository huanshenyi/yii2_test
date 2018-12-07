<form class="form-horizontal">
    <p><h1>Index5</h1></p>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">ユーザーネーム</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="username" name="username" placeholder="UserName"><span id="msg" style="color: red"></span>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">提出</button>
        </div>
    </div>
</form>
<div>
    <?= date('Y年m月d日 H時i分s秒' )."<br/>"?>

    <?php
    //data("W")週の何日
    //echo date("w");
    switch (date('w')){
        case 0:$dayStr="日";break;
        case 1:$dayStr="月";break;
        case 2:$dayStr="火";break;
        case 3:$dayStr="水";break;
        case 4:$dayStr="木";break;
        case 5:$dayStr="金";break;
        case 6:$dayStr="土";break;
    }
    echo '<hr/>';
    echo '今日は'.$dayStr.'曜日'.'<br/>';
    //date('L')==1 ->閏年
     if(date('L')==1){
         echo '今年は閏年'.'<br/>';
     }else{
         echo '今年は閏年ではない'.'<br/>';
     }
     echo date('一週間前は'.'Y年m月d日 H時i分s秒',strtotime('-1 week'))."<br/>";
     echo '<hr/>';
     $start=microtime(true);
     for($i=1;$i<=10000;$i++){
         $arr[]=$i;
     }
     $end=microtime(true);
     echo 'プログラムの執行時間'.round($end-$start,4).'<br/>';
     echo '<hr/>';
     echo '時間合理的かどうかの判断checkdate()'; var_dump(checkdate(8,12,2016));
    ?>
</div>
<script type="text/javascript">
    window.onload=function () {
       $('#username').change(function () {
           var username=$("#username").val();
           //username = encodeURIComponent(username); IE仕様
           var csrfToken = $('meta[name="csrf-token"]').attr("content");
           $.ajax({
               type:"POST",
               url:'/ajax/ajax-check',
               data:{_csrf: csrfToken, username: username},
               success:function (data) {
                   if(data=='存在します'){
                       document.getElementById("msg").innerHTML="ユーザー存在します"
                   }else {
                       document.getElementById("msg").innerHTML='存在しません'
                   }
               }
           });

       })
    }

</script>