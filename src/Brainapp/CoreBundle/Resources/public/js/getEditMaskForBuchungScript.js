$(document).ready(function() {	
	$('.btn-edit-buchung').on('click', function() {
		
		var myUrl = $(this).attr('action');
		
		$.ajax({
			url: $(this).attr('action'),
			async: false,
			type: "GET",
			dataType: "html",
			
		    success: function (response) {
			     
			     var editMaskContainer = document.getElementById('modalMaskEditBuchungContainer');
			     
			     if(editMaskContainer == null)
			     {
			    	 alert("editMaskContainer ist null!");
			    	 throw "editMaskContainer ist null!";
			     }
			     
			     $(editMaskContainer).html(response);
		    },
		    error: function () {
		         alert('Es ist ein unbekannter Fehler aufgetreten.');
		         throw "Es ist ein unbekannter Fehler aufgetreten.";
		    }
		});
	});
});