$(document).ready(function() {
	var canvasElements = document.getElementsByClassName("canvasBudgetBalance");
	
//	var widthGesamt = $(canvasElements[0]).width();
//	var heightGesamt = 500;
	
	for(var i = 0; i <= canvasElements.length ; i++)
	{
		var canvasElement = canvasElements[i];

		var widthGesamt = canvasElement.width;
		var heightGesamt = canvasElement.height;
		
		var ctx = canvasElement.getContext("2d");
		
		var budgetWert = $(canvasElement).attr('data-budgetVorlageValue');
		var verbraucht = (-1) * $(canvasElement).attr('data-budgetVerbraucht');
		
		var widthVerbraucht = widthGesamt * (1/budgetWert) * verbraucht;
		var withVerbleibend = widthGesamt-widthVerbraucht;
		
		//VERBRAUCH
		ctx.fillStyle="red";
		ctx.fillRect(0, 0, widthVerbraucht, heightGesamt);
		ctx.stroke();
		ctx.strokeStyle="000";
		ctx.lineWidth   = 2;
		ctx.strokeRect(0, 0, widthVerbraucht, heightGesamt);
	
		//VERBLEIBEND
		ctx.fillStyle="green";
		ctx.fillRect(widthVerbraucht, 0, withVerbleibend, heightGesamt);
		ctx.stroke();
		ctx.strokeStyle="000";
		ctx.lineWidth   = 2;
		ctx.strokeRect(widthVerbraucht, 0, withVerbleibend, heightGesamt);
	}
});