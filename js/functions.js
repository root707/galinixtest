function clearRecords() {
	$.ajax({
    type: "POST",
    url: "requests/clearRecords.php",
    cache: false,
    success: function(html) {
		$('.container').prepend(html);
    }
	});
	$('#exampleModalCenter').modal('hide');
}