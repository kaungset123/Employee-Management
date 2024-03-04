//////////////// Page Limitation Request //////////////////////
function changePerPage(perPage) {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('perPage', perPage);
    window.location.href = currentUrl.toString();
}

///////////////// Page Limitation Blade View //////////////

function togglePaginationOptions() {
    const paginationOptions = document.querySelector('.pagination-options');
    paginationOptions.style.display = paginationOptions.style.display === 'none' ? 'block' : 'none';
}

function changePerPage(perPage) {
    const currentUrl = new URL(window.location.href);
    const currentPage = new URLSearchParams(window.location.search).get('page') || 1;

    currentUrl.searchParams.set('perPage', perPage);
    currentUrl.searchParams.set('page', currentPage);

    window.location.href = currentUrl.toString();
   
} 

/////////////// rating /////////////////
$(document).ready(function() {
    const stars = $('.rating .star');
    const ratingValueInput = $('#ratingValue');

    ratingValueInput.val(1);

    stars.on('click', function() {
        const value = $(this).data('value');
        ratingValueInput.val(value);

        // Highlight selected stars
        stars.removeClass('selected');
        $(this).prevAll().addBack().addClass('selected');
    });

    $('#ratingForm').submit(function(event) {
        // Prevent form submission for testing purposes
        event.preventDefault();

        var user_id = $('#rated_id').val();

        // Simulate sending the rating to the server
        var formData = {
            rater_id: $('#rater_id').val(),
            rated_id: $('#rated_id').val(),
            rating: ratingValueInput.val(),
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

        console.log(formData);

        $.ajax({
            type: 'POST',
            url: "/rating",
            data: formData,
            success: function(response) {
                alert(response.success);
                var userRole = response.role;
                switch (userRole) {
                    case 'employee':
                        window.location.href = 'http://ems.org/employee/dashboard';
                        break;
                    case 'admin':
                        window.location.href = 'http://ems.org/admin/dashboard';
                        break;
                    case 'HR':
                        window.location.href = 'http://ems.org/hr/dashboard';
                        break;
                    case 'manager':
                        window.location.href = 'http://ems.org/manager/dashboard';
                        break;
                }
            },
            error: function(error) {
                alert(error.responseJSON.error);
            },
        });
    });
});

/////////////// department create modal ///////////////
$(document).ready(function() {

    $('#create-dept-btn').click(function() {
        $('#dept-create-modal').modal('toggle')
    });


    $('#dept-create-form').validate({
        rules: {
            name: {
                required : true ,
                maxlength : 50
            }
        },
        messages: {
            name: {
                required : 'Please enter department name!',
                maxlength : 'Department name mustn\'t be longer 50 characters!'
            }
        },
        submitHandler: function(form) {
            $('#response').empty();
            const formData = $(form).serializeArray();
            $('#dept-create-modal').modal('toggle');

            $.ajax({
                url: "department" ,
                type: "POST" ,
                data: formData ,
                beforeSend: function() {
                    console.log('loading...');
                },
                success: function(response) {
                    $("#dept-create-form")[0].reset();
                    // $('#dept-create-modal').modal('toggle');

                    if(response.status === 'success') {
                        $('#response').html(
                            `<p class="alert alert-success text-center" x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)" x-show="show">
                                ${response.message}
                            </p>`
                        );
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);
                        
                    }   
                    elseif(response.status === 'failed')
                     {
                        $('#response').html(
                            `<div class="alert alert-danger alert-dismissible">
                                ${response.messages}
                                <button type="button" class="btn-colse" data-bs-dismiss='alert'></button>
                            </div>`
                        );
                    }

                    console.log('res', response);
                },
                error: function(error) {
                    $('#response').html(
                        `<div class="alert alert-danger alert-dismissible">
                            ${response.messages}
                            <button type="button" class="btn-colse" data-dismiss='alert'></button>
                        </div>`
                    )
                }
            })
        }
    });

});

