
var serverURL = '/zavrsniRedovniProjekat/';


function fetchVehicles() {
    $.ajax({
        url: serverURL + 'fetch_oglasi.php',
        type: 'GET',
        success: function(response) {
            $('.oglasi').html(response);

            $('.image-wrapper').click(function() {
                var vehicleId = $(this).data('vehicle-id');
                var url = 'ad-view.php?id=' + vehicleId;
                window.location.href = url;
            });
        }
    });
}

function filterVehicles() {
    var formData = $('#filterForm').serialize();

    $.ajax({
        url: serverURL + 'filter.php',
        type: 'GET',
        data: formData,
        success: function(response) {
            $('.oglasi').html(response);
        }
    });
}
