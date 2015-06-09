
// fix for IE stupidity

if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function(value, start) {
		var i;
		if (!start) {
			start = 0;
		}
		for(i=start; i<this.length; i++) {
			if(this[i] == value) {
				return i;
			}
		}
	return -1;
	}
}


function rssimportToggle(id){
	var mctoggle = 0;
	var length = idarray.length;
	
	// see if our comment is in the array or not
    for(var i = 0; i < length; i++) {
        if(idarray[i] == id){
        	mctoggle = 1;
        }
    }
    
    if(mctoggle == 1){
    	// need to remove from array
    	var idx = idarray.indexOf(id); // Find the index
    	if(idx!=-1) idarray.splice(idx, 1);
    }
    else{
    	// need to add to array
    	idarray.push(id);
    }
    
    //now we assign the new value to the input
	document.getElementById("rssimportImport").value = idarray;
	//document.getElementById("rssimportBlacklist").value = idarray;
}

function rssimportCheckAll(){
	//get array all of the checkboxes
	var total = document.getElementsByName('rssmanualimport');
	idarray = new Array();
	for(var i=0; i<total.length; i++){
		idarray.push(total[i].value);
	}
	
	for(i=0; i<total.length; i++){
		total[i].checked = true ;
	}
	
	//now we assign the new value to the input
	document.getElementById("rssimportImport").value = idarray;
	//document.getElementById("rssimportBlacklist").value = idarray;
}

function rssimportCheckNone(){
	//get array all of the checkboxes
	var total = document.getElementsByName('rssmanualimport');
	idarray = new Array();
	
	for(i=0; i<total.length; i++){
		total[i].checked = false ;
	}
	
	//now we assign the new value to the input
	document.getElementById("rssimportImport").value = idarray;
	//document.getElementById("rssimportBlacklist").value = idarray;
}

function rssimportToggleExcerpt(id){
	var contentid = '#rssimport_content' + id;
	var excerptid = '#rssimport_excerpt' + id;
	$(contentid).toggle(0, function() { });
	$(excerptid).toggle(0, function() { });
}

function rssimportToggleChecked(){
	if(document.getElementById("rssimport-checkalltoggle").checked == true){
		rssimportCheckAll();
	}
	else{
		rssimportCheckNone();
	}
}


// jquery fun

$(document).ready( function() {
  $('.rssimport-formtoggle').click( function(event) {
    event.preventDefault();
  	$('#createrssimportform').slideToggle();
	});

	$('.rssimport_toggleupdate').click( function(event) {
    event.preventDefault();
  	$('#rssimport_updateform').slideToggle();
	});

  $('#rssimport-checkalltoggle').click( function(event) {
    rssimportToggleChecked();
  });
  
  $('input.rssimport-checkbox-active').click( function(event) {
    rssimportToggle($(this).val());
  });
  
  $('.rssimport-excerpt-toggle').click( function(event) {
    rssimportToggleExcerpt($(this).attr('rel'));
  });
  
  $('input.rssimport-checkbox-disabled').attr("disabled", true);
});