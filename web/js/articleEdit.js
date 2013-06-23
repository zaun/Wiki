$(document).ready(function() {

    // Show the the upload dialog
    $(document).on('click', '#btnUpload, #btnShowUpload', function() {
        $('#mediaTitle').val('');
        $('#mediaFile').val('');
        overlay(true);
        $("#mediaBox").fadeOut("fast");
        $("#uploadBox").fadeIn("fast");
        return false;
    });

    // Show the the media dialog
    $(document).on('click', '#btnMedia', function() {
        overlay(true);
        $("#mediaBox").fadeIn("fast");
        return false;
    });

    // close the the media dialog
    $(document).on('click', '#btnCloseMedia', function() {
        overlay(false);
        $("#mediaBox").fadeOut("fast");
        return false;
    });
    
    // Upload a file
    $(document).on('click', '.btnUploadSend', function() {
        $file = $('#mediaFile');
        $title = $('#mediaTitle');
        $article = $('#mediaArticle');

        if ($title.val() == "") {
            alert('Please enter a title.');
            return false;
        }
        if ($file.val() == "") {
            alert('Please select a media file.');
            return false;
        }
        
        $.ajaxFileUpload({
            url: '/~api/upload/media', 
            secureuri: false,
            fileElementId: 'mediaFile',
            dataType: 'json',
            data: { 'mediaTitle': $title.val(), 'mediaArticle' : $article.val() },
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
        overlay(false);
        $("#uploadBox").fadeOut("fast");
        return false;
    });

    // Cancel an upload
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
});


