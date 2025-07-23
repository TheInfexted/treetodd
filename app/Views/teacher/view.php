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
                            <i class="ti ti-edit"></i>
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
                                        <p class="fw-semibold"><?= $teacher['kindergarden_name']; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.branch'); ?></label>
                                        <p class="fw-semibold"><?= $teacher['branch_name']; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-medium text-muted"><?= lang('Input.manager'); ?></label>
                                        <p class="fw-semibold"><?= $teacher['manager_name']; ?></p>
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
                            <label class="form-label fw-medium text-muted"><?= lang('Input.create_date'); ?></label>
                            <p class="fw-semibold">
                                <i class="ph-bold ph-clock me-1"></i>
                                <?= date('M d, Y \a\t g:i A', strtotime($teacher['created_date'])); ?>
                            </p>
                        </div>

                        <?php if ($teacher['modified_date']): ?>
                        <div class="mb-3">
                            <label class="form-label fw-medium text-muted"><?= lang('Input.modified_date'); ?></label>
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
                        <?php if ($teacher['branch_username']): ?>
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
                                    $loginStatusClass = $teacher['login_status'] === '1' ? 'bg-success' : 'bg-danger';
                                    $loginStatusText = $teacher['login_status'] === '1' ? lang('Input.active') : lang('Input.inactive');
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
<div class="modal fade" id="modal-editTeacher" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTeacherModalLabel">
                    <i class="ti ti-edit text-success"></i> <?= lang('Nav.edit_teacher'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTeacherForm">
            <input type="hidden" name="teacher_id" id="edit_teacher_id">
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Personal Information -->
                    <div class="col-12">
                        <h6 class="fw-bold text-primary mb-3"><?= lang('Label.personal_information'); ?></h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.teacher_name'); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="teacher_name" id="edit_teacher_name" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.age'); ?> <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="age" id="edit_age" min="18" max="99" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.id_number'); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="id_number" id="edit_id_number" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.phone_number'); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone_number" id="edit_phone_number" required>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><?= lang('Input.address'); ?> <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" id="edit_address" rows="3" required></textarea>
                    </div>

                    <!-- Professional Information -->
                    <div class="col-12">
                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-3"><?= lang('Label.professional_information'); ?></h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.highest_qualification'); ?> <span class="text-danger">*</span></label>
                        <select class="form-select" name="highest_qualification" id="edit_highest_qualification" required>
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
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.kap_certificate'); ?></label>
                        <select class="form-select" name="kap_certificate" id="edit_kap_certificate">
                            <option value="2"><?= lang('Input.no'); ?></option>
                            <option value="1"><?= lang('Input.yes'); ?></option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.hired_date'); ?> <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="hired_date" id="edit_hired_date" required>
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
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="update_login" value="1" id="updateLoginCheck">
                            <label class="form-check-label fw-bold text-primary" for="updateLoginCheck">
                                <?= lang('Label.update_login_account'); ?>
                            </label>
                        </div>
                    </div>
                    
                    <div id="editLoginFields" style="display: none;">
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
                                <select class="form-select" name="branch_childcare" id="edit_branch_childcare">
                                    <option value="2"><?= lang('Input.no'); ?></option>
                                    <option value="1"><?= lang('Input.yes'); ?></option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label"><?= lang('Input.login_status'); ?></label>
                                <select class="form-select" name="login_status" id="edit_login_status">
                                    <option value="1"><?= lang('Input.active'); ?></option>
                                    <option value="2"><?= lang('Input.inactive'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('Nav.cancel'); ?></button>
                <button type="submit" class="btn btn-primary">
                    <i class="ph-bold ph-check me-1"></i><?= lang('Nav.update'); ?>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle login fields
    $('#updateLoginCheck').change(function() {
        if ($(this).is(':checked')) {
            $('#editLoginFields').show();
        } else {
            $('#editLoginFields').hide();
        }
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
                        title: '<?= lang("Label.success"); ?>!',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        $('#modal-editTeacher').modal('hide');
                        location.reload(); // Reload to show updated data
                    });
                } else {
                    Swal.fire({
                        title: '<?= lang("Label.error"); ?>!',
                        text: response.message,
                        icon: 'error'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: '<?= lang("Label.error"); ?>!',
                    text: '<?= lang("Label.something_went_wrong"); ?>',
                    icon: 'error'
                });
            }
        });
    });
});

// Edit teacher function
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
                $('#edit_status').val(teacher.status);
                
                // Fill login fields if exists
                if (teacher.branch_username) {
                    $('#edit_username').val(teacher.branch_username);
                    $('#edit_branch_childcare').val(teacher.branch_childcare || '2');
                    $('#edit_login_status').val(teacher.login_status || '1');
                }
                
                $('#modal-editTeacher').modal('show');
            } else {
                Swal.fire({
                    title: '<?= lang("Label.error"); ?>!',
                    text: response.message,
                    icon: 'error'
                });
            }
        },
        error: function() {
            Swal.fire({
                title: '<?= lang("Label.error"); ?>!',
                text: '<?= lang("Label.failed_to_load"); ?>',
                icon: 'error'
            });
        }
    });
}

// Create login account function
function createLoginAccount(teacherId) {
    // This will open the edit modal and automatically check the login account creation
    editTeacher(teacherId);
    setTimeout(() => {
        $('#updateLoginCheck').prop('checked', true).trigger('change');
    }, 500);
}
</script>