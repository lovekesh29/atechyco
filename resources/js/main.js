jQuery(document).ready(function($) {
    jQuery('.stellarnav').stellarNav({
        theme: 'dark',
        breakpoint: 960,
        position: 'left'
    });
});

$(document).ready(function() {
    AOS.init();
})



$('.comment-modal').click(function() {
    var courseId = $(this).attr('id');
    $('input[name="courseId"]').val(courseId)
    $('#commentCourseModal').modal('show');
});

$('.share-modal').click(function() {
    var shortUrl = $(this).attr('data-shortUrl');
    $('input[name="shareUrl"]').val(shortUrl)
    $('#shareModal').modal('show');
});

$('.share-close').click(function() {
    $('#shareModal').modal('hide');
})

$('.comment-close').click(function() {
    $('#commentCourseModal').modal('hide');
})

$('.like-button').click(function() {
    var courseId = $(this).attr('data-courseId');
    var type = $(this).attr('data-type');

    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: siteUrl + '/like-dislike-course',
        data: { courseId: courseId, type: type },
        dataType: "json",
        success: function(data) {
            location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            if (thrownError == 'Unauthorized') {
                swal({
                    icon: "error",
                    title: thrownError,
                    text: 'Please Login To Continue',
                    button: {
                        text: "Login!",
                        value: true,
                    },
                }).then((result) => {
                    if (result) {
                        window.location.href = siteUrl + "/login";
                    }
                });
            }

        }
    })

})

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

$("#phone").on("focusout", function() {
    checkPhoneValidation();
    $('#form_order').hide();
});

function checkPhoneValidation() {
    if (iti.isValidNumber()) {
        $("#phoneErrorLabel").fadeOut(100);
        $("input[name='phoneNo']").val(iti.getNumber());
        return true;
    } else {
        $("#phoneErrorLabel").fadeIn(100);
        return false;
    }
}