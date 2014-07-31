function emptyList(field) {
	// Set each option to null thus removing it
	$(field).empty();
}

function loadDefault(field) {
	// Bind new values to dropdown
	$(field).each(function() {
		// Create option
		var option = $("<option />");
		option.attr("value", '0').text('ui.none');
		$(field).append(option);
	});
}

function updateDependant(field)
{
	valueField = $('#' + field).val();

	$('.fulltextSearch').each(function( index )
	{
		str = $(this).attr('data-relations');
		if (str)
			pos = str.indexOf(field);
		else
			pos = 0;

	  	if (pos > 0)
	  	{
			fulltextId = $(this).attr('data-field');
	  		$(this).val('');
	  		$('#' + fulltextId).val('');
	  		updateDependant(fulltextId);
	  	}
	});			
	$('.ddRelated').each(function( index )
	{
		str = $(this).attr('data-relations');
		if (str)
			pos = str.indexOf(field);
		else
			pos = 0;

	  	if (pos > 0)
	  	{
	  		idField = $(this).attr('id');
	  		table = $(this).attr('data-relations');
			position = table.indexOf(":");
			table = table.substr(0, position);
	  		// First we clear the dropdown
			emptyList('#' + idField);
			loadDefault('#' + idField);
	  		// Update values from Database
	  		if (valueField)
	  		{
		  		options = $('#' + idField);
		  		$.getJSON("updateDropDown?table="+table+"&field="+field+"&value="+valueField+'&idField='+idField, function(data){
				  $.each(data, function() {
				    options.append($('<option></option>').val(this.id).text(this.value));
				  });
				});
			}
			fulltextId = $(this).attr('data-field');

			// Continue updating
	  		updateDependant(fulltextId);
	  	}
	});			
}

var fulltextTableName = '';
var fulltextId = '';
var filterFields = '';

// If you are deleting the description of the field, delete the id too
$('.fulltextSearch').blur( function(event)
{
	if (($(this).val().trim()) == '')
	{
		fulltextId = $(this).attr('data-field');
		$('#' + fulltextId).val('');
		$(this).val('');
		// Look for dependant fields and delete those too
		updateDependant(fulltextId);
		// $('.selectpicker').selectpicker('refresh');
	}
});

$('#addressAssistant').change( function(event)
{
	var control = $(this).find(":selected");

	if (control.attr('data-vicinity'))
	{
		$('#addresses').val(control.attr('data-vicinity'));
		$('#id_address').val(control.attr('value'));
		$('#contacts').val('');
		if (control.attr('data-name') == 'This location')
		{
			$('#businesses').val('');
			$('#id_business').val('');
			$('#businessDescription').val('');
		}
		else	
		{
			$('#businesses').val(control.attr('data-name'));
			$('#id_business').val(control.attr('data-business'));
			$('#businessDescription').val(control.attr('data-types'));
		}
	}
	else
	{
		$('#addresses').val('');
		$('#businesses').val('');
		$('#contacts').val('');
		$('#id_business').val('');
		$('#id_address').val('');
		$('#businessDescription').val('');
	}
});

// If you are modifying the description of the field, delete the id too
$('.fulltextSearch').change( function(event)
{
	if ($('#' + $(this).attr('data-field')).data('lastValue') != $(this).val())
	{
		fulltextId = $(this).attr('data-field');
		$('#' + fulltextId).val('');
		//$(this).val('');
		// Look for dependant fields and delete those too
		updateDependant(fulltextId);
		// $('.selectpicker').selectpicker('refresh');
	}
});

// $('.ddRelated .selectpicker').focus( function(){
// 	$('.selectpicker').selectpicker('refresh');
// });


$('div.form-group input.form-control').click( function(event)
{
	fulltextTableName = $(this).attr('name');
	fulltextId = $(this).attr('data-field');
	filterFields = $(this).attr('data-relations');
	if (typeof fulltextId === 'undefined' || typeof filterFields === 'undefined')
	{
		filterFields = '';
	}
	else
	{
		arrayFilterFields = filterFields.split(",");
		filterFields = '?';
		var str, pos;
		var i=0, len=arrayFilterFields.length;
		for (; i<len; )
		{
			str = arrayFilterFields[i];
			pos = str.indexOf(":");
			field = str.substr(pos + 1);
			table = str.substr(0, pos);
			val = $('#' + field).val();
	  		//console.log( field + ": " + val);
			if (val < 1)
				val = 0; 
			if (i>0)
			{
				filterFields = filterFields + '&';
			}
			filterFields = filterFields + field + '=' + table + '-' + val;
				i++;
		}
	}
});

$(".fulltextSearch").autocomplete({
	source: function(request, response)
	{
		$.getJSON("fulltextSearch" + filterFields, {
			 		table: fulltextTableName,
			 		term: extractLast( request.term ),
			 		type: 'default'
			 }, 
          response);
	}, 
		select: function(event, ui) {
			$('#' + fulltextId).val(ui.item.id);
			$('#' + fulltextId).data("lastValue", ui.item.value);
			updateDependant(fulltextId);
		},
	minLength: $('#_minCharactersAutocomplete').val()
});

$( document ).ready(function() {
	$('.ddRelated').each(function( index )
	{
		var x = $(this).val();
		//alert(x);
  		dataRelations = $(this).attr('data-relations');
  		if (dataRelations)
  		{
			position = dataRelations.indexOf(":");
			table = dataRelations.substr(0, position);
			field = dataRelations.substr(position+1);
			str = $(this).attr('data-relations');
			if (str)
				pos = str.indexOf(field);
			else
				pos = 0;

		  	if (pos > 0)
		  	{
		  		idField = $(this).attr('id');
				valueField = $('#' + field).val();

		  		// First we clear the dropdown
				emptyList('#' + idField);
				loadDefault('#' + idField);
		  		// Update values from Database
		  		if (valueField)
		  		{
			  		options = $('#' + idField);
			  		$.getJSON("updateDropDown?table="+table+"&field="+field+"&value="+valueField+'&idField='+idField, function(data){
					  $.each(data, function() {
					    options.append($('<option></option>').val(this.id).text(this.value));
					  });
					});
				}
		  	}
		 //  	alert(x);
			// $(this).val(x);
			// alert($(this).val());
//			.change();
		}
	});			
});	