<main>
    <div class="container-fluid">

        <!--- Page Title --->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="main-title"><?= $pageName; ?></h4>
        </div>
        <!--- End Page Title --->

        <!-- Content -->
        <div class="row">
            <!-- Teachers -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ph-duotone ph-chalkboard-teacher me-2"></i>Teachers List</h5>
                    </div>
                    <div class="card-body px-0">

                        <!--- Filter --->
                        <section class="d-block w-100 px-3 mb-3">
                            <div class="collapse" id="filterCollapse">
                                <div class="card card-body">
                                    <form class="filterForm">
                                    <div class="row g-3">
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="form-label">Teacher Name</label>
                                            <input type="text" class="form-control" name="teacherName" placeholder="Search by name...">
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status">
                                                <option value="all">All Status</option>
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                                <option value="3">Terminated</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="form-label">Qualification</label>
                                            <input type="text" class="form-control" name="qualification" placeholder="Search qualification...">
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="form-label">Branch</label>
                                            <select class="form-select" name="branch_id">
                                                <option value="">All Branches</option>
                                                <?php foreach ($branches as $branch): ?>
                                                    <option value="<?= $branch['branch_id']; ?>"><?= $branch['branch_name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-auto col-lg-auto col-md-auto col-12">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="ph-bold ph-magnifying-glass me-1"></i>
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="text-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addTeacher">
                                    <i class="ph-bold ph-plus me-1"></i>Teacher
                                </button>
                                <button class="btn btn-primary align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 3 24 24" fill="#FFF" class="me-1" width="15" height="20">
                                        <path d="m18,5.92c0-2.162-1.758-3.92-3.92-3.92H3.92C1.758,2,0,3.758,0,5.92c0,.935.335,1.841.944,2.551l5.056,5.899v3.63c0,.315.148.611.4.8l4,3c.177.132.388.2.6.2.152,0,.306-.035.447-.105.339-.169.553-.516.553-.895v-6.63l5.056-5.899c.609-.71.944-1.616.944-2.551Zm-2.462,1.25l-5.297,6.18c-.155.181-.241.412-.241.651v5l-2-1.5v-3.5c0-.239-.085-.47-.241-.651L2.462,7.169c-.298-.348-.462-.792-.462-1.25,0-1.059.861-1.92,1.92-1.92h10.16c1.059,0,1.92.861,1.92,1.92,0,.458-.164.902-.462,1.25Zm8.462,12.831c0,.552-.448,1-1,1h-8c-.552,0-1-.448-1-1s.448-1,1-1h8c.552,0,1,.448,1,1Zm0-4c0,.552-.448,1-1,1h-8c-.552,0-1-.448-1-1s.448-1,1-1h8c.552,0,1,.448,1,1Zm-6-5h5c.552,0,1,.448,1,1s-.448,1-1,1h-5c-.552,0-1-.448-1-1s.448-1,1-1Z"/>
                                    </svg>Filter
                                </button>
                            </div>
                        </section>
                        <!--- End Filter --->

                        <!--- Table --->
                        <section class="app-datatable-default">
                            <table id="teacherTable" class="display w-100 nowrap table-sm table-striped table-hover app-data-table default-data-table">
                                <thead>
                                    <tr>
                                        <th>Teacher Name</th>
                                        <th>Age</th>
                                        <th>Qualification</th>
                                        <th>KAP Certificate</th>
                                        <th>Hired Date</th>
                                        <th>Phone</th>
                                        <th>Branch</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </section>
                        <!--- End Table --->

                    </div>
                </div>
            </div>
        </div>
        <!-- End Content -->

    </div>
</main>

<!-- Add Teacher Modal -->
<div class="modal fade" id="modal-addTeacher" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTeacherModalLabel">
                    <i class="ph-bold ph-user-plus me-2"></i>Add New Teacher
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addTeacherForm">
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Personal Information -->
                    <div class="col-12">
                        <h6 class="fw-bold text-primary mb-3">Personal Information</h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Teacher Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="teacher_name" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Age <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="age" min="18" max="99" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">ID Number (IC/Passport) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="id_number" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone_number" required>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" rows="3" required></textarea>
                    </div>

                    <!-- Professional Information -->
                    <div class="col-12">
                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-3">Professional Information</h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Highest Qualification <span class="text-danger">*</span></label>
                        <select class="form-select" name="highest_qualification" required>
                            <option value="" selected="selected" disabled="disabled">-- select one --</option>
                            <option value="No formal education">No formal education</option>
                            <option value="Primary education">Primary education</option>
                            <option value="Secondary education">Secondary education or high school</option>
                            <option value="GED">GED</option>
                            <option value="Vocational qualification">Vocational qualification</option>
                            <option value="Bachelor's degree">Bachelor's degree</option>
                            <option value="Master's degree">Master's degree</option>
                            <option value="Doctorate or higher">Doctorate or higher</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">KAP Certificate</label>
                        <select class="form-select" name="kap_certificate">
                            <option value="2">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Hired Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="hired_date" required>
                    </div>

                    <!-- Assignment Information -->
                    <div class="col-12">
                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-3">Assignment Information</h6>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Kindergarden <span class="text-danger">*</span></label>
                        <select class="form-select" name="kdgn_id" required>
                            <option value="">Select Kindergarden</option>
                            <?php foreach ($kindergardens as $kg): ?>
                                <option value="<?= $kg['kdgn_id']; ?>"><?= $kg['kindergarden_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Branch <span class="text-danger">*</span></label>
                        <select class="form-select" name="branch_id" required>
                            <option value="">Select Branch</option>
                            <?php foreach ($branches as $branch): ?>
                                <option value="<?= $branch['branch_id']; ?>"><?= $branch['branch_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Management ID <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="kdmgm_id" value="1" required>
                    </div>

                    <!-- Login Account -->
                    <div class="col-12">
                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-3">Create Login Account</h6>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username">
                        </div>
                            
                        <div class="col-md-4">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                            
                        <div class="col-md-4">
                            <label class="form-label">Child Care Access</label>
                            <select class="form-select" name="branch_childcare">
                                <option value="2">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>                  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="ph-bold ph-check me-1"></i>Add Teacher
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Teacher Modal -->
<div class="modal fade" id="modal-editTeacher" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTeacherModalLabel">
                    <i class="ph-bold ph-pencil me-2"></i>Edit Teacher
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTeacherForm">
            <input type="hidden" name="teacher_id" id="edit_teacher_id">
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Personal Information -->
                    <div class="col-12">
                        <h6 class="fw-bold text-primary mb-3">Personal Information</h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Teacher Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="teacher_name" id="edit_teacher_name" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Age <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="age" id="edit_age" min="18" max="99" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">ID Number (IC/Passport) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="id_number" id="edit_id_number" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone_number" id="edit_phone_number" required>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" id="edit_address" rows="3" required></textarea>
                    </div>

                    <!-- Professional Information -->
                    <div class="col-12">
                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-3">Professional Information</h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Highest Qualification <span class="text-danger">*</span></label>
                        <select class="form-select" name="highest_qualification" id="edit_highest_qualification" required>
                            <option value="" disabled="disabled">-- select one --</option>
                            <option value="No formal education">No formal education</option>
                            <option value="Primary education">Primary education</option>
                            <option value="Secondary education">Secondary education or high school</option>
                            <option value="GED">GED</option>
                            <option value="Vocational qualification">Vocational qualification</option>
                            <option value="Bachelor's degree">Bachelor's degree</option>
                            <option value="Master's degree">Master's degree</option>
                            <option value="Doctorate or higher">Doctorate or higher</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">KAP Certificate</label>
                        <select class="form-select" name="kap_certificate" id="edit_kap_certificate">
                            <option value="2">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Hired Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="hired_date" id="edit_hired_date" required>
                    </div>
                    
                    <div id="editLoginFields" style="display: none;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="edit_username">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">New Password (Leave blank to keep current)</label>
                                <input type="password" class="form-control" name="password" id="edit_password">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Child Care Access</label>
                                <select class="form-select" name="branch_childcare" id="edit_branch_childcare">
                                    <option value="2">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Login Status</label>
                                <select class="form-select" name="login_status" id="edit_login_status">
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="ph-bold ph-check me-1"></i>Update Teacher
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript and CSS -->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendors/datepikar/flatpickr.min.css'); ?>">
<script type="text/javascript" src="<?= base_url('assets/vendors/datepikar/flatpickr.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/date_picker.js'); ?>"></script>

<link rel="stylesheet" href="<?= base_url('assets/vendors/datatable/jquery.dataTables.min.css'); ?>">
<script type="text/javascript" src="<?= base_url('assets/vendors/datatable/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/custom/table_lang.js'); ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    // Language setup
    if ('<?= $_SESSION['lang'] ?>' == 'ms') {
        langs = malay;
    } else if ('<?= $_SESSION['lang'] ?>' == 'cn') {
        langs = chinese;
    } else if ('<?= $_SESSION['lang'] ?>' == 'zh') {
        langs = tradchinese;
    } else if ('<?= $_SESSION['lang'] ?>' == 'th') {
        langs = thai;
    } else if ('<?= $_SESSION['lang'] ?>' == 'vn') {
        langs = viet;
    } else {
        langs = english;
    }

    var pageindex = 1, debug = false;
    
    // Initialize DataTable
    const teacherTable = $('#teacherTable').DataTable({
        dom: "<'d-block'<'overflow-auto overflow-md-visible'tr>>" + "<'row mt-3'<'col-xl-6 col-lg-6 col-md-6 col-12'i><'col-xl-6 col-lg-6 col-md-6 col-12'p>>",
        responsive: false,
        language: langs,
        ordering: false,
        searching: false,
        pagingType: 'first_last_numbers',
        deferRender: true,
        serverSide: true,
        processing: true,
        destroy: true,
        pageLength: 20,
        ajax: function(data, callback, settings) {
            if (settings._iRecordsTotal == 0) {
                pageindex = 1;
            } else {
                var pageindex = settings._iDisplayStart / settings._iDisplayLength + 1;
            }

            const teacherName = $('.filterForm [name=teacherName]').val();
            const status = $('.filterForm [name=status] option:selected').val();
            const qualification = $('.filterForm [name=qualification]').val();
            const branch_id = $('.filterForm [name=branch_id] option:selected').val();

            var payload = JSON.stringify({
                pageindex: pageindex,
                rowperpage: data.length,
                teacherName: teacherName,
                status: status,
                qualification: qualification,
                branch_id: branch_id,
            });

            $.ajax({
                url: '/teacher/list-teachers',
                type: 'post',
                data: payload,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(res) {
                    if (res.code !== 1) {
                        callback({
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            data: []
                        });
                        return;
                    } else if (res.code == 69) {
                        Swal.fire("", res.message + " (Code: " + res.code + ")", "warning").then(() => {
                            userLogOut();
                        });
                        return;
                    } else {
                        callback({
                            recordsTotal: res.totalRecord,
                            recordsFiltered: res.totalRecord,
                            data: res.data
                        });
                    }
                },
                error: function() {
                    callback({
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        data: []
                    });
                }
            });
        }
    });

    // Filter form submission
    $('.filterForm').on('submit', function(e) {
        e.preventDefault();
        teacherTable.draw();
    });

    // Toggle login fields
    $('#createLoginCheck').change(function() {
        if ($(this).is(':checked')) {
            $('#loginFields').show();
        } else {
            $('#loginFields').hide();
        }
    });

    $('#updateLoginCheck').change(function() {
        if ($(this).is(':checked')) {
            $('#editLoginFields').show();
        } else {
            $('#editLoginFields').hide();
        }
    });

    // Add teacher form submission
    $('#addTeacherForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '/teacher/add-new',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.code === 1) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        $('#modal-addTeacher').modal('hide');
                        $('#addTeacherForm')[0].reset();
                        teacherTable.draw();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    icon: 'error'
                });
            }
        });
    });

    // Edit teacher form submission
    $('#editTeacherForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '/teacher/update',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.code === 1) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        $('#modal-editTeacher').modal('hide');
                        teacherTable.draw();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    icon: 'error'
                });
            }
        });
    });
});

