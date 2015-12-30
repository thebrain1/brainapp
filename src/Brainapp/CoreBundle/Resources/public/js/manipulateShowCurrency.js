$(document).ready(function() {
	$('.data-currency').each(function() {
		var value = $(this).html()
		                   .replace(".", ",");
		
		var localResult = "";
		
		var localValue = value.replace("-","");
		
		var digitCount = 0;
		
		for (var i = localValue.length - 1, e = 0; i >= e; i--)
		{
			var character = localValue[i]
			localResult = character + localResult;
			
			digitCount += 1; 
			
			if(digitCount == 3 && i > e)
			{
				if(character != "," && character != ".")
				{
					localResult = "." + localResult;
				}
			}
			
			if(digitCount == 3 || character == "," || character == "." )
			{
				digitCount = 0;
			}
		}

		if($(this).attr("class")
			      .indexOf("data-balance") >= 0)
		{
			var htmlExtensionColor = "";
			
			localResult = localResult.replace("+","")
			                         .replace("-","")
			                         .trim();
							
			if(value.replace(",",".") < 0)
			{
				htmlExtensionColor = "red";
				
				localResult = "-" + localResult
			}
			else
			{
				htmlExtensionColor = "green";
				localResult = "+" + localResult
			}
			
			localResult = '<font color="' + htmlExtensionColor + '"><b>' + localResult + ' &euro;</b></font>';
		}
		else
		{
			localResult = localResult + ' &euro;';
		}
		
		$(this).html(localResult);
	});
});