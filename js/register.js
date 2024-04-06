var serverURL = '/zavrsniRedovniProjekat/';
function check() {
    var username = $('#username').val();
    var password = $('#password').val();
    var confirmPassword = $('#confirm-password').val();

    var usernameError = $('#username-error');
    var passwordError = $('#password-error');
    var confirmPasswordError = $('#confirm-password-error');

    // Reset err
    usernameError.text('');
    passwordError.text('');
    confirmPasswordError.text('');


    var isUsernameValid = username.length >= 4;
    var isPasswordValid = password.length >= 6;
    var doPasswordsMatch = password === confirmPassword;

    if (!isUsernameValid) {
        usernameError.text('Username must be at least 4 characters long');
    }

    if (!isPasswordValid) {
        passwordError.text('Password must be at least 6 characters long');
    }

    if (!doPasswordsMatch) {
        confirmPasswordError.text('Passwords do not match');
    }

    // mjenjaj mu property
    var registerButton = $('#register-button');
    registerButton.prop('disabled', !(isUsernameValid && isPasswordValid && doPasswordsMatch));
}


function register() {
    var username = $('#username').val();
    var password = $('#password').val();
    var confirmPassword = $('#confirm-password').val();
    var userexist = $('#user-exists-error');

    $.ajax({
        url: serverURL + 'register.php',
        type: 'POST',
        data: { username: username, password: password, confirmPassword: confirmPassword },
        success: function (response) {
            if (response === 'success') {
                // redirect
                alert('Successfully created an account!! ' + username);
                window.location.href = 'login-view.php';
            } else if (response === 'user_exists') {
                // Korisinik posotji
                alert('User already exists with that name');
                $('#message').text('');
            } else {
                // reghistrracija failovala
                $('#message').text('An error occurred during registration');
            }
        },
        error: function () {
            // reghistrracija failovala
            $('#message').text('An error occurred during registration');
        }
    });
}


function resetForm() {
    $('#username').val('');
    $('#password').val('');
    $('#confirm-password').val('');
    $('#message').text('');
}
