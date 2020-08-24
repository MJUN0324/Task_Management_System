const myPass = document.querySelector('#password');
const myMsg = document.querySelector('.msg');
const submitBtn = document.querySelector('#submit');

const characters = document.getElementById('characters');
const uppercase = document.getElementById('uppercase');
const lowercase = document.getElementById('lowercase');
const number = document.getElementById('numbers');
//const punctuation = document.getElementById('punctuation');

myPass.onkeyup = function() { passwordCheck() }

function passwordCheck() {
    var lowerCaseLetters = /[a-z]/g;
    var upperCaseLetters = /[A-Z]/g;
    var numbers = /[0-9]/g;
    //var punctuations = /[.,:!?@#$%]/g;

    var lengthPass;
    var upperCasePass;
    var lowerCasePass;
    var numberPass;

    // Validate length
    if (myPass.value.length >= 8) {
        myMsg.innerText = '';
        characters.style.color = 'green';
        //myPass.style.borderColor = 'green';
        characters.classList.remove("invalid");
        characters.classList.add("valid");
        lengthPass = true;
    } 
    else {
        characters.style.color = 'red';
        myMsg.innerText = 'Too Short';
        myMsg.style.color = '#CCC';
        characters.classList.remove("valid");
        characters.classList.add("invalid");
        lengthPass = false;
    }

    // Validate uppercase letters
    if (myPass.value.match(upperCaseLetters)) {
        uppercase.style.color = 'green';
        uppercase.classList.remove("invalid");
        uppercase.classList.add("valid");
        upperCasePass = true;
    } 
    else {
        uppercase.style.color = 'red';
        uppercase.classList.remove("valid");
        uppercase.classList.add("invalid");
        upperCasePass = false;
    }

    // Validate lowercase letters
    if (myPass.value.match(lowerCaseLetters)) {
        lowercase.style.color = 'green';
        lowercase.classList.remove("invalid");
        lowercase.classList.add("valid");
        lowerCasePass = true;
    }
    else {
        lowercase.style.color = 'red';
        lowercase.classList.remove("valid");
        lowercase.classList.add("invalid");
        lowerCasePass = false;
    }

    // Validate numbers
    if (myPass.value.match(numbers)) {
        number.style.color = 'green'
        number.classList.remove("invalid");
        number.classList.add("valid");
        numberPass = true;
    } 
    else {
        number.style.color = 'red';
        number.classList.remove("valid");
        number.classList.add("invalid");
        numberPass = false;
    }

    /*
    // Validate punctuations
    if (myPass.value.match(punctuations)) {
        punctuation.style.color = 'green'
        punctuation.classList.remove("invalid");
        punctuation.classList.add("valid");
    } else {
        punctuation.style.color = 'red';
        punctuation.classList.remove("valid");
        punctuation.classList.add("invalid");
    }
    */

    // Reset All Form
    if (myPass.value.length == 0) {
        myMsg.innerText = '';
        myPass.style.borderColor = 'red';
    }

    if(lengthPass && upperCasePass && lowerCasePass && numberPass) {
        myPass.style.borderColor = 'green';
        submitBtn.disabled = false;
    }
    else {
        myPass.style.borderColor = 'red';
        submitBtn.disabled = true;
    }
}

// Fire a keyup event when page load
var e = document.createEvent('HTMLEvents');
e.initEvent("keyup", false, true);
myPass.dispatchEvent(e);