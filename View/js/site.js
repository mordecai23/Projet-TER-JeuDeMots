/**
 * Affiche un mot de passe.
 */
var displayPassword = function (e) {
    e.preventDefault();

    var passwordInput = $(this).closest(".form-group").find("input");
    passwordInput.attr("type", "text");
}

/**
 * Cache un mot de passe.
 */
var hidePassword = function (e) {
    e.preventDefault();

    var passwordInput = $(this).closest(".form-group").find("input");
    passwordInput.attr("type", "password");
}

$(function () {
    // Evénements
    $(document).on("mousedown", ".password-button", displayPassword);
    $(document).on("mouseup", ".password-button", hidePassword);
});

function disableBtnValidate() {
  if (document.getElementById("flexCheckDefault1").checked || document.getElementById("flexCheckDefault2").checked) {
    document.getElementById("validateGuest-btn").disabled = false;
    document.getElementById("connectGuest-btn").disabled = true;
  } else if (!document.getElementById("flexCheckDefault1").checked && !document.getElementById("flexCheckDefault2").checked) {
    document.getElementById("validateGuest-btn").disabled = true;
    document.getElementById("connectGuest-btn").disabled = true;
    
  }

}

