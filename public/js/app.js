requirejs.config({
    paths: {
        'ume': '/js/ume',
        'act': '/js/act'
    }
});
　　require(['ume' ,'act'], function (ume, act){
		window.ume = ume;
		window.act = act;

		$('[data-load ="ajax"]').each( function(){
			let func = $(this).attr("data-func");
			//eval(func + "($(this))");
			switch(func){
				case "loadReview":
					act.prototype.loadReview($(this));break;
				case "loadProduct":
					act.prototype.loadProduct();
				case "email":
					act.prototype.email();
				default:break;
			}
		});
		
　　});