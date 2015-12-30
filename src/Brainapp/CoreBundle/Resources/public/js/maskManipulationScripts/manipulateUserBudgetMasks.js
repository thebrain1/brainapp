var CREATE_USER_BUDGET_FORM_ID = "createUserBudgetForm";
var EDIT_USER_BUDGET_FORM_ID = "editUserBudgetForm";
var NO_SELECTED_PERIOD = "NO_SELECTED_PERIOD";
var NO_SELECTED_TRIGGER_DATE = "NO_SELECTED_TRIGGER_DATE";


//TODO Auswahl von Kategorie(n) und einem Account Pflicht
//EVENT FUNKTIONEN
$(document).ready(function() {
	$("#btn-add-userBudgetVorlage").on('click',function() {
		var formFieldSelectionResetPeriod = getFormFieldByFormNameAndId(CREATE_USER_BUDGET_FORM_ID,"resetPeriod");
		formFieldSelectionResetPeriod.value = NO_SELECTED_PERIOD;
		
		//TODO: SELEKTIEREN VON STANDARDKONTEN
		
		toggleFormFields(CREATE_USER_BUDGET_FORM_ID,true,NO_SELECTED_PERIOD);
	});
	
	$('.btn-edit-budgetvorlage').on('click', function() {
		
	    var budgetVorlageId = $(this).attr('data-budgetvorlageid');
	    
	    var formFieldBudgetVorlageId =  getFormFieldByFormNameAndId(EDIT_USER_BUDGET_FORM_ID,"id");
	    formFieldBudgetVorlageId.value = budgetVorlageId;

	    var FORM_ID = EDIT_USER_BUDGET_FORM_ID + "_";
	    const FORM_FIELDS = new Array("budgetName",	"category","account","budgetComment","budgetValue");
	    
		$.ajax({
			url: $(this).attr('action'),
			async: false,
			
		    complete: function (response) {
		    	  var dataResponseText = response.responseText;
		    	  var data = JSON.parse(dataResponseText);		    	  
		    	  
		    	  toggleFormFields(EDIT_USER_BUDGET_FORM_ID,false,data["resetPeriod"]);

		    	  for(i = 0; i < FORM_FIELDS.length; i++)
		    	  {
		    		  $("#" + FORM_ID + FORM_FIELDS[i]).val(data[FORM_FIELDS[i]]);
		    	  }
		   		    	  
		    	  var periodSelect = document.getElementById(FORM_ID + "resetPeriod");
		    	  var triggerDateSelect = document.getElementById(FORM_ID + "resetTriggerDate");

		    	  periodSelect.value = data["resetPeriod"];
		    	  triggerDateSelect.value = data["resetTriggerDate"];
		    	  
		    	  getFormFieldByFormNameAndId(EDIT_USER_BUDGET_FORM_ID,"save").removeAttribute('disabled');
		      },
		    error: function () {
		         alert('Es ist ein unbekannter Fehler aufgetreten.');
		         throw "Es ist ein unbekannter Fehler aufgetreten.";
		    }
		});
	});
	
	$('.btn-delete-budgetvorlage').on('click', function() {
		var budgetVorlageId = $(this).attr('data-budgetvorlageid');
		var budgetVorlageName = $(this).attr('data-budgetVorlageName');
		$('input[name="#ff_budgetVorlageId"]').val(budgetVorlageId);
		$('#modalMaskDeleteBudgetVorlage_budgetVorlageName').html(budgetVorlageName);
	});
	
	$('.select-resetPeriod').on('change', function() {
		
		var selection = getFormFieldByInstanceAndId(this,"resetPeriod").value;
		var localFormName = this.closest("form").name;
		
		if(selection == NO_SELECTED_PERIOD)
		{
			toggleFormFields( localFormName, true, null );
		}
		else
		{
			toggleFormFields( localFormName, false, selection );
		}
	});
	
	$('.select-resetTriggerDate').on('change', function() {
		toggleSaveButtonState(this.closest("form").name);
	});
});







