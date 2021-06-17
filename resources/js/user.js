import intlTelInput from 'intl-tel-input';


var input = document.querySelector("#userPhone");
var iti = intlTelInput(input, {
    formatOnDisplay: false,
    hiddenInput: "fullPhoneNo",
    initialCountry: "auto",
    nationalMode: true,
    separateDialCode: true,
    utilsScript: siteUrl + "/js/utils.js",
});

$("#userPhone").on("focusout", function() {
    checkPhoneValidation();
});

function checkPhoneValidation() {
    if (iti.isValidNumber()) {
        $("#phoneErrorLabel").fadeOut(100);
        var countryData = iti.getSelectedCountryData().dialCode; //get country code.
        $("#dialCode").val(countryData);
        return true;
    } else {
        $("#phoneErrorLabel").fadeIn(100);
        return false;
    }
}
$('#updateUserFormButton').click(function(e) {
    e.preventDefault();
    if (checkPhoneValidation()) {
        if ($("#updateUserForm")[0].checkValidity()) {
            $("#updateUserForm").submit();
        } else {
            $("#updateUserForm")[0].reportValidity()
        }
    } else {
        return false;
    }
});