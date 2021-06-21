import intlTelInput from 'intl-tel-input';


var input = document.querySelector("#guruPhone");
var iti = intlTelInput(input, {
    formatOnDisplay: false,
    hiddenInput: "fullPhoneNo",
    initialCountry: "auto",
    nationalMode: true,
    separateDialCode: true,
    utilsScript: siteUrl + "/js/utils.js",
});

$("#guruPhone").on("focusout", function() {
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
$('#updateguruFormButton').click(function(e) {
    e.preventDefault();
    if (checkPhoneValidation()) {
        if ($("#updateguruForm")[0].checkValidity()) {
            $("#updateguruForm").submit();
        } else {
            $("#updateguruForm")[0].reportValidity()
        }
    } else {
        return false;
    }
});