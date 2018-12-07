<div id="box"></div>
<div class="page-header">
    <h3>スクリーンショットキー<small>(Print Screen)押した後</small><br>Ctrl+v<small>でスクリーンショットをサーバーへ保存できます</small></h3>
</div>

<script type="text/javascript">


    window.addEventListener('paste', function (e) {
        var items;
        if (e.clipboardData && e.clipboardData.items) {
            items = e.clipboardData.items;
            if (items) {
                items = Array.prototype.filter.call(items, function (element) {
                    return element.type.indexOf("image") >= 0;
                });

                Array.prototype.forEach.call(items, function (item) {
                    var blob = item.getAsFile();
                    var reader = new FileReader();
                    reader.onloadend = function (event) {
                        var imgBase64 = event.target.result;  //    event.target.result.split(",")  [0]=data:image/png;base64  [1]=data
                        console.log(imgBase64);  // base64
                        var dataURI = imgBase64;
                        var blob = dataURItoBlob(dataURI); // blob
                        console.log(blob);
                        uploadImg(blob);

                    };
                    reader.readAsDataURL(blob);
                });
            }
        }
    });

    function dataURItoBlob(dataURI) {
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
        var byteString = atob(dataURI.split(',')[1]);
        var arrayBuffer = new ArrayBuffer(byteString.length);
        var intArray = new Uint8Array(arrayBuffer);

        for (var i = 0; i < byteString.length; i++) {
            intArray[i] = byteString.charCodeAt(i);
        }
        return new Blob([intArray], {type: mimeString});
    }



    function uploadImg(file) {
        var formData = new FormData();
        formData.append('my-image-file', file);
        formData.append('username', 'myfile');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/redis/test');
        xhr.onload = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var data =JSON.parse(xhr.responseText), tarBox = document.getElementById('box');
                    if (data.id == 1) {
                        var img = document.createElement('img');
                        img.className = 'my_img';
                        img.src = data.src;
                        img.height=data.height;
                        tarBox.appendChild(img);
                        return 'aaa';
                    } else {
                        alert(data.msg);
                    }
                } else {
                    console.log(xhr.statusText);
                }
            }
        };
        xhr.onerror = function (e) {
            console.log(xhr.statusText);
        };
        xhr.send(formData);

    }
</script>