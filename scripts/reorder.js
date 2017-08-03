$(document).ready(function() { // begin document ready
	
	
    $('#list-items').sortable({
    axis: 'y',
    update: function() {
		var data_to_send = $('#list-items').sortable("serialize");
		$.ajax({
			type: "GET",
			dataType: "JSON",
			url: "horses/reorder",
			data: data_to_send,
	    	error: function (xhr, ajaxOptions, thrownError) 
	    		{
	        		alert(thrownError);
	      		}	
		    });
		location.reload();
		}
	});
    
    $('li').on('mouseover',function() {
    $(this).css(
	    {
		    'backgroundColor' : '#e8e5e5',
		    'color' : 'black'
	    }
    );
    }).on('mouseout' ,function() {
	    $('li').css(
		    {
			    'backgroundColor' : '',
			    'color' : ''
		    }
	    )
    });
	
}); // end document ready