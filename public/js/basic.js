
import {ume} from './ume.js';

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
});


function _init(){
	$(".add-to-cart").on("click", function(e){
		e.preventDefault();
		let data = {};
		data.pid = $(this).attr("data-id");
		data.quantity = $("#product_qty").length > 0? $("#product_qty").val():1;
		data.quantity = data.quantity? data.quantity:0;
		let x = new ume()
		x.addtocart(data).done(tips);
		return false;
	});
	
	$(".remove-from-cart").on("click", function(e){
		e.preventDefault();
		let data = {};
		data.pid = $(this).attr("data-id");
		let x = new ume()
		x.removefromcart(data).done(x.reloadcart().done(loadcart));
		return false;
	});
}

function loadcart(data){
	let p = $(".cart-list").parent();
	p.html(data);
	init();

}

function tips(data){	
	M.toast({html: data, classes: 'rounded'});
}

