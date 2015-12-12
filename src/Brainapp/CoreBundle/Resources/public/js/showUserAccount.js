$(document).ready(function() {
	$('.data-currency').each(function() {
		var value = $(this).html()
		                   .replace(".", ",");;
		
		var localValue = "";
		var digitCount = 0;
				
		for (var i = value.length - 1, e = 0; i >= e; i--)
		{
			var character = value[i]
			localValue = character + localValue;
			
			digitCount += 1; 
			
			if(digitCount == 3 && i > e)
			{
				if(character != "," && character != ".")
				{
					localValue = "." + localValue;
				}
				digitCount = 0;
			}
		}

		if($(this).attr("class")
			      .indexOf("data-accountBalance") >= 0)
		{
			var htmlExtensionColor = "";
			
			localValue = localValue.replace("+","")
			                       .replace("-","")
			                       .trim();
			
			if(value < 0)
			{
				htmlExtensionColor = "red";
				
				localValue = "-" + localValue
			}
			else
			{
				htmlExtensionColor = "green";
				localValue = "+" + localValue
			}
			
			localValue = '<font color="' + htmlExtensionColor + '"><b>' + localValue + '</b></font>';
		}
		
		$(this).html(localValue + " &euro;");
	});
});