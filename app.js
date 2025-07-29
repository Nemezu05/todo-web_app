function validatePassword(){
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const errorMsg = document.getElementById("errorMsg");

    if( password !== confirmPassword){
        errorMsg.textContent = "Password do not match. please try again.";
        return false; //prevents form from submitting
    }else{
        errorMsg.textContent = "";
        return true; //allows form to submit 
    }
}