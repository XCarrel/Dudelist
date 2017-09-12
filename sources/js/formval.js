// Form validation functions
// Author: XCL
// Sept 2017

// Checks if the content of a given field complies
function fieldIsOK(fieldname)
{
    fn = document.getElementById(fieldname).value;
    res = false;
    switch (fieldname) // Select the validation rule
    {
        case 'fname':                   // Names must be at least 2 chars long
        case 'lname':                   // Names must be at least 2 chars long
        case 'gitname':                 // Names must be at least 2 chars long
            res = (fn.length >= 2);
            break;
        case 'step':                    // Step is between 1 and 19
            res = (fn > 0 && fn < 20);
            break;
    }
    return res;
}

// Checks the field content, but also displays or hide the attached error message
function checkField(fieldname)
{
    if (fieldIsOK(fieldname))
    {
        document.getElementById('err' + fieldname).className = 'hidden';
    }
    else
    {
        document.getElementById('err' + fieldname).className = 'wrong';
    }
    checkForm(); // Evaluate if the form can be submitted or not, taking all fields into account
}


function checkForm() // Checks if all fields are OK and thus if the form can be submitted
{
    btn = document.getElementById('btnadd'); // Start with assumption we are adding a new dude -> button is add
    if (btn == null) btn = document.getElementById('btnsave'); // if not we must be editing a dude -> button is save
    if (btn == null) return; // if not it's very wrong

    if (fieldIsOK('fname') && fieldIsOK('lname') && fieldIsOK('gitname') && fieldIsOK('step')) // All fields are good ?
        btn.className = 'greenbutton'; // show the button
    else
        btn.className = 'hidden'; // hide it
}

// Setup event listeners
document.getElementById('fname').addEventListener("change", function () {
    checkField('fname')
});
document.getElementById('lname').addEventListener("change", function () {
    checkField('lname')
});
document.getElementById('gitname').addEventListener("change", function () {
    checkField('gitname')
});
document.getElementById('step').addEventListener("change", function () {
    checkField('step')
});