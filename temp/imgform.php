<form class="upload ele ele-img" id="<?php echo  $_POST['rid'] ;?>">
	<input type="file" id="file" name="file" required/>
	<button id="upload">Upload</button>
	<button type="button" onclick="del(this)">删除</button>
</form>
<script type="text/javascript">
                $('form#<?php echo $_POST['rid']?>').submit(function (e) {
                	e.preventDefault();
                	alert("123");
                    var file_data = $('#file').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                    $.ajax({
                        url: 'upload.php', // point to server-side PHP script 
                        dataType: 'text', // what to expect back from the PHP script
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (response) {
                            //alert(response); // display success response from the PHP script
                            $("section[ele='<?php echo $_POST['rid']?>'").html(response);
                        },
                        error: function (response) {
                            alert(response); // display error response from the PHP script
                        }
                    });
                    return false;
                });                
</script>
