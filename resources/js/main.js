require('sweetalert');
$('.trending-slider').slick({
    dots: true,
    infinite: true,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ]
});

$(document).ready(function() {
    AOS.init();
})

$('#signUpFormButton').click(function(e) {
    e.preventDefault();
    if (checkPhoneValidation()) {
        if ($("#signUpForm")[0].checkValidity()) {
            $("#signUpForm").submit();
        } else {
            $("#signUpForm")[0].reportValidity()
        }
    } else {
        return false;
    }
});

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