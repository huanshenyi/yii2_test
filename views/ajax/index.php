<form class="form-horizontal">
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

<script type="text/javascript">
    window.onload=function(){
        $('#username').change(function () {
            //usernameを取得
            var username=$("#username").val();
            //ajaxでusernameを送る
            var ajax= new XMLHttpRequest();
            ajax.open("GET",'/ajax/get-ajax?username='+username);
            ajax.send();
            ajax.onreadystatechange=function () {
                if(ajax.readyState==4 && ajax.status==200){
                    if(ajax.responseText=="0"){
                       document.getElementById("msg").innerHTML="ユーザー存在します"
                    }else {
                       document.getElementById("msg").innerHTML=""
                    }
                }
            }
        })
    }
    // var ajax=new XMLHttpRequest();
    // ajax.open("GET",'/ajax/ajax')
    // ajax.send();
    // ajax.onreadystatechange=function () {
    //     //ajax.readystate==4->ajax.responsetest受けた
    //     //states
    //    if(ajax.readyState == 4 && ajax.states==200){
    //        console.log(ajax.responseText);//リターンデータ
    //        console.log(ajax.responseXML);//リターンデータはxml
    //    }
    // }
  // function createAjax(){
  //     var ajax;
  //     if(window.XMLHttpRequest){
  //         var ajax=new XMLHttpRequest();
  //     }else {
  //         var versions=["Microsoft.XMLHTTP","Msxml2.XMLHTTP"]
  //         for (var i in versions){
  //             try {
  //                 var ajax = new ActiveXObject(versions[i]);
  //                 break;
  //             }catch (e) {
  //
  //             }
  //         }
  //     }
  //     return ajax;
  // }
</script>