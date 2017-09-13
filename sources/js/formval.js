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
            console.log ('step = '+fn+', which is '+res);
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

// Checks if all fields are OK and thus if the form can be submitted
function checkForm()
{
    btn = document.getElementById('btnadd'); // Start with assumption we are adding a new dude -> button is add
    if (btn == null) btn = document.getElementById('btnsave'); // if not we must be editing a dude -> button is save
    if (btn == null) return; // if not it's very wrong

    if (fieldIsOK('fname') && fieldIsOK('lname') && fieldIsOK('gitname') && fieldIsOK('step')) // All fields are good ?
        btn.className = 'greenbutton'; // show the button
    else
        btn.className = 'hidden'; // hide it
}

function initForm()
{
    fields = ['fname','lname','gitname','step'];

    fields.forEach(function(field) {
        f = document.getElementById(field);
        f.addEventListener("keyup", function () { // Perform a check on each keystroke for instant feedback
            checkField(field);
        });
        f.addEventListener("change", function () { // Perform a check upon change anyway in case the user pasted a bad value using the mouse only
            checkField(field)
        });
        if (f.type == 'number')
            f.addEventListener("input", function () { // Because change does not fire on a number input when up/down arrows are clicked
                checkField(field)
            });
        checkField(field); // Initial check
    });
}
