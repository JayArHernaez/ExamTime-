//Log in Validation
/*
document.getElementById("login-btn").onclick =function()
{
    var pattern = /^[a-z0-9_]{5,25}$/i; //Regex that accepts numbers,letters,underscore min length=4 max=25 case insensitive
    var pass_ptrn = /^[a-z0-9]{5,25}$/i; 
    var text = document.getElementById("login-uname");
    var pass = document.getElementById("login-pass"); 

    var uname = text.value.trim();
    var error=0;

    if(!(pattern.test(uname)&&pattern.test(pass.value.trim())) )
    {
        error++;
    	//display error message
       document.getElementById("grp-login").style.display = 'block';
       text.focus();
       return;
    }
    if (error<1) {

    };
    //else
    //{
    	
       

    //}
};  
*/

//Registration Validation
document.getElementById("register-btn").onclick = function(){
	//Regex for input 
    var pattern = /^[a-z-]{2,25}$/i;
    var u_ptrn = /^[a-z0-9_]{5,15}$/i;
    var pass_ptrn = /^[a-z0-9]{5,25}$/i;
    var email_ptrn = /^[a-z0-9][a-z0-9._]+@[a-z0-9]+.[a-z0-9.]+$/i;
    var studno_ptrn = /^[12][0-9]{3}-[0-9]{5}$/;
    var emp_ptrn = /^[0-9]{10}$/;

    var first = document.getElementById("reg-first");
    var last = document.getElementById("reg-last");
    var uname = document.getElementById("reg-uname");
    var acct = document.getElementById("reg-acct");
    var email = document.getElementById("reg-email");
    var pass = document.getElementById("reg-pass");
    var rpass = document.getElementById("reg-rpass");
    
    var error = 0;

    //check for the first and last name
    if(!pattern.test(first.value.trim())){
    	//display error message
       document.getElementById("grp-name").style.display = 'block';
       error++;
       first.focus();
       return;
    }else{
    	document.getElementById("grp-name").style.display = 'none';
    }
    if(!pattern.test(last.value.trim())){
        //display error message
       document.getElementById("grp-name").style.display = 'block';
       error++;
       last.focus();
       return;
    }else{
        document.getElementById("grp-name").style.display = 'none';
    }

    //username validation
    if(!u_ptrn.test(uname.value.trim())){
    	document.getElementById("grp-uname").style.display = 'block';
    	error++;
    	uname.focus();
    	return;
    }else{
    	document.getElementById("grp-uname").style.display = 'none';
    }
    //Account type validation
    var selected = acct.options[acct.selectedIndex].value.trim();
    if (selected=="act") {
    	document.getElementById("grp-acct").style.display = 'block';
    	error++;
    	acct.focus();
    	return;
    }else if(selected==="Instructor"){
    	//Employee number checking
    	var empno = document.getElementById("reg-empno");
    	if(!emp_ptrn.test(empno.value.trim())){
    		document.getElementById("grp-acct").style.display = 'block';
    		error++;
    		empno.focus();
    		return;
    	}else{
    		document.getElementById("grp-acct").style.display = 'none';
    	};
    }else if(selected==="Student"){
    	//Student number checking
    	var studno = document.getElementById("reg-studno");
    	if(!studno_ptrn.test(studno.value.trim())){
    		document.getElementById("grp-acct").style.display = 'block';
    		error++;
    		studno.focus();
    		return;
    	}else{
    		document.getElementById("grp-acct").style.display = 'none';
    	};
    };

    //email validation
    if(!email_ptrn.test(email.value.trim())){
    	document.getElementById("grp-email").style.display = 'block';
    	error++;
    	email.focus();
    	//return;
    }else{
    	document.getElementById("grp-email").style.display = 'none';
    }

    //password validation
    if(!pass_ptrn.test(pass.value.trim())){
    	document.getElementById("grp-pass").style.display = 'block';
    	error++;
    	pass.focus();
    	return;
    }else{
    	document.getElementById("grp-pass").style.display = 'none';
    }

    //Re-enter password checking
    if(!(rpass.value.trim()===pass.value.trim())){
    	document.getElementById("grp-rpass").style.display = 'block';
    	error++;
    	rpass.focus();
    	return;
    }else{
    	document.getElementById("grp-rpass").style.display = 'none';
    }

    if(error<1)
    {
        document.getElementById("register-form").submit();
        return true;
    }else{
        return false;
    }
    
};  
