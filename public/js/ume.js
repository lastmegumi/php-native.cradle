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
	login(data){
		return $.ajax({
			type: "GET",//方法类型
			dataType: "HTML",//预期服务器返回的数据类型
			url: "/user/verify",//url
			data : {},
		});
	}
	register(data){
		return $.ajax({
			type: "GET",//方法类型
			dataType: "HTML",//预期服务器返回的数据类型
			url: "/cart/reload",//url
			data : {},
		});
	}
}
export {ume}