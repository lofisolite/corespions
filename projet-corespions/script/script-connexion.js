// variables
let formConnexion = document.getElementById('formConnexion');   
let formMission = document.getElementById('formMission');
let formSpy = document.getElementById('formSpy');
let formTarget = document.getElementById('formTarget');
let formContact = document.getElementById('formContact');
let formHideout = document.getElementById('formHideout');
let formSpeciality = document.getElementById('formSpeciality');
let formTypeOfMission = document.getElementById('formTypeOfMission');

let errorText = document.getElementById('errorMsg');

// REGEX
let nameRegex = /^[a-z]{2,}([-'\s][a-z]+)?$/i;
let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@]{8,}$/;
let stringRegex = /(^[a-z0-9éèàùâêîôûëçëïüÿ\s'\-\.\!\?\,\:\;]+$)/i;
let simpleinputRegex = /(^[a-zéèàùâêîôûëçëïüÿ\s'\-]+$)/i;
// let simpleinputRegex = /([0-9]+)/;
let addressRegex = /(^[a-z0-9éèàùâêîôûëçëïüÿ\s'\-\d]+$)/i;

// function validation input
function validLogin(input, errorText){
  if(input.value === ""){
    errorText.textContent = "";
    return false;
  } else if(nameRegex.test(input.value) == false){
    errorText.textContent = "Le format du login n\'est pas valide."
    return false;
  } else {
    errorText.textContent='';
    return true;
  }
}

function validPassword(input, errorText){
  if(input.value === ""){
    errorText.textContent = "";
    return false;
  } else if(passwordRegex.test(input.value) == false){
    errorText.textContent = "Le format du mot de passe n\'est pas valide."
    return false;
  } else {
    errorText.textContent= '';
    return true;
  }
}

function validString(input, errorText){
  if(input.value === ""){
    errorText.textContent = "";
    return false;
  } else if(stringRegex.test(input.value) == false){
    errorText.textContent = "Le format n\'est pas valide. Il y a des caractères spéciaux."
    return false;
  } else {
    errorText.textContent='';
    return true;
  }
}

function validSimpleString(input, errorText){
  if(input.value === ""){
    errorText.textContent = "";
    return false;
  } else if(simpleinputRegex.test(input.value) == false){
    errorText.textContent = "Le format n\'est pas valide. Il y a des caractères spéciaux."
    return false; 
  } else {
    errorText.textContent='';
    return true;
  }
}

function validAddress(input, errorText){
  if(input.value === ""){
    errorText.textContent = "";
    return false;
  } else if(addressRegex.test(input.value) == false){
    errorText.textContent = "Le format n\'est pas valide. Il y a des caractères spéciaux."
    return false;
  } else {
    errorText.textContent='';
    return true;
  }
}

// validation formulaires
if(formConnexion !== null){
  let login = document.getElementById('login');
  let password = document.getElementById('password');
  let errorLogin = document.getElementById('errorLogin');
  let errorPassword = document.getElementById('errorPassword');
  let eye = document.getElementById('eye');

  eye.addEventListener('click', () =>{
    imageSrc = eye.getAttribute('src');
    if(imageSrc === 'images/notvisible.png'){
      eye.setAttribute('src', 'images/visible.png');
      password.setAttribute('type', 'text');
    } else if(imageSrc === 'images/visible.png'){
      eye.setAttribute('src', 'images/notvisible.png');
      password.setAttribute('type', 'password');
    }
  });

    login.addEventListener('focusout', () => {
      validLogin(login, errorLogin);
    });
    password.addEventListener('focusout', () => {
      validPassword(password, errorPassword);
    });

    formConnexion.addEventListener('submit', function(e) {
      e.preventDefault();
      console.log('nope');
      if(validLogin(login, errorLogin) && validPassword(password, errorPassword)){
          formConnexion.submit();
      };
    });
  }
 
if(formMission !== null){
    let title = document.getElementById('title');
    let description = document.getElementById('description');
    let codeName = document.getElementById('codeName');
    let errorTitle = document.getElementById('errorTitle');
    let errorDescription = document.getElementById('errorDescription');
    let errorCodeName = document.getElementById('errorCodeName');

    title.addEventListener('focusout', () => {
      validSimpleString(title, errorTitle);
    });
    description.addEventListener('focusout', () => {
      validString(description, errorDescription);
    });

    codeName.addEventListener('focusout', () => {
      validSimpleString(codeName, errorCodeName);
    });

    formMission.addEventListener('submit', function(e) {
      e.preventDefault();
      console.log('nope');
      if(validSimpleString(title, errorTitle) && validString(description, errorDescription) && validSimpleString(codeName, errorCodeName)){
        formMission.submit();
      };
    });
}

if(formSpy !== null){
  let firstname = document.getElementById('firstname');
  let lastname = document.getElementById('lastname');
  let codeName = document.getElementById('codeName');
  let errorFirstname = document.getElementById('errorFirstname');
  let errorLastname = document.getElementById('errorLastname');
  let errorCodeName = document.getElementById('errorCodeName');

  firstname.addEventListener('focusout', () => {
    validSimpleString(firstname, errorFirstname);
  });
  lastname.addEventListener('focusout', () => {
    validSimpleString(lastname, errorLastname);
  });

  codeName.addEventListener('focusout', () => {
    validSimpleString(codeName, errorCodeName);
  });

  formSpy.addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('nope');
    if(validSimpleString(firstname, errorFirstname) && validSimpleString(lastname, errorLastname) && validSimpleString(codeName, errorCodeName)){
      formSpy.submit();
    };
  });
}

if(formTarget !== null){
  let firstname = document.getElementById('firstname');
  let lastname = document.getElementById('lastname');
  let codeName = document.getElementById('codeName');
  let errorFirstname = document.getElementById('errorFirstname');
  let errorLastname = document.getElementById('errorLastname');
  let errorCodeName = document.getElementById('errorCodeName');

  firstname.addEventListener('focusout', () => {
    validSimpleString(firstname, errorFirstname);
  });
  lastname.addEventListener('focusout', () => {
    validSimpleString(lastname, errorLastname);
  });

  codeName.addEventListener('focusout', () => {
    validSimpleString(codeName, errorCodeName);
  });

  formTarget.addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('nope');
    validSimpleString(lastname, errorLastname);
    if(validSimpleString(firstname, errorFirstname) && validSimpleString(lastname, errorLastname) && validSimpleString(codeName, errorCodeName)){
      formTarget.submit();errorLastname
    };
  });
}

if(formContact !== null){
  let firstname = document.getElementById('firstname');
  let lastname = document.getElementById('lastname');
  let codeName = document.getElementById('codeName');
  let errorFirstname = document.getElementById('errorFirstname');
  let errorLastname = document.getElementById('errorLastname');
  let errorCodeName = document.getElementById('errorCodeName');

  firstname.addEventListener('focusout', () => {
    validSimpleString(firstname, errorFirstname);
  });
  lastname.addEventListener('focusout', () => {
    validSimpleString(lastname, errorLastname);
  });

  codeName.addEventListener('focusout', () => {
    validSimpleString(codeName, errorCodeName);
  });

  formContact.addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('nope');
    if(validSimpleString(firstname, errorFirstname) && validSimpleString(lastname, errorLastname) && validSimpleString(codeName, errorCodeName)){
      formContact.submit();
    };
  });
}

if(formHideout !== null){
  let codeName = document.getElementById('codeName');
  let address = document.getElementById('address');
  let type = document.getElementById('type');
  let errorCodeName = document.getElementById('errorCodeName');
  let errorAddress = document.getElementById('errorAddress');
  let errorType = document.getElementById('errorType');

  codeName.addEventListener('focusout', () => {
    validSimpleString(codeName, errorCodeName);
  });

  address.addEventListener('focusout', () => {
    validAddress(address, errorAddress);
  });

  type.addEventListener('focusout', () => {
    validSimpleString(type, errorType);
  });
  
  formHideout.addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('nope');
    if(validSimpleString(codeName, errorCodeName) && validAddress(address, errorAddress) && validSimpleString(type, errorType)){
      formHideout.submit();
    };
  });
}

if(formSpeciality !== null){
  let name = document.getElementById('name');
  let errorName = document.getElementById('errorName');

  name.addEventListener('focusout', () => {
    validSimpleString(name, errorName);
  });
  
  formSpeciality.addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('nope');
    if(validSimpleString(name, errorName)){
      formSpeciality.submit();
    };
  });
}

if(formTypeOfMission !== null){
  let name = document.getElementById('name');
  let errorName = document.getElementById('errorName');

  name.addEventListener('focusout', () => {
    validSimpleString(name, errorName);
  });
  
  formTypeOfMission.addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('nope');
    if(validSimpleString(name, errorName)){
      formTypeOfMission.submit();
    };
  });
}