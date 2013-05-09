$(document).ready(function() {

    // Show the the upload dialog
    $(document).on('click', '#btnUpload', function() {
        overlay(true);
        $("#uploadBox").fadeIn("fast");
        return false;
    });
    
    $(document).on('click', '.btnUploadSend', function() {
        $.ajaxFileUpload({
            url: '/~api/upload/media', 
            secureuri: false,
            fileElementId: 'mediaFile',
            dataType: 'json',
            success: function (data, status) {
                if(typeof(data.error) != 'undefined') {
                    if(data.error != '') {
                        alert(data.error);
                    } else {
                        alert(data.msg);
                    }
                }
            },
            error: function (data, status, e) {
                alert(e);
            }
        });
        return false;
    });

    // Cancel a login or forgot password
    $(document).on('click', '.btnUploadCancel', function() {
        overlay(false);
        $("#uploadBox").fadeOut("fast");
        return false;
    });

    // Limit textareas
	$('textarea[maxlength]').keyup(function(){
		//get the limit from maxlength attribute
		var limit = parseInt($(this).attr('maxlength'));
		//get the current text inside the textarea
		var text = $(this).val();
		//count the number of characters in the text
		var chars = text.length;

		//check if there are more characters then allowed
		if(chars > limit){
			//and if there are use substr to get the text before the limit
			var new_text = text.substr(0, limit);

			//and change the current text with the new text
			$(this).val(new_text);
		}
		
		// Update counters
		$('#' + $(this).attr('id') + 'Count').html(chars + '/' + limit);
	});
	
	
	// Initilize counters
	$('textarea[maxlength]').each(function() {
		//get the limit from maxlength attribute
		var limit = parseInt($(this).attr('maxlength'));
		//get the current text inside the textarea
		var text = $(this).val();
		//count the number of characters in the text
		var chars = text.length;

		$('#' + $(this).attr('id') + 'Count').html(chars + '/' + limit);
	});
	
	        
    
    
    ////
    // Attributes
    ////
    
    
    // Date
    $('.attribute-date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
    
    // Integers
    $('.attribute-int').spinner({
        numberFormat: 'n'
    });

});


