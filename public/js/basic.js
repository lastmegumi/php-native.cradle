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
