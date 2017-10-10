// Form validation functions
// Author: XCL
// Sept 2017

// Checks if the content of a given field complies
function fieldIsOK(fieldId)
{
    fn = $(fieldId).val();
    res = false;
    switch (fieldId) // Select the validation rule
    {
        case '#fname':                   // Names must be at least 2 chars long
        case '#lname':                   // Names must be at least 2 chars long
        case '#gitname':
            res = (fn.length >= 2);
            break;
    }
    return res;
}

// Checks the field content, but also displays or hide the attached error message
function checkField(fieldId)
{
    if (fieldIsOK(fieldId))
    {
        $('#err' + fieldId.substring(1)).addClass('hidden');
    }
    else
    {
        $('#err' + fieldId.substring(1)).removeClass('hidden');
    }
    checkForm(); // Evaluate if the form can be submitted or not, taking all fields into account
}

// Checks if all fields are OK and thus if the form can be submitted
function checkForm()
{
    btn = $('#btnadd'); // Start with assumption we are adding a new dude -> button is add
    if (!btn.length) btn = $('#btnsave'); // if not we must be editing a dude -> button is save
    if (!btn.length) return; // if not it's very wrong

    if (fieldIsOK('#fname') && fieldIsOK('#lname') && fieldIsOK('#gitname')) // All fields are good ?
        btn.removeClass('hidden'); // show the button
    else
        btn.addClass('hidden'); // hide it
}

function initForm()
{
    fields = ['#fname', '#lname', '#gitname'];

    fields.forEach(function(field) {
        f = $(field);
        f.keyup (function () { // Perform a check on each keystroke for instant feedback
            checkField(field);
        });
        f.change(function () { // Perform a check upon change anyway in case the user pasted a bad value using the mouse only
            checkField(field)
        });
        if (f.attr('type') == 'number')
            f.input(function () { // Because change does not fire on a number input when up/down arrows are clicked
                checkField(field)
            });
        checkField(field); // Initial check
    });
    checkGitname();
}

function checkGitname() {
    fn = $('#gitname').val();
    if (!fieldIsOK('#gitname')) return;
    $.ajax({
        url: 'https://api.github.com/users/'+fn,
        //url: '/data/'+fn+'.json', // This is the file version, to use when the github api quota has busted
        type: 'get',
        success: function( data ) {
            name = (data.name == null ? '(Nom inconnu)': data.name);
            avatar_url = (data.avatar_url == null ? '../../../assets/images/unknown.png': data.avatar_url);
            $('#avatar').attr('src', avatar_url);
            $('#realname').html(name);
        },
        error: function () {
            $('#avatar').attr('src', '../../../assets/images/ko.png');
            $('#realname').html('N\'existe pas');
        }
    });
}

$('#avatar').click(function () {
    checkGitname();
});

$('#gitname').keyup(function () {
    $('#avatar').attr('src', '../../../assets/images/unknown.png');
    $('#realname').html('');
});

