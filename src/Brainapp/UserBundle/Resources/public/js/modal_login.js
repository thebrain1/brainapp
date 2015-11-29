$(document).ready(function() {
	$('button.close').click(function(e) {
		e.preventDefault();
		$('#error').slideUp(300);
	});
	
	$('#loginModal').on('shown.bs.modal', function () {
	    $('#username').focus();
	})
	
	$('.modal #submit').click(function(e) {
		e.preventDefault();
		var $form = $("#form-login");
		$('#username').select();
		$.ajax({
			type : $form.attr('method'),
			url : $form.attr('action'),
			data : $form.serialize(),
			dataType : "json",
			success : function(data, status, object) 
			{
				if (data.error)
				{
					$('#error #message').html(data.message);
					$('#error').slideDown(300);
				}
				else
					location.reload();
			},
			error : function(data, status, object) {
				console.log(data);
				alert("Es ist ein unbekannter Fehler aufgetreten!")
			}
		});
	});
});