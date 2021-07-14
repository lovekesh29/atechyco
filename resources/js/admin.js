tinymce.init({
    selector: '#description',
    plugins: 'advlist link image lists',
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist'
});
// update user status
$('.user-status').click(function() {
    var userId = this.id;
    var userStatus = $(this).attr('data-status');

    var message = (userStatus == 0) ? 'Are you sure You want to enable user' : 'Are you sure You want to block user';

    swal({
        icon: "warning",
        title: 'Change User Status',
        text: message,
        buttons: ['No', 'Yes']
    }).then(result => {
        if (result) {
            $.ajax({
                type: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: siteUrl + '/admin/change-user-status',
                data: { userId: userId, userStatus: userStatus },
                success: function(data) {
                    var messageSuccess = (userStatus == 1) ? 'User has been blocked' : 'User has been enabled';
                    swal({
                        icon: "success",
                        title: 'User Status Updated',
                        text: messageSuccess
                    }).then(() => {
                        location.reload();
                    });

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal({
                        icon: "error",
                        title: ajaxOptions,
                        text: thrownError
                    });
                }
            })
        } else {
            return;
        }
    });
});

$('.course-status').click(function() {
    var courseId = this.id;
    var courseStatus = $(this).attr('data-status');

    var message = (courseStatus == 0) ? 'Are you sure You want to activate course' : 'Are you sure You want to deactivate course';

    swal({
        icon: "warning",
        title: 'Change Course Status',
        text: message,
        buttons: ['No', 'Yes']
    }).then(result => {
        if (result) {
            $.ajax({
                type: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: siteUrl + '/admin/change-course-status',
                data: { courseId: courseId, courseStatus: courseStatus },
                success: function(data) {
                    var messageSuccess = (courseStatus == 1) ? 'Course has been deactivated' : 'Course has been activated';
                    swal({
                        icon: "success",
                        title: 'Course Status Updated',
                        text: messageSuccess
                    }).then(() => {
                        location.reload();
                    });

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal({
                        icon: "error",
                        title: ajaxOptions,
                        text: thrownError
                    });
                }
            })
        } else {
            return;
        }
    });
});

$('.guru-status').click(function() {
    var guruId = this.id;
    var guruStatus = $(this).attr('data-status');

    var message = (guruStatus == 0) ? 'Are you sure You want to enable user' : 'Are you sure You want to block user';

    swal({
        icon: "warning",
        title: 'Change Guru Status',
        text: message,
        buttons: ['No', 'Yes']
    }).then(result => {
        if (result) {
            $.ajax({
                type: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: siteUrl + '/admin/change-guru-status',
                data: { guruId: guruId, guruStatus: guruStatus },
                success: function(data) {
                    var messageSuccess = (guruStatus == 1) ? 'User has been blocked' : 'User has been enabled';
                    swal({
                        icon: "success",
                        title: 'Guru Status Updated',
                        text: messageSuccess
                    }).then(() => {
                        location.reload();
                    });

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal({
                        icon: "error",
                        title: ajaxOptions,
                        text: thrownError
                    });
                }
            })
        } else {
            return;
        }
    });
})



import intlTelInput from 'intl-tel-input'


var input = document.querySelector("#adminPhone");
var iti = intlTelInput(input, {
    formatOnDisplay: false,
    hiddenInput: "fullPhoneNo",
    initialCountry: "us",
    nationalMode: true,
    separateDialCode: true,
    utilsScript: siteUrl + "/js/utils.js",
});

$("#adminPhone").on("focusout", function() {
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

$('#adminEditUserFormButton').click(function(e) {
    e.preventDefault();
    if (checkPhoneValidation()) {
        if ($("#adminEditUserForm")[0].checkValidity()) {
            $("#adminEditUserForm").submit();
        } else {
            $("#adminEditUserForm")[0].reportValidity()
        }
    } else {
        return false;
    }
});