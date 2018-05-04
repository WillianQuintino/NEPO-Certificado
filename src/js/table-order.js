$( "table tbody" ).sortable( {
	update: function( event, ui ) {
    $(this).children().each(function(index) {
			$(this).find('textarea').last().html(index + 1)
    });
  }
});
