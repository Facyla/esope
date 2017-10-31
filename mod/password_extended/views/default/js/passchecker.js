
$(document).ready(function() {
    var password1       = $('#password'); //id of first password field
    if(!password1.length){
        var password1       = $('#password1'); //id of first password field
    }
    var password2       = $('#password2'); //id of second password field
    var passwordsInfo   = $('#pass-info'); //id of indicator element

    passwordStrengthCheck(password1,password2,passwordsInfo); //call password check function

});
