function fetch_messages() {
    var message = document.getElementById('message').value;
    var vehicle_id = document.getElementById('vehicle-id-hidden').value;
    var user_id = document.getElementById('user-id-hidden').value;
    console.log('inside the message')
    if (message !== '') {
        $.ajax({
            type: 'POST',
            url: 'send-message.php',
            data: { message: message , vehicle_id : vehicle_id,user_id},
            success: function (response) {
                document.getElementById('message').value = ''; // Clear the input field
                var table = document.getElementById('message-table');
                var newRow = table.insertRow(-1);
                var usernameCell = newRow.insertCell(0);
                var messageCell = newRow.insertCell(1);
                usernameCell.innerHTML = '<?php echo $_SESSION["username"]; ?>';
                messageCell.innerHTML = message;
            },
            error: function (xhr, status, error) {
                console.log('AJAX error: ' + error);
            }
        });
    }
}
