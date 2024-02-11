
function setError(err) {
    var alertDiv = document.getElementById('alert');
    if (alertDiv) {
        alertDiv.className = "alert alert-danger mt-3 alert-dismissible fade show";
        alertDiv.innerHTML =
            '<strong>' + err + '</strong>' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span></button>';
    }
}

    function validate_user() {
        var user = document.getElementById('username').value;
        var validateMessage = document.getElementById('validate');

        if (user.length < 3 || user.length > 6) {
            validateMessage.innerHTML = "Length of username must be between 3 and 6";
            validateMessage.style.color = "red";
        } else {
            validateMessage.innerHTML = "";
        }
    }

    function validate_pass() {
        var user = document.getElementById('newPassword').value;
        var validateMessage = document.getElementById('validate');

        if (user.length < 8 || user.length > 40) {
            validateMessage.innerHTML = "Length of password must be between 8 and 40";
            validateMessage.style.color = "red";
        } else {
            validateMessage.innerHTML = "";
        }
    }

    function validate_new_pass() {
        var user = document.getElementById('confirmPassword').value;
        var validateMessage = document.getElementById('validate');

        if (user.length < 8 || user.length > 40) {
            validateMessage.innerHTML = "Length of password must be between 8 and 40";
            validateMessage.style.color = "red";
        } else {
            validateMessage.innerHTML = "";
        }
    }

