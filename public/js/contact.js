


function userid_valid(){
	var name=document.contact_form.username.value;
	if(name.length<1){  

/*document.getElementById("nameloc").innerHTML=  
"Please enter your name"; */
alert("Please enter your name"); 
username.focus();

return false;  

}else{  
 
return true;  
} 
}

 
function email_valid(){

var mail=document.contact_form.email.value;
	/*var atposition=email.indexOf("@");  
var dotposition=mail.lastIndexOf(".");  
if (atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length){  
   
  //document.getElementById("emailloc").innerHTML= "Please enter a valid e-mail address "; 
  alert("Please enter a valid e-mail address"); 
  return false;
}
else{
	return true;
}*/
mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if (mail.match(mailformat)) {
	return true;
}else
{
	alert("invalid email format");
	email.focus();
	return false;

}

}


function subject_valid(){
	var subject =document.contact_form.subject.value;
	var letters = /^[A-Za-z _ -]+$/;
if(subject.match(letters))
	{
		return true;
	}
	else{

 //document.getElementById("subjectloc").innerHTML= "Only alphabets,underscore  and  spaces are allowed "; 
 alert('Only alphabets,underscore  and  spaces are allowed ');
 subject.focus();
 return false;
	}

}



function message_valid(){
	var details=document.contact_form.message.value;
	if(details.length<1){  
/*document.getElementById("messageloc").innerHTML=  
"Please enter your message";  */
alert('Please enter your message');
details.focus();

return false;  

}else{  
 
return true;  
} 
}





 





