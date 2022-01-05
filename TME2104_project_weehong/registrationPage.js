//want to load another js file into this js file, but cannot the work:(

/* function include(file) {
  
    var script  = document.createElement('script');
    script.src  = file;
    script.type = 'text/javascript';
    script.defer = true;
    
    /* document.getElementsByTagName('head').item(0).appendChild(script); */
    /* document.head.(script);
} */
/* 
include("formElementClass.js");
$.getScript("formElementClass.js"); 
 */ 

function resetForm() {
    if(window.confirm("Clear the Registration Form?")) {
        return true;
    } else {
        return false;
    }
}

function showTerms() {
    document.registrationForm.style.display = "none";
    document.getElementById("terms-statement").style.display = "block";
}

function hideTerms() {
    document.registrationForm.style.removeProperty("display");
    document.getElementById("terms-statement").style.removeProperty("display");
}

class FormElement {
    constructor(inputElement, validate) {
        this.inputElement = inputElement;
        this.validate = validate; // returns true upon successful validation and false upon invalid or incomplete input
    }

    getWarningElement() {
        const warningClass = 'warning-text';
        let warningTextParentElement = this.inputElement.parentElement;
        
        if(warningTextParentElement.getElementsByClassName(warningClass).length <= 0) {
            // search outer level
            warningTextParentElement = warningTextParentElement.parentElement;
        }
    
        return warningTextParentElement.getElementsByClassName(warningClass)[0];
    }
    
    showWarning(text) {
        const warningText = this.getWarningElement();
        warningText.innerHTML = text;
        warningText.classList.remove('hidden'); 
    
        // set input box border color to red
        function setRedBorder(inputElement) {
            inputElement.classList.add('warning');
        }
    
        // if input has a box, set box border color to red
        let inputType = this.inputElement.getAttribute('type');
        if(inputType) {
            inputType = inputType.toLowerCase();
            const boxInputTypes = ['text', 'email', 'tel', 'password'];
            if(boxInputTypes.indexOf(inputType) >= 0) {
                setRedBorder(this.inputElement);
            }
        } else if(this.inputElement.tagName.toLowerCase() == 'select') {
            setRedBorder(this.inputElement);
        }
    }

    hideWarning() {
        const warningText = this.getWarningElement();
        warningText.innerText = '';
        warningText.classList.add('hidden');
        this.inputElement.classList.remove('warning');
    }
}


const form = document.registrationForm;

