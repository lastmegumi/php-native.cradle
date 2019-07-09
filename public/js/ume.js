define(function(){

class ume{
	addtocart(data){
		return $.ajax({
			type: "POST",//方法类型
			dataType: "HTML",//预期服务器返回的数据类型
			url: "/cart/add",//url
			data : data,
		});
	}
	removefromcart(data){
		return $.ajax({
			type: "POST",//方法类型
			dataType: "HTML",//预期服务器返回的数据类型
			url: "/cart/remove",//url
			data : data,
		});
	}
	reloadcart(){
		return $.ajax({
			type: "GET",//方法类型
			dataType: "HTML",//预期服务器返回的数据类型
			url: "/cart/reload",//url
			data : {},
		});
	}
	getCart(){
		return $.ajax({
			type: "GET",//方法类型
			dataType: "JSON",//预期服务器返回的数据类型
			url: "/cart/get",//url
			data : {},
		});
	}
	saveProduct(data){
		return $.ajax({
			type: "POST",//方法类型
			dataType: "JSON",//预期服务器返回的数据类型
			url: "save",//url
			data : data
		});
	}
	shipping(data){
		return $.ajax({
			type: "POST",//方法类型
			dataType: "JSON",//预期服务器返回的数据类型
			url: "shipped",//url
			data : data,
		});
	}
	deliver(data){
		return $.ajax({
			type: "POST",//方法类型
			dataType: "JSON",//预期服务器返回的数据类型
			url: "delivered",//url
			data : data,
	                beforeSend: function(result){
            //$(".progress").show();
            //$("form#upload_photo").html("Uploading...");
        },
        success: function (result) {
        },
        error : function(err) {
        }
		});
	}
	deleteProduct(data){
		return $.ajax({
			type: "DELETE",//方法类型
			dataType: "JSON",//预期服务器返回的数据类型
			url: "delete",//url
			data : data
		});
	}
	removePhoto(data){
		return $.ajax({
			type: "DELETE",//方法类型
			dataType: "HTML",//预期服务器返回的数据类型
			url: "deletePhoto",//url
			data : data
		});
	}
	getProduct(data){
		return $.ajax({
			type: "GET",//方法类型
			dataType: "JSON",//预期服务器返回的数据类型
			url: "/product/product",//url
			data : data
		});
	}
	uploadPhoto(data){
		return $.ajax({
                // xhr: function() {
                //     var xhr = new window.XMLHttpRequest();
                //     xhr.upload.addEventListener("progress", function(evt) {
                //         if (evt.lengthComputable) {
                //             var percentComplete = (evt.loaded / evt.total) * 100;
                //             //Do something with upload progress here
                //              $("#upload_progress").width(percentComplete + '%');
                //         }
                //    }, false);
                //    return xhr;
                // },
                type: "POST",//方法类型
                dataType: "HTML",//预期服务器返回的数据类型
                url: "upload_image",//url
            	cache: false,
	            contentType: false,
	            processData: false,
                data : data,
              });
		return false;
	}
	login(data){
		return $.ajax({
			type: "POST",//方法类型
			dataType: "JSON",//预期服务器返回的数据类型
			url: "/user/verify",//url
			data : data,
		});
	}
	register(data){
		return $.ajax({
			type: "POST",//方法类型
			dataType: "JSON",//预期服务器返回的数据类型
			url: "register_new",//url
			data : data,
		});
	}
	checkout(data){
		return $.ajax({
			type: "POST",//方法类型
			dataType: "JSON",//预期服务器返回的数据类型
			url: "/checkout/placeorder",//url
			data : data,
			success:function(res){

			},
			error:function(err){
				
			}
		});
	}
	getReview(data){
		return $.ajax({
			type: "GET",//方法类型
			dataType: "JSON",//预期服务器返回的数据类型
			url: "/reviews",//url
			data : data,
		});
	}
	addReview(data){
		return $.ajax({
			type: "POST",//方法类型
			dataType: "JSON",//预期服务器返回的数据类型
			url: "/reviews",//url
			data : data,
			success:function(res){

			},
			error:function(err){
				
			}
		});
	}
	sendMail(data){
		return $.ajax({
			type: "POST",//方法类型
			dataType: "JSON",//预期服务器返回的数据类型
			url: "/mail/support",//url
			data : data,
		});
	}
}
return ume
});
//export {ume}