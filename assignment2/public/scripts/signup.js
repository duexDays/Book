/*
name : Group7
file name : script.js
created date : 11-14-2024
decription: JavaScript file for Today's Reading sign up page
*/
let emailInput = document.querySelector("#email");
let userNameInput = document.querySelector("#login");
let passInput1 = document.querySelector("#pass");
let passInput2 = document.querySelector("#pass2");
let newsletterInput = document.querySelector("#newsletter");
let termInput = document.querySelector("#terms");

// create paragraph to display the error Msg returented by vaildateEmail() function 
// and assign this paragraph to the class warning to style the error MSg
let emailError = document.createElement('h3');
emailError.setAttribute("class", "warning");
//append the created element to the parent of email div
document.querySelectorAll(".textfield")[0].append(emailError);

// create paragraph to display the error Msg returented by vaildateUserName() function 
// and assign this paragraph to the class warning to style the error MSg
let userNameError = document.createElement('h3');
userNameError.setAttribute("class", "warning");
//append the created element to the parent of email div
document.querySelectorAll(".textfield")[1].append(userNameError);

// create paragraph to display the error Msg returented by vaildatePassword() function 
// and assign this paragraph to the class warning to style the error MSg
let passError = document.createElement('h3');
passError.setAttribute("class", "warning");
//append the created element to the parent of email div
document.querySelectorAll(".textfield")[2].append(passError);

// create paragraph to display the error Msg returented by comparePassword() function 
// and assign this paragraph to the class warning to style the error MSg
let pass2Error = document.createElement('h3');
pass2Error.setAttribute("class", "warning");
//append the created element to the parent of email div
document.querySelectorAll(".textfield")[3].append(pass2Error);

// create paragraph to display the error Msg returented by vaildateTerms() function 
// and assign this paragraph to the class warning to style the error MSg
let termError = document.createElement('h3');
termError.setAttribute("class", "warning");
//append the created element to the parent of check div
document.querySelectorAll(".checkbox")[1].append(termError);

//define a global variables
let termsErrorMsg = "X Please accept the terms and conditions.";
let defaultMSg = "";
let emailErrorMsg = "X Email address should be non-empty with the format xyx@xyz.xyz.";
let userNameErrorMsg = "X User name should be non-empty, and within 30 characters long.";
let pass1ErrorMsg = "X Password should be at least 8 characters.";
let pass2ErrorMsg = "X Please retype password.";
let newsletterMsg = "If you don't receive the newsletter, check your spam folder.";

//method to validate email
function vaildateEmail() {
    let email = emailInput.value; // access the value of the email
    let regexp = /\S+@\S+\.\S+/; //reg. expression 

    if (regexp.test(email)) { //test is predefiend method to check if the entered email matches the regexp
        error = defaultMSg;
    }
    else {
        error = emailErrorMsg;
    }
    return error;

}

//method to validate user name
function vaildateUserName() {
    let userName = userNameInput.value; // access the value of the user name
    let regexp = /^.{1,29}$/; //reg. expression 
    if (regexp.test(userName)) { //test is predefiend method to check if the entered user name matches the regexp
        error = defaultMSg;
    }
    else {
        error = userNameErrorMsg;
    }
    return error;

}

//method to validate password
function vaildatePassword() {
    let pass1 = passInput1.value; // access the value of the password
    let regexp = /^.{8,}$/; //reg. expression 

    if (regexp.test(pass1)) { //test is predefiend method to check if the entered password matches the regexp
        error = defaultMSg;
    }
    else {
        error = pass1ErrorMsg;
    }
    return error;

}

//method to compare password & re-password
function comparePassword() {
    let pass1 = passInput1.value; // access the value of the password
    let pass2 = passInput2.value; // access the value of the re-password

    if (pass1 == pass2) { //compare if the entered re-password matches the password
        error = defaultMSg;
    }
    else {
        error = pass2ErrorMsg;
    }
    return error;

}
//method to validate the terms 
function validatTerms() {
    if (termInput.checked)
        return defaultMSg;
    else
        return termsErrorMsg;

}
//event handler for submit event
function validate() {
    let valid = true;//global validation 
    let emailValidation = vaildateEmail();
    if (emailValidation !== defaultMSg) {
        emailError.textContent = emailValidation;
        valid = false;
    }
    let userNameValidation = vaildateUserName();
    if (userNameValidation !== defaultMSg) {
        userNameError.textContent = userNameValidation;
        valid = false;
    }
    let pass1Validation = vaildatePassword();
    if (pass1Validation !== defaultMSg) {
        passError.textContent = pass1Validation;
        valid = false;
    }
    let pass2Validation = comparePassword();
    if (pass2Validation !== defaultMSg) {
        pass2Error.textContent = pass2Validation;
        valid = false;
    }
    let termsValidation = validatTerms();
    if (termsValidation !== defaultMSg) {
        termError.textContent = termsValidation;
        valid = false;
    }
    //When you send this data (on successful validation) convert the login name to all lower-case
    if (valid) {
        userNameInput.value.toLowerCase();
    }
    return valid;
};

// empty the text inside the five paragraph when reset
function resetFormError() {
    emailError.textContent = defaultMSg;
    userNameError.textContent = defaultMSg;
    passError.textContent = defaultMSg;
    pass2Error.textContent = defaultMSg;
    termError.textContent = defaultMSg;
}
document.querySelectorAll(".reset")[0].addEventListener("reset", resetFormError);

// // add event listner to the email if you entered correct email,the error paragraph with be empty
emailInput.addEventListener("blur", () => { // arrow function
    let x = vaildateEmail();
    if (x == defaultMSg) {
        emailError.textContent = defaultMSg;
    }
});

// // add event listner to the user name if you entered correct user name,the error paragraph with be empty
userNameInput.addEventListener("blur", () => { // arrow function
    let x = vaildateUserName();
    if (x == defaultMSg) {
        userNameError.textContent = defaultMSg;
    }
});

// // add event listner to the password if you entered correct password,the error paragraph with be empty
passInput1.addEventListener("blur", () => { // arrow function
    let x = vaildatePassword();
    if (x == defaultMSg) {
        passError.textContent = defaultMSg;
    }
});

// // add event listner to the re-password if you entered correct re-password,the error paragraph with be empty
passInput2.addEventListener("blur", () => { // arrow function
    let x = comparePassword();
    if (x == defaultMSg) {
        pass2Error.textContent = defaultMSg;
    }
});

// // add event listner to the terms checkbox if you check the terms box,the error paragraph with be empty
termInput.addEventListener("change", function () {// anonymous function
    if (this.checked) {
        termError.textContent = defaultMSg;
    }
});

// // add event listner to the newsletter checkbox if you check the newsletter box, about possible spam
newsletterInput.addEventListener("change", function () {// anonymous function
    if (this.checked) {
        alert(`${newsletterMsg}\n Please dismiss to continue. `);
    }
});

