define(function(){

	class act{
		loadReview(t){
				let r = new Review();
				let pid = t.attr("data-product-id");
				r.loadReview(pid);
		}

		loadProduct(t){
				let r = new Product();
				r.loadData();
		}

		email(){
				let r = new Email();
				r.renderForm();
		}
	}

	return act;

});