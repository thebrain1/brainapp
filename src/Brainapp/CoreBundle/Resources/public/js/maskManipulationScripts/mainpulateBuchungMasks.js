$(document).ready(function() {
	$('.btn-delete-buchung').on('click', function() {
		var buchungId = $(this).attr('data-id');
		var buchungTitle = $(this).attr('data-buchungTitle');
		$('input[name="#modalMaskDeleteBuchung_ff_id"]').val(buchungId);
		$('#buchungTitle').html(buchungTitle);
	});
});
