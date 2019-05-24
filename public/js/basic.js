function ax(r){
	$("button").prop('disabled', true); //disable
    $.ajax({
	  url: r.u,
	  method: r.m,
	  data: r.p,
	  dataType: r.d,
	  success: function(data){
	  	if(r.h){r.h.html(data);}
	  	if(r.d == "JSON"){re_json(data);}
		$("button").prop('disabled', false); //disable
	  },
	  error: function(data){
	  	alert( "Request failed: " + data );
		$("button").prop('disabled', false); //disable
	  }
	});
}

function re_json(data){
	if(data.data.url){
		window.location.href = data.data.url;		
	}
}

$(document).ready(()  =>  {
	$("tbody tr.clickable").click(function() {
	    window.location = $(this).data("href");
	});
	$('select').formSelect();

	$(function() {
		$('img.lazy').lazy();
	}); // lazyload       
	$(".add-to-cart").click(function(e){
	e.preventDefault();
	let data = {};
	data.pid = $(this).attr("data-id");
	data.quantity = $("#product_qty").length > 0? $("#product_qty").val():1;
	data.quantity = data.quantity? data.quantity:0;
		$.ajax({
			type: "POST",//方法类型
			dataType: "HTML",//预期服务器返回的数据类型
			url: "/cart/add",//url
			data : data,
			success: function (result) {
				alert(result);
			},
			error : function() {
			    alert("异常！");
			}
		});
		return false;
	});
});
