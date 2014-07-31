var server = "http://" + $(location).attr('host') + "/";

function split( val ) 
{
  return val.split( /,\s*/ );
}
function extractLast( term )
{
  return split( term ).pop();
}

function changeMethodTo(process) {
    var str = "znerg/public/tasks/" + process + "?mode=edit";
    str = server.concat(str);
    document.getElementsByName("modelForm")[0].setAttribute("action",str);
    document.getElementsByName("modelForm")[0].setAttribute("method","POST");
    document.getElementsByName("_method")[0].setAttribute("value","POST");
    document.modelForm.submit();
}

function changeMethodToDelete() {
    document.getElementsByName("_method")[0].setAttribute("value","DELETE");
}

function changeMethodToCreate(id_structure, fieldName, mode)
 {
  var str; 
  relations = $('#' + fieldName).attr('data-relations');
  // Got through each dependency
  if (relations)
  {
    relationsArray = relations.split(',');
    var i;
    var error = false;
    for (i = 0; i < relationsArray.length; i++)
    {
      pos = relationsArray[i].indexOf(':');
      relation = relationsArray[i].substr(pos + 1);
      $('.fulltextSearch').each(function( index )
      {
        str = $(this).attr('data-field');
        // if there is a field that it depends upon
        if (str == relation)
        {
          value = $('#' + str).val().length;
          if (!value)
          {
            alert("Unable to create the field selected because it needs a dependant field");
            error = true;
            return false;
          }
        }
      });     
    }
  }
  if (error)
    return false;
  var str = "znerg/public/tasks/createRelated?id_structure=";
  str = server.concat(str);
  str = str.concat(id_structure);
  var str2 = "&mode=";
  str = str.concat(str2);
  str = str.concat(mode);
  document.getElementsByName("modelForm")[0].setAttribute("action",str);
  document.getElementsByName("modelForm")[0].setAttribute("method","POST");
    if (mode == 'edit')
      document.getElementsByName("_method")[0].setAttribute("value","POST");
  document.modelForm.submit();
}

function changeMethodToEdit(id_structure, fieldValue, mode) {
  if (fieldValue.value > 0)
  {
    var str = "znerg/public/tasks/editRelated?id_structure=";
    str = server.concat(str);
    str = str.concat(id_structure);
    var str1 = "&fieldValue=";
    str = str.concat(str1);
    str = str.concat(fieldValue.value);
    var str2 = "&mode=";
    str = str.concat(str2);
    str = str.concat(mode);
    document.getElementsByName("modelForm")[0].setAttribute("action",str);
    document.getElementsByName("modelForm")[0].setAttribute("method","POST");
    if (mode == 'edit')
      document.getElementsByName("_method")[0].setAttribute("value","POST");
    document.modelForm.submit();
  }
  else
  {
    alert("Unable to update the field selected");
    return false;
  }
}

function changeMethodToDestroy(id_structure, fieldValue, id_field, mode) {
  if (fieldValue.value > 0)
  {
    var str = "znerg/public/tasks/destroyRelated?id_structure=";
    str = server.concat(str);
    str = str.concat(id_structure);
    var str1 = "&fieldValue=";
    str = str.concat(str1);
    str = str.concat(fieldValue.value);
    var str2 = "&id_field=";
    str = str.concat(str2);
    str = str.concat(id_field);
    document.getElementsByName("modelForm")[0].setAttribute("action",str);
    document.getElementsByName("modelForm")[0].setAttribute("method","POST");
    if (mode == 'edit')
      document.getElementsByName("_method")[0].setAttribute("value","POST");
    document.modelForm.submit();
  }
  else
  {
    alert("Unable to delete the field selected");
    return false;
  }
}

function ddField()
{
  document.searchForm.submit();
}
function showConfirm(text)
{
  var resp = confirm(text);
  if (!resp)
    return false;
}
function ddFilter()
{
  document.filterForm.submit();
}

function printArea()
{
  var divToPrint=document.body.innerHTML;
  newWin= window.open("");
  newWin.document.write(divToPrint);
  newWin.print();
  newWin.document.close();
}

// All button of class sameSizeButton get the size of the largest button in the group
$('td a.sameSizeButton:visible').width(
    Math.max.apply(
        Math,
        $('td a.sameSizeButton:visible').map(function(){
            return $(this).outerWidth();
        }).get()
    )
);

// $('.popover1').popover();  

$('html').click(function(e) {
    $('.popover1').popover('hide');
});

var lastPopover = "";

$('.popover1').popover({
    html: true,
    trigger: 'manual'
}).click(function(e) {
     e.stopPropagation();
    if (lastPopover == $(this).attr('id'))
    {
      lastPopover = ""; 
      $(this).popover('hide');
    }
    else
    {
      $(this).popover('show');
      lastPopover = $(this).attr('id');
    }
    //$(this).popover('toggle');
//     //alert('#' + $(this).attr('id'));
//     //e.stopPropagation();
//     // $('body').animate({
//     //     scrollTop: $("#" + $(this).attr('id')).offset().top
//     // }, 2000);
     return false;    
 });

$('input').click(function (event) {
    if ($(this).hasClass('disabled')) {
        this.className = 'no-padding enabled form-control'
    }
});

$('input').blur(function (event) {
    if ($(this).hasClass('enabled')) {
        this.className = 'no-padding disabled form-control'
        var $tab = $('#myTabContent'), $active = $tab.find('.tab-pane.active'), text = $active.attr('id');
        //text = text.substr(3, text.length - 3);

        //document.getElementsByName("id_category")[0].setAttribute("value", text);        
        this.form.submit();
    }
}); 

$('.selectpicker1').selectpicker();

$(document).ready(function(){
    if ($('#activateRolesModal').val() == 'Yes')
      $('#rolesModal').modal('show');

    if ($('#activatePasswordModal').val() == 'Yes')
      $('#passwordModal').modal('show');

    if ($('#activateUsersModal').val() == 'Yes')
      $('#usersModal').modal('show');

    if ($('#activateLocationsModal').val() == 'Yes')
      $('#locationsModal').modal('show');

    if ($('#activateEditLocationsModal').val() == 'Yes')
      $('#locationsEditModal').modal('show');

    if ($('#activateContactsBusinessesModal').val() == 'Yes')
      $('#contactsBusinessesModal').modal('show');

    if ($('#activateEditContactsBusinessesModal').val() == 'Yes')
      $('#contactsBusinessesEditModal').modal('show');

    $('.sameSizeButton:visible').width(
        Math.max.apply(
            Math,
            $('.sameSizeButton:visible').map(function(){
                return $(this).outerWidth();
            }).get()
        )
    );
}); 