//////////// department edit modal //////////////////
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

$(document).ready(function() {
    $('.edit-btn').on('click', function() {
        var departmentId = $(this).data('department-id');
        var departmentName = $(this).data('department-name');

        $('#departmentId').val(departmentId);
        $('#departmentName').val(departmentName);
        $('#updateDepartmentModal').modal('toggle');
    });

    $('#dept-edit-form').validate({
        rules: {
            name: {
                required: true,
                maxlength : 50
            }
        },
        messages: {
            name: {
                required : 'Please enter department name!',
                maxlength : 'Department name mustn\'t be longer 50 characters!'
            }
        },
        submitHandler: function(form) {
            $('#response').empty();
            const formData = $(form).serialize();
            $.ajax({
                type: 'PUT',
                url: '/admin/department/' + $('#departmentId').val(),
                data: formData,
               
                success: function(response) {
                    // $("#dept-edit-form")[0].reset();
                    $('#updateDepartmentModal').modal('hide');
                    // $('#dept-create-modal').modal('toggle');

                    if(response.status === 'success') {
                        $('#response').html(
                            `<p class="alert alert-success text-center" x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)" x-show="show">
                                ${response.message}
                            </p>`
                        );
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);
                        
                    }   
                    elseif(response.status === 'failed')
                     {
                        $('#response').html(
                            `<div class="alert alert-danger alert-dismissible">
                                ${response.messages}
                                <button type="button" class="btn-close" data-bs-dismiss='alert'></button>
                            </div>`
                        );
                    }

                    console.log('res', response);
                },
                error: function(error) {
                    $('#response').html(
                        `<div class="alert alert-danger alert-dismissible">
                            ${response.messages}
                            <button type="button" class="btn-close" data-dismiss='alert'></button>
                        </div>`
                    )
                }
            })
        }
    });
});


///////////////// criteria edit modal //////////////////
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
})

$('.criteria-edit-btn').on('click', function() {
    var criteriaId = $(this).data('criteria-id');
    var criteriaAmount = $(this).data('criteria-amount');

    $('#criteriaId').val(criteriaId);
    $('#criteriaAmount').val(criteriaAmount);
    $('#updateSalarycriteriaModal').modal('toggle');
});

$('#criteria-edit-form').validate({
    rules: {
        bonus_amount: {
            required: true,
            maxlength : 8
        }
    },
    messages: {
        bonus_amount: {
            required : 'Please enter amount!',
            maxlength : 'Please check your amount!'
        }
    },
    submitHandler: function(form) {
        $('#response').empty();
        const formData = $(form).serialize();
        $.ajax({
            type: 'PUT',
            url: '/salaryCriteria/' + $('#criteriaId').val(),
            data: formData,
           
            success: function(response) {
                $('#updateSalarycriteriaModal').modal('hide');

                if(response.status === 'success') {
                    $('#response').html(
                        `<p class="alert alert-success text-center" x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)" x-show="show">
                            ${response.message}
                        </p>`
                    );
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                    
                }   
                elseif(response.status === 'failed')
                 {
                    $('#response').html(
                        `<div class="alert alert-danger alert-dismissible">
                            ${response.messages}
                            <button type="button" class="btn-colse" data-bs-dismiss='alert'></button>
                        </div>`
                    );
                }

                console.log('res', response);
            },
            error: function(error) {
                $('#response').html(
                    `<p class="alert alert-success text-center" x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)" x-show="show">
                    ${response.message}
                </p>`
                );
            }
        })
    }
});

