<main>
    <div class="container-fluid">

        <!--- Page Title --->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="main-title mb-0"><?= $teacher['teacher_name']; ?></h4>
                    <div>
                        <a href="<?= base_url('teachers'); ?>" class="btn btn-outline-secondary me-2">
                            <i class="ph-bold ph-arrow-left me-1"></i><?= lang('Nav.back_to_list'); ?>
                        </a>
                        <button type="button" class="btn btn-primary" onclick="editTeacher(<?= $teacher['teacher_id']; ?>)">
                            <i class="ph-bold ph-pencil me-1"></i><?= lang('Nav.edit_teacher'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--- End Page Title --->

        <!-- Content -->
        <div class="row">
            <!-- Teacher Information -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ph-duotone ph-user-circle me-2"></i><?= lang('Label.teacher_information'); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Personal Information -->
                            <div class="col-12">
                                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><?= lang('Label.personal_information'); ?></h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.full_name'); ?></label>
                                        <p class="fw-semibold"><?= $teacher['teacher_name']; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.age'); ?></label>
                                        <p class="fw-semibold"><?= $teacher['age']; ?> <?= lang('Label.years_old'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.id_number'); ?></label>
                                        <p class="fw-semibold"><?= $teacher['id_number']; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.phone_number'); ?></label>
                                        <p class="fw-semibold">
                                            <a href="tel:<?= $teacher['phone_number']; ?>" class="text-decoration-none">
                                                <i class="ph-bold ph-phone me-1"></i><?= $teacher['phone_number']; ?>
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.address'); ?></label>
                                        <p class="fw-semibold"><?= nl2br($teacher['address']); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Professional Information -->
                            <div class="col-12">
                                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><?= lang('Label.professional_information'); ?></h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.highest_qualification'); ?></label>
                                        <p class="fw-semibold"><?= $teacher['highest_qualification']; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.kap_certificate'); ?></label>
                                        <p class="fw-semibold">
                                            <?php if ($teacher['kap_certificate'] === '1'): ?>
                                                <span class="badge bg-success"><i class="ph-bold ph-check me-1"></i><?= lang('Input.yes'); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><i class="ph-bold ph-x me-1"></i><?= lang('Input.no'); ?></span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.hired_date'); ?></label>
                                        <p class="fw-semibold">
                                            <i class="ph-bold ph-calendar me-1"></i>
                                            <?= date('F d, Y', strtotime($teacher['hired_date'])); ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.years_of_service'); ?></label>
                                        <p class="fw-semibold">
                                            <?php
                                            $hiredDate = new DateTime($teacher['hired_date']);
                                            $currentDate = new DateTime();
                                            $interval = $hiredDate->diff($currentDate);
                                            echo $interval->y . ' ' . lang('Label.years') . ', ' . $interval->m . ' ' . lang('Label.months');
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Assignment Information -->
                            <div class="col-12">
                                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><?= lang('Label.assignment_information'); ?></h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.kindergarden'); ?></label>
                                        <p class="fw-semibold"><?= $teacher['kindergarden_name'] ?? 'N/A'; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.branch'); ?></label>
                                        <p class="fw-semibold"><?= $teacher['branch_name'] ?? 'N/A'; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.manager'); ?></label>
                                        <p class="fw-semibold"><?= $teacher['manager_name'] ?? 'N/A'; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Account Information -->
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="ph-duotone ph-info me-2"></i><?= lang('Label.status_information'); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-medium text-muted"><?= lang('Input.current_status'); ?></label>
                            <p class="fw-semibold">
                                <?php
                                $statusClass = match($teacher['status']) {
                                    '1' => 'bg-success',
                                    '2' => 'bg-warning',
                                    '3' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                $statusText = match($teacher['status']) {
                                    '1' => lang('Input.active'),
                                    '2' => lang('Input.inactive'),
                                    '3' => lang('Input.terminated'),
                                    default => 'Unknown'
                                };
                                ?>
                                <span class="badge <?= $statusClass; ?> fs-6"><?= $statusText; ?></span>
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-medium text-muted"><?= lang('Input.created_date'); ?></label>
                            <p class="fw-semibold">
                                <i class="ph-bold ph-clock me-1"></i>
                                <?= date('M d, Y \a\t g:i A', strtotime($teacher['created_date'])); ?>
                            </p>
                        </div>

                        <?php if ($teacher['modified_date']): ?>
                        <div class="mb-3">
                            <label class="form-label fw-medium text-muted"><?= lang('Input.last_modified'); ?></label>
                            <p class="fw-semibold">
                                <i class="ph-bold ph-clock me-1"></i>
                                <?= date('M d, Y \a\t g:i A', strtotime($teacher['modified_date'])); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Login Account Card -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ph-duotone ph-user-gear me-2"></i><?= lang('Input.login_account'); ?></h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($teacher['branch_username'])): ?>
                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted"><?= lang('Input.username'); ?></label>
                                <p class="fw-semibold">
                                    <i class="ph-bold ph-user me-1"></i><?= $teacher['branch_username']; ?>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted"><?= lang('Input.login_status'); ?></label>
                                <p class="fw-semibold">
                                    <?php
                                    $loginStatusClass = ($teacher['login_status'] ?? '2') === '1' ? 'bg-success' : 'bg-danger';
                                    $loginStatusText = ($teacher['login_status'] ?? '2') === '1' ? lang('Input.active') : lang('Input.inactive');
                                    ?>
                                    <span class="badge <?= $loginStatusClass; ?>"><?= $loginStatusText; ?></span>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium text-muted"><?= lang('Input.child_care_access'); ?></label>
                                <p class="fw-semibold">
                                    <?php if (($teacher['branch_childcare'] ?? '2') === '1'): ?>
                                        <span class="badge bg-primary"><i class="ph-bold ph-check me-1"></i><?= lang('Label.enabled'); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><i class="ph-bold ph-x me-1"></i><?= lang('Label.disabled'); ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="ph-duotone ph-user-x text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2"><?= lang('Label.no_login_account'); ?></p>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="createLoginAccount(<?= $teacher['teacher_id']; ?>)">
                                    <i class="ph-bold ph-plus me-1"></i><?= lang('Label.create_account'); ?>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Content -->

    </div>
</main>

<!-- Edit Teacher Modal -->
<section class="modal fade modal-editTeacher" id="modal-editTeacher" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-editTeacher" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary-800 d-flex justify-content-between align-items-center">
                <h1 class="modal-title fs-5 text-white"><?= lang('Nav.edit_teacher'); ?></h1>
                <button type="button" class="border-0 bg-none text-white" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x fs-3"></i></button>
            </div>
            <form id="form-validation" class="form-validation app-form editTeacherForm" novalidate="novalidate">
            <input type="hidden" name="teacherId" id="edit_teacher_id">
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Personal Information -->
                    <div class="col-12">
                        <h6 class="fw-bold text-primary mb-3"><?= lang('Label.personal_information'); ?></h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.teacher_name'); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="teacherName" id="edit_teacher_name" required>
                        <span class="invalid-feedback text-danger">Invalid Teacher Name.</span>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.age'); ?> <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="age" id="edit_age" min="18" max="99" required>
                        <span class="invalid-feedback text-danger">Invalid Age.</span>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.id_number'); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="idNumber" id="edit_id_number" required>
                        <span class="invalid-feedback text-danger">Invalid ID Number.</span>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.phone_number'); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phoneNumber" id="edit_phone_number" required>
                        <span class="invalid-feedback text-danger">Invalid Phone Number.</span>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><?= lang('Input.address'); ?> <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" id="edit_address" rows="3" required></textarea>
                        <span class="invalid-feedback text-danger">Invalid Address.</span>
                    </div>

                    <!-- Professional Information -->
                    <div class="col-12">
                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-3"><?= lang('Label.professional_information'); ?></h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.highest_qualification'); ?> <span class="text-danger">*</span></label>
                        <select class="form-select" name="qualification" id="edit_highest_qualification" required>
                            <option value="" disabled="disabled"><?= lang('Input.select_one'); ?></option>
                            <option value="No formal education"><?= lang('Input.no_formal_education'); ?></option>
                            <option value="Primary education"><?= lang('Input.primary_education'); ?></option>
                            <option value="Secondary education"><?= lang('Input.secondary_education'); ?></option>
                            <option value="GED"><?= lang('Input.ged'); ?></option>
                            <option value="Vocational qualification"><?= lang('Input.vocational_qualification'); ?></option>
                            <option value="Bachelor's degree"><?= lang('Input.bachelors_degree'); ?></option>
                            <option value="Master's degree"><?= lang('Input.masters_degree'); ?></option>
                            <option value="Doctorate or higher"><?= lang('Input.doctorate_or_higher'); ?></option>
                        </select>
                        <span class="invalid-feedback text-danger">Invalid Qualification.</span>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.kap_certificate'); ?></label>
                        <select class="form-select" name="kapCertificate" id="edit_kap_certificate">
                            <option value="2"><?= lang('Input.no'); ?></option>
                            <option value="1"><?= lang('Input.yes'); ?></option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.hired_date'); ?> <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="hiredDate" id="edit_hired_date" required>
                        <span class="invalid-feedback text-danger">Invalid Hired Date.</span>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.status'); ?></label>
                        <select class="form-select" name="status" id="edit_status">
                            <option value="1"><?= lang('Input.active'); ?></option>
                            <option value="2"><?= lang('Input.inactive'); ?></option>
                            <option value="3"><?= lang('Input.terminated'); ?></option>
                        </select>
                    </div>

                    <!-- Login Account -->
                    <div class="col-12">
                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-3"><?= lang('Label.update_login_account'); ?></h6>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label"><?= lang('Input.username'); ?></label>
                            <input type="text" class="form-control" name="username" id="edit_username">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label"><?= lang('Input.new_password'); ?></label>
                            <input type="password" class="form-control" name="password" id="edit_password">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label"><?= lang('Input.child_care_access'); ?></label>
                            <select class="form-select" name="branchChildcare" id="edit_branch_childcare">
                                <option value="2"><?= lang('Input.no'); ?></option>
                                <option value="1"><?= lang('Input.yes'); ?></option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label"><?= lang('Input.login_status'); ?></label>
                            <select class="form-select" name="loginStatus" id="edit_login_status">
                                <option value="1"><?= lang('Input.active'); ?></option>
                                <option value="2"><?= lang('Input.inactive'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal"><?= lang('Nav.cancel'); ?></button>
                <button type="submit" class="btn btn-primary"><?= lang('Nav.update'); ?></button>
            </div>
            </form>
        </div>
    </div>
</section>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit teacher form submission following classroom pattern
    $('.editTeacherForm').off().on('submit', function(e) {
        e.preventDefault();
        
        if (this.checkValidity() !== false) {
            $('.editTeacherForm [type=submit]').prop('disabled', true);

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });

            $.post('<?= base_url("teacher/modify"); ?>', {
                params: params
            }, function(data, status) {
                const obj = typeof data === 'string' ? JSON.parse(data) : data;
                if (obj.code === 1) {
                    Swal.fire("", obj.message, "success").then(() => {
                        $('.modal-editTeacher').modal('hide');
                        location.reload(); 
                    });
                } else {
                    Swal.fire("", obj.message + " (Code: " + obj.code + ")", "error").then(() => {
                        $('.editTeacherForm [type=submit]').prop('disabled', false);
                    });
                }
            })
            .done(function() {
                $('.editTeacherForm [type=submit]').prop('disabled', false);
            })
            .fail(function() {
                Swal.fire("", "<?= lang('Response.something_went_wrong'); ?>", "error").then(() => {
                    $('.editTeacherForm [type=submit]').prop('disabled', false);
                });
            });
        }
    });

    // Modal reset event
    const editTeacherEvent = document.getElementById('modal-editTeacher');
    editTeacherEvent.addEventListener('hidden.bs.modal', function (event) {
        $('form').removeClass('was-validated');
        $('form').trigger('reset');
    });
});

// Edit teacher function following classroom pattern
function editTeacher(teacherId) {
    var params = {};
    params['teacherId'] = teacherId;

    $.post('<?= base_url("get-teacher"); ?>', {
        params: params
    }, function(data, status) {
        const obj = typeof data === 'string' ? JSON.parse(data) : data;
        if (obj.code === 1) {
            const teacher = obj.data;
            
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
            $('#edit_status').val(teacher.status);
            
            // Fill login fields if exists
            if (teacher.branch_username) {
                $('#edit_username').val(teacher.branch_username);
                $('#edit_branch_childcare').val(teacher.branch_childcare || '2');
                $('#edit_login_status').val(teacher.login_status || '1');
            }
            
            $('.modal-editTeacher').modal('show');
        } else {
            Swal.fire("", obj.message + " (Code: " + obj.code + ")", "error");
        }
    })
    .done(function() {
        // Success handled above
    })
    .fail(function() {
                    Swal.fire("", "<?= lang('Response.failed_to_load'); ?>", "error");
    });
}

// Create login account function
function createLoginAccount(teacherId) {
    // This will open the edit modal
    editTeacher(teacherId);
}
</script>