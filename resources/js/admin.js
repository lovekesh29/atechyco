require('sweetalert');


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
})