function initForms() {
	for (var i=0; i< document.forms.length; i++) {
		document.forms[i].onsubmit = function() {return validForm();}
	}
}

function validForm() {
	var allGood = true;
	var allTags = document.getElementsByTagName("*");

	for (var i=0; i<allTags.length; i++) {
		if (!validTag(allTags[i])) {
			allGood = false;
		}
	}
	return allGood;

	function validTag(thisTag) {
		var outClass = "";
		var allClasses = thisTag.className.split(" ");
	
		for (var j=0; j<allClasses.length; j++) {
			outClass += validBasedOnClass(allClasses[j]) + " ";
		}
	
		thisTag.className = outClass;
	
		if (outClass.indexOf("invalid") > -1) {
			invalidLabel(thisTag.parentNode);
			thisTag.focus();
			if (thisTag.nodeName == "INPUT") {
				thisTag.select();
			}
			return false;
		}
		return true;
		
		function validBasedOnClass(thisClass) {
			var classBack = "";
		
			switch(thisClass) {
				case "":
				case "invalid":
					break;
				case "email":
					if (allGood && !validEmail(thisTag.value)) classBack = "invalid ";
				case "reqd":
					if (allGood && thisTag.value == "") classBack = "invalid ";
					classBack += thisClass;
					break;
				default:
					classBack += thisClass;
			}
			return classBack;
		}
				
		function validEmail(email) {
			var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

			return re.test(email);
		}
		
		function invalidLabel(parentTag) {
			if (parentTag.nodeName == "LABEL") {
				parentTag.className += " invalid";
			}
		}
	}
}

////////////////////////////////////


function initForms2() {
	for (var i=0; i< document.forms.length; i++) {
		document.forms[i].onsubmit = function() {return validForm2();}
	}
}

function validForm2() {
	var allGood = true;
	var allTags = document.getElementsByTagName("*");

	for (var i=0; i<allTags.length; i++) {
		if (!validTag2(allTags[i])) {
			allGood = false;
		}
	}
	return allGood;

	function validTag2(thisTag) {
		var outClass = "";
		var allClasses = thisTag.className.split(" ");
	
		for (var j=0; j<allClasses.length; j++) {
			outClass += validBasedOnClass2(allClasses[j]) + " ";
		}
	
		thisTag.className = outClass;
	
		if (outClass.indexOf("invalid") > -1) {
			invalidLabel(thisTag.parentNode);
			thisTag.focus();
			if (thisTag.nodeName == "INPUT") {
				thisTag.select();
			}
			return false;
		}
		return true;
		
		function validBasedOnClass2(thisClass) {
			var classBack = "";
		
			switch(thisClass) {
				case "":
				case "invalid":
					break;
				case "email2":
					if (allGood && !validEmail2(thisTag.value)) classBack = "invalid ";
				case "reqd2":
					if (allGood && thisTag.value == "") classBack = "invalid ";
					classBack += thisClass;
					break;
				default:
					classBack += thisClass;
			}
			return classBack;
		}
				
		function validEmail2(email) {
			var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

			return re.test(email);
		}
		
		function invalidLabel(parentTag) {
			if (parentTag.nodeName == "LABEL") {
				parentTag.className += " invalid";
			}
		}
	}
}

