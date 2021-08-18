tinymce.init({
    selector: 'textarea',
    plugins: 'advlist link image lists',
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist'
});

$('.page-status').click(function() {
    var pageId = this.id;
    var pageStatus = $(this).attr('data-status');

    var message = (pageStatus == 0) ? 'Are you sure You want to enable page' : 'Are you sure You want to block page';

    swal({
        icon: "warning",
        title: 'Change Page Status',
        text: message,
        buttons: ['No', 'Yes']
    }).then(result => {
        if (result) {
            $.ajax({
                type: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: siteUrl + '/admin/change-page-status',
                data: { pageId: pageId, pageStatus: pageStatus },
                success: function(data) {
                    var messageSuccess = (pageStatus == 1) ? 'Page has been blocked' : 'Page has been enabled';
                    swal({
                        icon: "success",
                        title: 'Page Status Updated',
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

$('.course-category').on('change', function() {
    var catId = $(this).val();

    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: siteUrl + '/admin/get-subCat',
        data: { catId: catId },
        success: function(dataHtml) {
            $('.course-subCat').html(dataHtml);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            swal({
                icon: "error",
                title: ajaxOptions,
                text: thrownError
            });
        }
    })
})

$('.categoryEditModal').click(function() {
    var categoryId = $(this).attr('id');
    var categoryName = $(this).attr('data-category-name');
    $('input[name="categoryId"]').val(categoryId);
    $('input[name="categoryEditName"]').val(categoryName);
    $('#category-edit-modal').modal('show');
});

$('.close-edit').click(function() {
    $('#category-edit-modal').modal('hide');
})

$('.subCategoryEditModal').click(function() {
    var subCategoryId = $(this).attr('id');
    var subCategoryName = $(this).attr('data-subCategory-name');
    $('input[name="subCategoryId"]').val(subCategoryId);
    $('input[name="subCategoryEditName"]').val(subCategoryName);
    $('#subcategory-edit-modal').modal('show');
});

$('.close-subedit').click(function() {
    $('#subCategoryEditModal').modal('hide');
});

//update Comment status
$('.comment-status').click(function() {
    var commentId = this.id;
    var commentStatus = $(this).attr('data-status');

    var message = (commentStatus == 0) ? 'Are you sure You want to enable comment' : 'Are you sure You want to block comment';

    swal({
        icon: "warning",
        title: 'Change comment Status',
        text: message,
        buttons: ['No', 'Yes']
    }).then(result => {
        if (result) {
            $.ajax({
                type: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: siteUrl + '/admin/change-comment-status',
                data: { commentId: commentId, commentStatus: commentStatus },
                success: function(data) {
                    var messageSuccess = (commentStatus == 1) ? 'Comment has been blocked' : 'Sub Category has been enabled';
                    swal({
                        icon: "success",
                        title: 'Comment Status Updated',
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

//update Sub category status
$('.sub-category-status').click(function() {
    var subCategoryId = this.id;
    var subCategoryStatus = $(this).attr('data-status');

    var message = (subCategoryStatus == 0) ? 'Are you sure You want to enable subcategory' : 'Are you sure You want to block Sub Category';

    swal({
        icon: "warning",
        title: 'Change Sub Category Status',
        text: message,
        buttons: ['No', 'Yes']
    }).then(result => {
        if (result) {
            $.ajax({
                type: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: siteUrl + '/admin/change-subCategory-status',
                data: { subCategoryId: subCategoryId, subCategoryStatus: subCategoryStatus },
                success: function(data) {
                    var messageSuccess = (subCategoryStatus == 1) ? 'Sub Category has been blocked' : 'Sub Category has been enabled';
                    swal({
                        icon: "success",
                        title: 'Sub Category Status Updated',
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

//update category status
$('.category-status').click(function() {
    var categoryId = this.id;
    var categoryStatus = $(this).attr('data-status');

    var message = (categoryStatus == 0) ? 'Are you sure You want to enable category' : 'Are you sure You want to block Category';

    swal({
        icon: "warning",
        title: 'Change Category Status',
        text: message,
        buttons: ['No', 'Yes']
    }).then(result => {
        if (result) {
            $.ajax({
                type: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: siteUrl + '/admin/change-category-status',
                data: { categoryId: categoryId, categoryStatus: categoryStatus },
                success: function(data) {
                    var messageSuccess = (categoryStatus == 1) ? 'Category has been blocked' : 'Category has been enabled';
                    swal({
                        icon: "success",
                        title: 'Category Status Updated',
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