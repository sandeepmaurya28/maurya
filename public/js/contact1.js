var validate;
   validate = function( form ) {





var uname = document.contact_form.username;
var mail = document.contact_form.email;
var subj = document.contact_form.subject;

var mess = document.contact_form.message;
var captcha=document.contact_form.captcha_code.value;
var captchao=document.contact_form.captchaimg;



if(validateuser(uname))
{
 


if(validateemail(mail))
{
if(validatesubject(subj))
{
if(validatemessage(mess))
{
	   if(validatecaptcha(captcha,captchao)){
		form.action = "includes/contactexe.php";
      form.submit();
     // alert("!!!Thank you for Contacting with Us!!!");
  
}
} 
}
}
}return false;

}
 


function validateuser(uname)
{ 
var letters = /^[A-Za-z  ]+$/;
if(uname.value.match(letters))
{
return true;
}
else
{
alert('Name must have alphabet characters only');
uname.focus();
return false;
}
}


function validateemail(mail)
{
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(mail.value.match(mailformat))
{
return true;
}
else
{
alert("You have entered an invalid email address!");
mail.focus();
return false;
}
} 

function validatesubject(subj)
{
var letters = /^[A-Za-z _ -]+$/;

if(subj.value.match(letters)){
	return true;
}
else{
	alert("enter subject !");
	subj.focus();
	return false;
}
}


function validatemessage(mess)
{
var letters = /^[0-9A-Za-z _ .?,";><-]+$/;

if(mess.value.match(letters)){
	return true;
}
else{
	alert("enter message !");
	mess.focus();
	return false;
}
}


function validatecaptcha(captcha,captchao){
	if (captcha=='') {
		alert('Please enter the correct captcha');
		captcha.focus();
		return false;
	}else{
		return true;
	}
}






