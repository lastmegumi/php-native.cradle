<?php
print_r($product);
var_dump(session_id());
?>
<section class="row">
	<div class="col s4 white">
		<?php echo $product->getImgs();?>
	</div>

	<div class="col s8 white">
		<h2><?php echo $product->getTitle();?></h2>
		<h4><small><?php echo $product->getCurrency();?></small><?php echo $product->getPrice();?></h4>
		<div class="row">
			<div class="input-field col s2">
			    <select class="browser-default" id="product_qty">
			      <option value="" disabled selected>0</option>
			      <option value="1">1</option>
			      <option value="2">2</option>
			      <option value="3">3</option>
			    </select>
			 </div>
			 <div class="col s4">
			 	<div class style="padding:1rem">
					<a class="waves-effect waves-light btn red" id="add-to-cart" data-id="<?php echo $product->id ?>">
						<i class="material-icons left">add_shopping_cart</i>Add to cart</a>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="row">
	<div class="col s12">
		<div class="description white">
			<?php echo $product->getDescription();?>
		</div>
	</div>
</section>
<script type="text/javascript">
$(document).ready(() => {
	$("#add-to-cart").click(function(e){
		e.preventDefault();
		let data = {};
		data.pid = $(this).attr("data-id");
		data.quantity = $("#product_qty")? $("#product_qty").val():1;
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
})
</script>