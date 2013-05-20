$(document).ready(function() {

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
	
	
	// Initilize order of sortables
    UpdateListCounts();

	// turn on sortable items
    $(".sortable").sortable({
        placeholder: "ui-state-highlight", 
        update : function(event, ui) {
            UpdateListCounts();
        }
    });
    $(".sortable").disableSelection();
    $(document).on('change', '.sortable > li > select', function(e) {
        UpdateListCounts();
    });
        
    
    // Add to list buttons
    $('#btnAddAttribute').on('click', function(e) {
        $('#tmpAttribute li').clone().appendTo('#lstAttributes');
        UpdateListCounts();
        e.preventDefault();
    });
    $('#btnAddSection').on('click', function(e) {
        $('#tmpSection li').clone().appendTo('#lstSections');
        UpdateListCounts();
        e.preventDefault();
    });
    
    // Edit
   $(document).on('blur', '.inpSection, .inpType, .inpAttribute', function(e) {
        UpdateListCounts();
    });
    
    // Delete
   $(document).on('click', '.btnDelete', function(e) {
        if ($(this).parent().parent().parent().attr('data-can-delete') === 'yes') {
            $(this).parent().parent().parent().remove();
            UpdateListCounts();
        } else {
            alert('This item is in use by at least one page so it can not be removed.');
        }
        e.preventDefault();
    });
});

// Update the order values on the list and
// update the lists json data
function UpdateListCounts() {
    $('.sortable').each(function(index) {
        $(this).find('.listItemContent').each(function(index) {
            $(this).find('.order').text(index + 1);
        });
    });
    UpdateSectionData();
    UpdateAttributeData();
}

// Store the sections list in json
function UpdateSectionData() {
    var data = Array();
    $("#lstSections").each(function(index) {
        $(this).find("li").each(function(index) {
            $(this).children(".order").text(index + 1);
            data[index] = Array(index, 
                                $(this).find(".inpID").val(), 
                                $(this).find(".inpSection").val(), 
                                $(this).find(".inpType").val());
        });
    });
    var dataText = JSON.stringify(data, null, 2);
    $("#templateSections").val(dataText);
}

// Store the attributes list in json
function UpdateAttributeData() {
    var data = Array();
    $("#lstAttributes").each(function(index) {
        $(this).children("li").each(function(index) {
            $(this).find(".order").text(index + 1);
            data[index] = Array(index, 
                                $(this).find(".inpID").val(), 
                                $(this).find(".inpAttribute").val(), 
                                $(this).find(".inpType").val());
        });
    });
    var dataText = JSON.stringify(data, null, 2);
    $("#templateAttributes").val(dataText);
}


