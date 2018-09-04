function myfunc(arrayString, arrayNumbers){
	var result = 'array(';
	for(var i = 0; i<arrayNumbers.length; i++){
		result += 'array(';
		for(var j = 0; j < arrayNumbers[i]; j++){
			result+= "'" + arrayString.shift() + "', ";
        }
		result += '), ';
    }
	result = result.slice(0, -2);
	result+='),';
	copyTextToClipboard(result);
	return result;
}

function manyArgs() {
    var result = '';
      for (var i = 0; i < arguments.length; ++i){
        result += '"' + arguments[i]+'", ';
      }
        result = result.substring(0, result.length - 2);
        copyTextToClipboard("array("+result+"),\n");
    }

    function fallbackCopyTextToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
      
        try {
          var successful = document.execCommand('copy');
          var msg = successful ? 'successful' : 'unsuccessful';
          console.log('Fallback: Copying text command was ' + msg);
        } catch (err) {
          console.error('Fallback: Oops, unable to copy', err);
        }
      
        document.body.removeChild(textArea);
      }
      function copyTextToClipboard(text) {
        if (!navigator.clipboard) {
          fallbackCopyTextToClipboard(text);
          return;
        }
        navigator.clipboard.writeText(text).then(function() {
          console.log('Async: Copying to clipboard was successful!');
        }, function(err) {
          console.error('Async: Could not copy text: ', err);
        });
      }