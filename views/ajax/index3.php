<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>

<button id="btn" type="button" class="btn btn-primary btn-lg btn-block">get練習</button>
<input id="username" name="username" value="" class="form-control" type="text" placeholder="Readonly input here…" readonly>


<div id="app">
    <table class="table table-striped">
        <tr>
            <th>{{message}}</th>
        </tr>
    </table>
</div>

<script type="text/javascript">
    window.onload=function () {
        $("#btn").click(function () {
            var username= $("#username").val();
            $.ajax({
                type:"get",
                url:'/ajax/yii-ajax',
                data: {username: username},
                success:function (data) {
                    console.log(data);
                    if(data=="getだよ"){
                       $("#username").val(data)
                    }
                }
            })
        })
    };

    new Vue({
       el:"#app",
        data:{
           message:"test"
        },
    })

</script>