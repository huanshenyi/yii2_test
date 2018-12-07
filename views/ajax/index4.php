<script src="https://cdn.staticfile.org/vue/2.4.2/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
<body>
<div id="box">
    <p>{{msg}}</p>
    <input type="button" @click="get()" value="点我异步获取数据(Get)">
    <div class="col-sm-10">
        <input type="text" value="" class="form-control" id="username" name="username" placeholder="UserName"><span id="msg" style="color: red"></span>
    </div>
</div>
<script type = "text/javascript">
    window.onload = function(){
        var vm = new Vue({
            el:'#box',
            data:{
                msg:'Hello World!',
            },
            methods:{
                get:function(){
                    //发送get请求
                    this.$http.post('/ajax/vue-ajax',{name:"vueAjaxテスト"},{emulateJSON:true}).then(function(res){
                        console.log(res.body.name);
                        // document.getElementById("msg").innerHTML=res.body.name;
                        $("#username").val(res.body.name);
                    },function(){
                        console.log('请求失败处理');
                    });
                }
            }
        });
    }
</script>