const firstName = new FormElement(form.firstName, function() {
    if(this.inputElement.value == '') {
        this.showWarning('Enter your first name');
    } else if(this.inputElement.value.search(/\s/) >= 0) {
        this.showWarning('First name cannot contain any whitespace character (spaces, tabs, line breaks)');
    } else if(this.inputElement.value.search(/[0-9]/) >= 0)  {
        this.showWarning('First name cannot contain number(s)');
    } else if(this.inputElement.value.search(/[A-Z]/) != 0)  {
        this.showWarning('First name must begin with an uppercase character (A-Z)');
    } else if(this.inputElement.value.substring(1).search(/[A-Z]/) >= 0)  {
        this.showWarning('All characters after the first character must be lowercase characters');
    } else if (this.inputElement.value.length < 2) {
        this.showWarning('First name must have at least 2 characters');
    } else {
        this.hideWarning();
        return true;
    }
    return false;
});
const lastName = new FormElement(form.lastName, function() {
    if(this.inputElement.value == '') {
        this.showWarning('Enter your last name');
    } else if(this.inputElement.value.search(/\s/) >= 0) {
        this.showWarning('Last name cannot contain any whitespace character (spaces, tabs, line breaks)');
    } else if(this.inputElement.value.search(/[0-9]/) >= 0)  {
        this.showWarning('Last name cannot contain number(s)');
    } else if(this.inputElement.value.search(/[A-Z]/) != 0)  {
        this.showWarning('Last name must begin with an uppercase character (A-Z)');
    } else if(this.inputElement.value.substring(1).search(/[A-Z]/) >= 0)  {
        this.showWarning('All characters after the first character must be lowercase characters');
    } else if (this.inputElement.value.length < 2) {
        this.showWarning('Last name must have at least 2 characters');
    } else {
        this.hideWarning();
        return true;
    }
    return false;
});
const email = new FormElement(form.email, function() {
    if(this.inputElement.value == '') {
        this.showWarning('Enter your email');
    } else if(this.inputElement.value.search(/\s/) >= 0) {
        this.showWarning('Email cannot contain any whitespace character (spaces, tabs, line breaks)');
    } else if(this.inputElement.value.search(/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i) !== 0) {
        this.showWarning('Invalid email format. Email should have a format similar to <em>username@domain.com</em>');
    } else {
        this.hideWarning();
        return true;
    }
    return false;
});
const phone = new FormElement(form.phone, function() {
    if(this.inputElement.value == '') {
        this.showWarning('Enter your mobile phone number');
    } else if(this.inputElement.value.search(/\s/) >= 0) {
        this.showWarning('Phone number cannot contain any whitespace character (spaces, tabs, line breaks)');
    } else if(this.inputElement.value[0] !== '1') {
        this.showWarning('Invalid format. Malaysia mobile phone number must begin with 1');
    } else if(this.inputElement.value.search(/[^0-9]/) >= 0) {
        this.showWarning("Phone number can only contain numbers without any special character such as '-'");
    } else if(this.inputElement.value.length < 9 || this.inputElement.value.length > 10) {
        this.showWarning('Malaysia mobile phone number must have 9 - 10 digits (excluding +60)');
    } else {
        this.hideWarning();
        return true;
    }
    return false;
});
const password = new FormElement(form.password, function() {
    if(this.inputElement.value == '') {
        this.showWarning('Enter your password');
    } else if (this.inputElement.value.search(/\s/) >= 0) {
        this.showWarning('Password cannot contain any whitespace character (spaces, tabs, line breaks)');
    } else if (this.inputElement.value.search(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\W)(?=.*\d).{1,}$/) !== 0) {
        this.showWarning('Password must contain at least 1 uppercase character (A-Z), 1 lowercase character (a-z), 1 special character (!, @, #, $, %, ^, &, *) and 1 number (0-9)');
    } else if (this.inputElement.value.length < 6) {
        this.showWarning('Password must have at least 6 characters');
    } else {
        this.hideWarning();
        return true;
    }
    return false;
});
const confirmPassword = new FormElement(form.confirmPassword, function() {
    if(this.inputElement.value == '') {
        this.showWarning('Enter your password');
    } else if (this.inputElement.value !== form.password.value) {
        this.showWarning('Passwords do not match. Confirm Password must be the same as Password.');
    } else {
        this.hideWarning();
        return true;
    }
    return false;
});
const gender = new FormElement(form.gender[0], function() {
    if(!form.gender[0].checked && !form.gender[1].checked) {
        this.showWarning('Select your gender');
    } else {
        this.hideWarning();
        return true;
    }
    return false;
});
const state = new FormElement(form.state, function() {
    /* if(this.inputElement.value.search(/^(MY-)(0[1-9]|1[0-6])$/) !== 0) { */
    if(this.inputElement.value.search(/^(UK-)(0[1-4])$/) !== 0) {
        this.showWarning('Select your state');
    } else {
        this.hideWarning();
        return true;
    }
    return false;
});
const terms = new FormElement(form.terms, function() {
    if(!this.inputElement.checked) {
        this.showWarning('The Terms and Conditions must be accepted');
    } else {
        this.hideWarning();
        return true;
    }
    return false;
});

function validateForm() {
    // first invalid form element, of which will be focused upon submission of form (when user clicks REGISTER)
    let invalidFormElementToFocus;

    if(!firstName.validate()) {
        invalidFormElementToFocus = firstName;
    }
    if(!lastName.validate() && !invalidFormElementToFocus) {
        invalidFormElementToFocus = lastName;
    }
    if(!email.validate() && !invalidFormElementToFocus) {
        invalidFormElementToFocus = email;
    }
    if(!phone.validate() && !invalidFormElementToFocus) {
        invalidFormElementToFocus = phone;
    }
    if(!password.validate() && !invalidFormElementToFocus) {
        invalidFormElementToFocus = password;
    }
    if(!confirmPassword.validate() && !invalidFormElementToFocus) {
        invalidFormElementToFocus = confirmPassword;
    }
    if(!gender.validate() && !invalidFormElementToFocus) {
        invalidFormElementToFocus = gender;
    }
    if(!state.validate() && !invalidFormElementToFocus) {
        invalidFormElementToFocus = state;
    }
    if(!terms.validate() && !invalidFormElementToFocus) {
        invalidFormElementToFocus = terms;
    }

    if(invalidFormElementToFocus) {
        invalidFormElementToFocus.inputElement.focus();
        return false;
    } else {
        return true;
    }
}

window.addEventListener('load', function() {
    form.firstName.addEventListener('blur', () => {
        firstName.validate();
    });
    form.lastName.addEventListener('blur', () => {
        lastName.validate();
    });
    form.email.addEventListener('blur', () => {
        email.validate();
    });
    form.phone.addEventListener('blur', () => {
        phone.validate();
    });
    form.password.addEventListener('blur', () => {
        password.validate();
    });
    form.confirmPassword.addEventListener('blur', () => {
        confirmPassword.validate();    
    });
    form.state.addEventListener('change', () => {
        state.validate();     
    });
    form.terms.addEventListener('change', () => {
        terms.validate();      
    });
});
 
//used in loginPage.html
