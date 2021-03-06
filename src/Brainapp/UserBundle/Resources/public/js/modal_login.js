$(document).ready(function() {
	$('button.close').click(function(e) {
		e.preventDefault();
		$(this).parent('#error').slideUp(300);
//		$('#loginModal #error').slideUp(300);
//		$('#resettingModal #error').slideUp(300);
	});
	
	$('#resettingModal').on('shown.bs.modal', function () {
		$('#loginModal').modal('hide');
	})

	$('#loginModal').on('shown.bs.modal', function () {
		$('#resettingModal').modal('hide');
	    $('#username').focus();
	})
	
	/* HANDLE AJAX LOGIN */
	$('.modal #form-login #submit').click(function(e) {
		e.preventDefault();
		var $form = $("#form-login");
		$("#form-login .fa-spinner").show();
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
				
				$("#form-login .fa-spinner").hide();
			},
			error : function(data, status, object) {
				console.log(data);
				alert("Es ist ein unbekannter Fehler aufgetreten!")
				$("#form-login .fa-spinner").hide();
			}
		});
	});
	/* HANDLE AJAX PASSWORT RESET */
	$('.modal #form-resetting #submit').click(function(e) {
		e.preventDefault();
		var $form = $("#form-resetting");
		$("#form-resetting .fa-spinner").show();
		$.ajax({
			type : $form.attr('method'),
			url : $form.attr('action'),
			data : $form.serialize(),
			dataType : "json",
			success : function(data, status, object) 
			{
				if (data.error)
				{
					$('#resettingModal #error #message').html(data.message);
					$('#resettingModal #error').slideDown(300);
				}
				else
				{
					$form.hide();
					$('#resettingModal #success #message').html(data.message);
					$('#resettingModal #success').slideDown(300);
				}
				$("#form-resetting .fa-spinner").hide();
			},
			error : function(data, status, object) {
				console.log(data);
				alert("Es ist ein unbekannter Fehler aufgetreten!")
				$("#form-resetting .fa-spinner").hide();
			}
		});
	});
});