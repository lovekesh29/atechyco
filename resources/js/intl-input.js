import intlTelInput from 'intl-tel-input';

var input = document.querySelector("#phone");
var iti = intlTelInput(input, {
    formatOnDisplay: false,
    geoIpLookup: function(callback) {
        $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
        });
    },
    hiddenInput: "fullPhoneNo",
    initialCountry: "auto",
    nationalMode: true,
    separateDialCode: true,
    utilsScript: siteUrl + "/js/utils.js",
});

$("#phone").on("focusout", function() {
    checkPhoneValidation();
    $('#form_order').hide();
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