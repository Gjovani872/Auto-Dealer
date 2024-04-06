var serverURL = '/zavrsniRedovniProjekat/';
function checkLogin() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    //ako je manje od 4 neka dugme ostane disabled , else enabluj dugme
    if (username !== '' && password !== '' && username.length > 4 && password.length > 4) {
        //uzimamo login-button id , sa pomocu selektora $
        $('#login-button').prop('disabled', false);
    } else {
        $('#login-button').prop('disabled', true);
    }
}

function loginVerification() {//ova f ja se poziva kad se pritisne sign in dugme
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    if (username !== '' && password !== '' && username.length > 4 && password.length > 4) {
        $.ajax({
            type: 'POST',
            url: '/zavrsniRedovniProjekat/login.php',
            data: {
                username: username,
                password: password
            },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    alert('Successfully connected');
                    window.location.href = '/zavrsniRedovniProjekat/start-view.php';
                } else if (data.status === 'error') {
                    var errorMessages = data.errors || [data.message];
                    $('#message').text(errorMessages.join(', '));
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error: ' + error);
            }
        });
    }
}
