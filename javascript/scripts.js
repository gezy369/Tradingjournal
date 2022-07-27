/* ----------------------------------------------------------------------------------------
Sets the cells to editable with a click on a button.
  Then display a save button to lock the values
----------------------------------------------------------------------------------------- */

//https://stackoverflow.com/questions/23572428/making-row-editable-when-hit-row-edit-button
//Function to set the input to editable or readonly
$(document).ready(function () {
    $('.editbtn').click(function () {
        var ClickedBtn = (this.id);
        var EditSaveBtn = document.getElementById(ClickedBtn);  //takes the clicked button ID
        var currentTBODY = $(this).parents('tbody').find('input[type="number"], textarea');   //looks for inputs in the current tbody of the table
        if ($(this).html() == 'Edit') {                  
            $.each(currentTBODY, function () {
                $(this).prop("readonly",false);                 //sets inputs not readonly
                EditSaveBtn.setAttribute('type', 'button');     //avoid the sending of the form after the click of the button
            });
        } else {
           $.each(currentTBODY, function () {
                $(this).prop("readonly",true);                  //sets inputs readonly
                EditSaveBtn.setAttribute('type', 'submit');     //allows the form to be sent with the submit button type
            });
        }
        $(this).html($(this).html() == 'Edit' ? 'Save' : 'Edit')
    });
});

// ----------------------------------------------------------------------------------- //
// opens the popup widows
// ----------------------------------------------------------------------------------- //

function openFormCreate() {
  document.getElementById("popupFormCreate").style.display = "block";
}

function closeFormCreate() {
  document.getElementById("popupFormCreate").style.display = "none";
}

function openFormManage() {
document.getElementById("popupFormManage").style.display = "block";
}

function closeFormManage() {
document.getElementById("popupFormManage").style.display = "none";
}

