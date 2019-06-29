function _init(){
	$(".add-to-cart").unbind().on("click", function(e){
		e.preventDefault();
		let data = {};
		data.pid = $(this).attr("data-id");
		data.quantity = $("#product_qty").length > 0? $("#product_qty").val():1;
		data.quantity = data.quantity? data.quantity:0;
		let x = new ume()
		x.addtocart(data).done(tips);
		return false;
	});
	
	$(".remove-from-cart").unbind().on("click", function(e){
		e.preventDefault();
		let data = {};
		data.pid = $(this).attr("data-id");
		let x = new ume()
		x.removefromcart(data).done(x.reloadcart().done(loadcart));
		return false;
	});

	$("form#save_product").unbind().submit(function(e){
		e.preventDefault();
		let data = $(this).serializeArray();
		data.push({"name": "description" , "value" : editor.getData()});
		let x = new ume()
		x.saveProduct(data).done(handleback);
		return false;
	});

	$("#mark_shipping").unbind().click(function(e){
		e.preventDefault();
		let data = {};
		data.order_id = $(this).attr('data-id');
		let x = new ume()
		x.shipping(data).done(handleback);
		return false;
	});

	$("#mark_delivered").unbind().click(function(e){
		e.preventDefault();
		let data = {};
		data.order_id = $(this).attr('data-id');
		let x = new ume()
		x.deliver(data).done(handleback);
		return false;				
	});

	$("#login").unbind().click(function(e){
		e.preventDefault();
		let data = $(this).parents("form").serializeArray();
		let x = new ume()
		x.login(data).done(handleback);
		return false;
	});

	$("#register").unbind().click(function(e){
		e.preventDefault();
		let data = $(this).parents("form").serializeArray();
		let x = new ume()
		x.register(data).done(handleback);
		return false;
	});

	$(".remove_photo").unbind().click(function(e){
		e.preventDefault();
		let data = {"data_id" : $(this).attr("data-id")};
		let x = new ume()
		x.removePhoto(data).done(handleback);
		$(this).parents(".product_image_edit").remove();
		return false;
	});

	$(".delete_product").unbind().click(function(e){
		if(!confirm("Really want delete?")) return;
		e.preventDefault();
		let data = {"data_id" : $(this).attr("data-id")};
		let x = new ume()
		x.deleteProduct(data).done(handleback);
		return false;
	});

	$("#product_image_upload").unbind().change(function(e){
		e.preventDefault();		
        var file_data = $('#product_image_upload').prop('files');
        var form_data = new FormData();
        var data = [];
        for(let i = 0; i < file_data.length; i++){
			form_data.append('data[]', file_data[i]);
        }
        let x = new ume()
        $('#product_image_upload').val("");
		x.uploadPhoto(form_data).done(insert);					  //
	})

	$("#check_out").unbind().submit(function(e){
		e.preventDefault();
		let data = $(this).serializeArray();
		let x = new ume()
		x.checkout(data).done(handleback);
		return false;
	});

	$("#getCart").unbind().hover(function(e){
		e.preventDefault();
		let data = $(this).serializeArray();
		let x = new ume()
		x.getCart(data).done(appendtotopcart);
		return false;
	})
}

function insert(data, ele){
	try {
		$("#product_images").append(data);
	}
	catch(err) {

	}
	_init();
}

function loadcart(data){
	let p = $(".cart-list").parent();
	p.html(data);
	_init();
}

function handleback(data){
	if(data.status){
		if(data.url){
			window.location.replace(data.url);
		}
		if(data.message){
			tips(data.message);
		}
	}else{
		tips(data.message);
	}
	_init();
}

function tips(data){
	data = data ? data : "Complete"
	M.toast({html: data, classes: 'rounded'});
}

function appendtotopcart(data){
	const domContainer = document.querySelector('#top_cart');
	ReactDOM.render(e(Topshoppingcart, data), domContainer);
}

$(document).ready(()  =>  {
	$("tbody tr.clickable").on("click", function() {
	    window.location = $(this).data("href");
	});
	$('select').formSelect();

	$(function() {
		$('img.lazy').lazy();
	}); // lazyload
	_init();

	$(".fancybox-thumb").fancybox({
		prevEffect	: 'none',
		nextEffect	: 'none',
		helpers	: {
			title	: {
				type: 'outside'
			},
			thumbs	: {
				width	: 50,
				height	: 50
			}
		}
	});

	    ClassicEditor
	    .create( document.querySelector( '#editor' ) )
	    .then( editor => {
	        window.editor = editor;})
	    .catch( error => {
	        //console.error( error );
	    } );

    var elems = document.querySelectorAll('.dropdown-trigger');
    var instances = M.Dropdown.init(elems, {hover: true,constrainWidth:false});


});