// View teacher details
function viewTeacher(teacherId) {
    window.location.href = '/teacher/view/' + teacherId;
}

// Edit teacher
function editTeacher(teacherId) {
    $.ajax({
        url: '/teacher/details/' + teacherId,
        type: 'GET',
        success: function(response) {
            if (response.code === 1) {
                const teacher = response.data;
                
                // Fill form fields
                $('#edit_teacher_id').val(teacher.teacher_id);
                $('#edit_teacher_name').val(teacher.teacher_name);
                $('#edit_age').val(teacher.age);
                $('#edit_id_number').val(teacher.id_number);
                $('#edit_phone_number').val(teacher.phone_number);
                $('#edit_address').val(teacher.address);
                $('#edit_highest_qualification').val(teacher.highest_qualification);
                $('#edit_kap_certificate').val(teacher.kap_certificate);
                $('#edit_hired_date').val(teacher.hired_date);
                
                // Fill login fields if exists
                if (teacher.branch_username) {
                    $('#edit_username').val(teacher.branch_username);
                    $('#edit_branch_childcare').val(teacher.branch_childcare || '2');
                    $('#edit_login_status').val(teacher.login_status || '1');
                }
                
                $('#modal-editTeacher').modal('show');
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: response.message,
                    icon: 'error'
                });
            }
        },
        error: function() {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to load teacher details.',
                icon: 'error'
            });
        }
    });
}

// Delete teacher
function deleteTeacher(teacherId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/teacher/delete',
                type: 'POST',
                data: { teacher_id: teacherId },
                success: function(response) {
                    if (response.code === 1) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: response.message,
                            icon: 'success'
                        }).then(() => {
                            teacherTable.draw();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete teacher.',
                        icon: 'error'
                    });
                }
            });
        }
    });
}

// Change teacher status
function changeTeacherStatus(teacherId, newStatus) {
    const statusText = {
        '1': 'Active',
        '2': 'Inactive', 
        '3': 'Terminated'
    };

    $.ajax({
        url: '/teacher/change-status',
        type: 'POST',
        data: { 
            teacher_id: teacherId,
            status: newStatus
        },
        success: function(response) {
            if (response.code === 1) {
                Swal.fire({
                    title: 'Updated!',
                    text: `Teacher status changed to ${statusText[newStatus]}.`,
                    icon: 'success'
                }).then(() => {
                    $('#teacherTable').DataTable().ajax.reload(null, false);
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: response.message,
                    icon: 'error'
                });
            }
        },
        error: function() {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to change teacher status.',
                icon: 'error'
            });
        }
    });
}
</script>