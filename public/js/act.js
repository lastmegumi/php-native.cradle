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

		updateQueryStringParameter(uri, key, value) {
		  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
		  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
		  if (uri.match(re)) {
		    return uri.replace(re, '$1' + key + "=" + value + '$2');
		  }
		  else {
		    return uri + separator + key + "=" + value;
		  }
		}

		removeURLParameter(url, parameter) {
		    //prefer to use l.search if you have a location/link object
		    var urlparts = url.split('?');   
		    if (urlparts.length >= 2) {

		        var prefix = encodeURIComponent(parameter) + '=';
		        var pars = urlparts[1].split(/[&;]/g);

		        //reverse iteration as may be destructive
		        for (var i = pars.length; i-- > 0;) {    
		            //idiom for string.startsWith
		            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
		                pars.splice(i, 1);
		            }
		        }

		        return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
		    }
		    return url;
		}
	}

	return act;

});