var act;
function login(){
	var param = {
		usernm: $('#usernm').val(), 
		pword: $('#pword').val()
	};

	$.post(API_host+"auth/login", param, function(resp){
		//var obj = JSON.parse(resp);  
		//alert(obj);			
		if(resp.message == 'accepted'){
			var dataUser = resp.data[0];
			resp.data = dataUser; 
			$.post(host+"auth/saveLoginData", resp, function(){
            	window.location.href = host+resp.data['app'];
            });
		} else {
			swal({
                title: resp.message,
                text: "Silahkan coba kembali atau hubungi admin",
                type: 'warning',
			    confirmButtonClass: "btn btn-danger",
            });
		};
	});
};

function resetPassword(){
	var validated = true;
	$('#frm_resetPassword .form-control').each(function(i, obj){
		if(obj.required){
			if(obj.value.trim() == ""){
				$('#'+obj.id).focus();

				//e.preventDefault();
				validated = false;
				return false;
			};
		};
	});

	if(validated == true){
		blockPage('on');
		$.ajax({
		    url: API_host+'auth/lupaPassword',
		    method: 'POST',
		    data: {
		    	user_id: $('#usernm').val(),
		    	email: $('#email').val(),
		    	captcha: $('#tebakCaptcha').val()
		    },
		    success: function(resp){
		    	blockPage('off');
		    	if(resp.error == false){
		        	swal({
				        title: 'Permohonan mengganti password sukses',
		                text: resp.message,
		                type: 'info',
				        buttonsStyling: false,
				        confirmButtonText: 'Ok',
				        confirmButtonClass: 'btn btn-success'
				    }).then(function(result){
				    	window.location.href = host;
			    	});
				} else {
					swal({
		                title: 'Gagal memperbaharui data',
		                text: resp.message,
		                type: 'warning',
				        buttonsStyling: false,
				        confirmButtonText: 'Ok',
				        confirmButtonClass: 'btn btn-success'
		            });
				};
		    },
		    error: function(request,msg,error) {
		    	blockPage('off');
		        swal({
	                title: 'Gagal memperbaharui data',
	                text: msg,
	                type: 'warning',
			        buttonsStyling: false,
			        confirmButtonText: 'Ok',
			        confirmButtonClass: 'btn btn-success'
	            });
		    }
		});
	} else {
		swal({
            title: 'Gagal memperbaharui data',
            text: "Kolom pertanyaan wajib diisi!",
            type: 'warning',
	        buttonsStyling: false,
	        confirmButtonText: 'Ok',
	        confirmButtonClass: 'btn btn-success'
        });
	};
};

$('input.edLogin').keypress(function(e){
	if (e.which == '13') {
		e.preventDefault();
		login();
	}
});