//ANDERE FUNKTIONEN
function toggleFormFields(formName, setTriggerDateDisabled, selection)
{
	
	if ( $(document).ready() )
	{
		if(setTriggerDateDisabled)
		{
			resetTriggerDateSelection(formName);
		}
		else
		{
			var json_days_of_week = '{"days":[' + 
				'{ "VALUE":1 , "LABEL":"Montag" },' +
				'{ "VALUE":2 , "LABEL":"Dienstag" },' +
				'{ "VALUE":3 , "LABEL":"Mittwoch" },' +
				'{ "VALUE":4 , "LABEL":"Donnerstag" },' +
				'{ "VALUE":5 , "LABEL":"Freitag" },' +
				'{ "VALUE":6 , "LABEL":"Samstag" },' +
				'{ "VALUE":7 , "LABEL":"Sonntag" }' +
			']}';
			
			var json_days_of_month = '{"days":[' + 
				'{ "VALUE":1  , "LABEL":"1" },' +
				'{ "VALUE":2  , "LABEL":"2" },' +
				'{ "VALUE":3  , "LABEL":"3" },' +
				'{ "VALUE":4  , "LABEL":"4" },' +
				'{ "VALUE":5  , "LABEL":"5" },' +
				'{ "VALUE":6  , "LABEL":"6" },' +
				'{ "VALUE":7  , "LABEL":"7" },' +
				'{ "VALUE":8  , "LABEL":"8" },' +
				'{ "VALUE":9  , "LABEL":"9" },' +
				'{ "VALUE":10 , "LABEL":"10"},' +
				'{ "VALUE":11 , "LABEL":"11"},' +
				'{ "VALUE":12 , "LABEL":"12"},' +
				'{ "VALUE":13 , "LABEL":"13"},' +
				'{ "VALUE":14 , "LABEL":"14"},' +
				'{ "VALUE":15 , "LABEL":"15"},' +
				'{ "VALUE":16 , "LABEL":"16"},' +
				'{ "VALUE":17 , "LABEL":"17"},' +
				'{ "VALUE":18 , "LABEL":"18"},' +
				'{ "VALUE":19 , "LABEL":"19"},' +
				'{ "VALUE":20 , "LABEL":"20"},' +
				'{ "VALUE":21 , "LABEL":"21"},' +
				'{ "VALUE":22 , "LABEL":"22"},' +
				'{ "VALUE":23 , "LABEL":"23"},' +
				'{ "VALUE":24 , "LABEL":"24"},' +
				'{ "VALUE":25 , "LABEL":"25"},' +
				'{ "VALUE":26 , "LABEL":"26"},' +
				'{ "VALUE":27 , "LABEL":"27"},' +
				'{ "VALUE":28 , "LABEL":"28"},' +
				'{ "VALUE":29 , "LABEL":"29"},' +
				'{ "VALUE":30 , "LABEL":"30"},' +
				'{ "VALUE":31 , "LABEL":"31"}'  +
			']}';
			
			options = null;
			
			switch(selection)
			{
				case 'WEEKLY':
					options = JSON.parse(json_days_of_week);
					break;
				case 'MONTHLY':
					options = JSON.parse(json_days_of_month);
					break;
				default:
					throw "Fehler: Diese Periode existiert nicht.";
			}
			
			var selectResetTriggerDate = getFormFieldByFormNameAndId(formName,'resetTriggerDate');

			if(options != null)
		    {
				resetTriggerDateSelection(formName);

				$.each(options.days, function( k, val ) {
					selectResetTriggerDate.add(new Option(val.LABEL, val.VALUE));
				});
		    }
			
			selectResetTriggerDate.removeAttribute("disabled");
			toggleSaveButtonState(formName);
		}
	}
}

function resetTriggerDateSelection(formName)
{
	if ( $(document).ready() )
	{
		
		var selectResetTriggerDate = getFormFieldByFormNameAndId(formName,"resetTriggerDate");
		
		selectResetTriggerDate.removeAttribute("disabled");
		selectResetTriggerDate.setAttribute("disabled","disabled");
		
		$(selectResetTriggerDate).empty();
		
		selectResetTriggerDate.add(new Option('nichts ausgewählt', NO_SELECTED_TRIGGER_DATE));
		
		toggleSaveButtonState(formName);
	}
}

function toggleSaveButtonState(formName)
{
	var selectedResetPeriod = getFormFieldByFormNameAndId(formName,"resetPeriod").value;
	var selectedResetTriggerDate = getFormFieldByFormNameAndId(formName,"resetTriggerDate").value;
	
	saveButton = getFormFieldByFormNameAndId(formName,"save");
	
	var disableButton = false;
	
	if(selectedResetPeriod == NO_SELECTED_PERIOD || selectedResetTriggerDate == NO_SELECTED_TRIGGER_DATE)
	{
		disableButton = true;
	}
	
	
	if (disableButton)
	{
		saveButton.setAttribute("disabled","disabled");
	}
	else
	{
		saveButton.removeAttribute("disabled");
	}
}

function getFormFieldByInstanceAndId(instance, id)
{
	var form = instance.closest("form");
	
	result = document.getElementById(form.name + "_" + id);
	
	if(result == null)
	{
		alert("Dieses Formularelement existiert nicht!");
		throw "Dieses Formularelement existiert nicht!";
	}
	
	return result;
}

function getFormFieldByFormNameAndId(formName, id)
{
	result = document.getElementById(formName + "_" + id);
	
	if(result == null)
	{
		alert("Dieses Formularelement existiert nicht!");
		throw "Dieses Formularelement existiert nicht!";
	}
	
	return result;
}