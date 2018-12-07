<form class="form-horizontal">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">ユーザーネーム</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="username" name="username" placeholder="UserName"><span id="msg" style="color: red"></span>
        </div>
    </div>
    <!--    <div class="form-group">-->
    <!--        <label for="inputPassword3" class="col-sm-2 control-label">パスワード</label>-->
    <!--        <div class="col-sm-10">-->
    <!--            <input type="password" class="form-control" id="password" name="password" placeholder="Password">-->
    <!--        </div>-->
    <!--    </div>-->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">提出</button>
        </div>
    </div>
    <div>
        <?= date('Y-m-d H:i:s' ,time()).'<br/>'?>
        <?= strtotime('now').'<br/>';?>
        <?= '現在時刻'.': '.date('Y-m-d H:i:s',strtotime('now')).'<br/>'?>
        <?php
        echo '1日後現在時刻'.': '.date('Y-m-d H:i:s',strtotime('+1 day'))."<br/>"
        ?>
        <?= '1年後は:'.date('Y-m-d H:i:s',strtotime('+1 year')).'<br/>'?>
        <?= '2年3ヶ月12日後'.date("Y-m-d H:i:s",strtotime('+2 years 3 months 12 days'))?>
    </div>
    <div>
        <p>h5のカレンダー</p>
        <!--応用としては時間の送信時に使う-->
        <form >
            <input type="date" name="datetime" id=""/><br>
            <input type="datetime-local" name="datetime1" id=""><br>
            <input type="month" name="month" id=""><br>
            <input type="week" name="week" id="">
        </form>
    </div>
</form>
<script type="text/javascript">
    window.onload=function() {
        $("#username").change(function () {
            var username = $("#username").val();
            //文字化け対処
            username = encodeURIComponent(username);
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: 'POST',
                url: '/ajax/post-ajax',
                data: {_csrf: csrfToken, username: username},
                success:function (data) {
                    //console.log("リスポンス帰ってきた");
                    //jsonデータをjavaScript対象へ
                    var text=JSON.parse(data);
                    //console.log(text.status);
                   if(text.status == 0){
                       document.getElementById("msg").innerHTML="ユーザー存在します"
                   }else {
                       document.getElementById("msg").innerHTML=""
                   }
               }

            });
           // console.log("ここまで執行");
        })

    }
</script>