///////////////// Attendance Pdf Generate //////////////////
$(document).ready(function() {
    $('.attendance-btn').on('click', function() {
        var userId = $(this).data('user-id');

        $('#userId').val(userId);
        $('#choosedMonth').val();
        $('#choosedYear').val();
        $('#attendancePdfModal').modal('toggle');
    });

    $('#attendance-pdf-form').validate({
        rules: {
            year: {
                required: true,
            }
        },
        messages: {
            year: {
                required : 'Please choose year!',
            }
        },
        submitHandler: function(form) {
            $('#response').empty();
            const formData = $(form).serialize();
            $.ajax({
                type: 'POST',
                url: '/attendance/pdfGenerate/' + $('#userId').val(),
                data: formData,
               
                success: function(response) {
                    $('#attendancePdfModal').modal('hide');

                    if(response.status === 'success') {
                        $('#response').html(
                            `<p class="alert alert-success text-center" x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)" x-show="show">
                                ${response.message}
                            </p>`
                        );
                    }   
                    if(response.status === 'failed')
                     {
                        $('#response').html(
                            `<p class="alert alert-danger text-center" x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)" x-show="show">
                                ${response.message}                      
                            </p>`
                        );
                    }

                    console.log('res', response);
                },
                error: function(error) {
                    $('#response').html(
                        `<div class="alert alert-danger text-center" x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)" x-show="show">
                            ${response.messages}                           
                        </div>`
                    )
                }
            })
        }
    });
});

///////////////// Leave Pdf Generate //////////////////
$(document).ready(function() {
    $('.leave-btn').on('click', function() {
        var leaveId = $(this).data('user-id');

        $('#leaveId').val(leaveId);
        $('#choosedMonth').val();
        $('#choosedYear').val();
        $('#leavePdfModal').modal('toggle');
    });

    $('#leave-pdf-form').validate({
        rules: {
            year: {
                required: true,
            }
        },
        messages: {
            year: {
                required : 'Please choose year!',
            }
        },
        submitHandler: function(form) {
            $('#response').empty();
            const formData = $(form).serialize();
            $.ajax({
                type: 'POST',
                url: '/leave/pdfGenerate/' + $('#leaveId').val(),
                data: formData,
               
                success: function(response) {
                    $('#leavePdfModal').modal('hide');

                    if(response.status === 'success') {
                        $('#response').html(
                            `<p class="alert alert-success text-center" x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)" x-show="show">
                                ${response.message}
                            </p>`
                        );                        
                    }   
                    if(response.status === 'failed')
                     {
                        $('#response').html(
                            `<p class="alert alert-danger text-center" x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)" x-show="show">
                                ${response.message}
                            </p>`
                        );
                    }

                    console.log('res', response);
                },
                error: function(error) {
                    $('#response').html(
                        `<div class="alert alert-danger alert-dismissible">
                            ${response.messages}
                            <button type="button" class="btn-colse" data-dismiss='alert'></button>
                        </div>`
                    )
                }
            })
        }
    });
});

// PREVIEW IMAGE
function displayImage(input) {
    var preview = document.getElementById('preview-image');
    var file = input.files[0];
    var reader = new FileReader();

    reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
    };

    if (file) {
        reader.readAsDataURL(file);
    }
}

// SELECTING ALL CHECKBOX 
$(document).ready(function() {
    // Array to store the previously checked checkboxes
    var previouslyChecked = [];

    // When the "Select All" checkbox is clicked
    $('#selectAllCheckbox').on('change', function() {
        if ($(this).prop('checked')) {
            // Save the state of all checkboxes before checking them all
            $('.checkbox').each(function() {
                if ($(this).prop('checked')) {
                    previouslyChecked.push($(this).val());
                }
            });
            // Check all checkboxes
            $('.checkbox').prop('checked', true);
        } else {
            // Uncheck all checkboxes and restore the previously checked ones
            $('.checkbox').prop('checked', false);
            $.each(previouslyChecked, function(index, value) {
                $('.checkbox[value="' + value + '"]').prop('checked', true);
            });
            // Clear the previouslyChecked array
            previouslyChecked = [];
        }
    });

    // When any checkbox is clicked
    $('.checkbox').on('change', function() {
        // Update the "Select All" checkbox state based on the checkboxes
        $('#selectAllCheckbox').prop('checked', $('.checkbox:checked').length === $('.checkbox').length);
    });
});





