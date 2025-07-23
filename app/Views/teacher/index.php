<main>
    <div class="container-fluid">

        <!--- Page Title --->
        <div class="d-flex justify-content-between align-items-center mb-0.5">
            <h4 class="main-title"><?= $pageName; ?></h4>
        </div>
        <!--- End Page Title --->

        <!-- Content -->
        <div class="row">
            <!-- Teachers -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="ph-duotone ph-chalkboard-teacher me-2"></i><?= lang('Label.teacherlist'); ?></h5>
                    </div>
                    <div class="card-body px-0">

                        <!--- Filter --->
                        <section class="d-block w-100 px-3 mb-3">
                            <div class="collapse" id="filterCollapse">
                                <div class="card card-body">
                                    <form class="filterForm">
                                    <div class="row g-3">
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="form-label"><?= lang('Input.teacher_name'); ?></label>
                                            <input type="text" class="form-control" name="teacherName" placeholder="<?= lang('Input.search_by_name'); ?>">
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="form-label"><?= lang('Input.status'); ?></label>
                                            <select class="form-select" name="status">
                                                <option value="all"><?= lang('Input.all_status'); ?></option>
                                                <option value="1"><?= lang('Input.active'); ?></option>
                                                <option value="2"><?= lang('Input.inactive'); ?></option>
                                                <option value="3"><?= lang('Input.terminated'); ?></option>
                                            </select>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="form-label"><?= lang('Input.qualification'); ?></label>
                                            <select class="form-select" name="qualification">
                                                <option value=""><?= lang('Input.search_qualification'); ?></option>
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
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                                            <label class="form-label"><?= lang('Input.branch'); ?></label>
                                            <select class="form-select" name="branchId">
                                                <option value=""><?= lang('Input.all_branches'); ?></option>
                                                <?php if (isset($branches) && is_array($branches)): ?>
                                                    <?php foreach ($branches as $branch): ?>
                                                        <option value="<?= $branch['branch_id']; ?>"><?= $branch['branch_name']; ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-auto col-lg-auto col-md-auto col-12">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="ph-bold ph-magnifying-glass me-1"></i>
                                                <?= lang('Nav.search'); ?>
                                            </button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="text-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addTeacher">
                                    <i class="ph-bold ph-plus me-1"></i><?= lang('Nav.add_teacher'); ?>
                                </button>
                                <button class="btn btn-primary align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 3 24 24" fill="#FFF" class="me-1" width="15" height="20">
                                        <path d="m18,5.92c0-2.162-1.758-3.92-3.92-3.92H3.92C1.758,2,0,3.758,0,5.92c0,.935.335,1.841.944,2.551l5.056,5.899v3.63c0,.315.148.611.4.8l4,3c.177.132.388.2.6.2.152,0,.306-.035.447-.105.339-.169.553-.516.553-.895v-6.63l5.056-5.899c.609-.71.944-1.616.944-2.551Zm-2.462,1.25l-5.297,6.18c-.155.181-.241.412-.241.651v5l-2-1.5v-3.5c0-.239-.085-.47-.241-.651L2.462,7.169c-.298-.348-.462-.792-.462-1.25,0-1.059.861-1.92,1.92-1.92h10.16c1.059,0,1.92.861,1.92,1.92,0,.458-.164.902-.462,1.25Zm8.462,12.831c0,.552-.448,1-1,1h-8c-.552,0-1-.448-1-1s.448-1,1-1h8c.552,0,1,.448,1,1Zm0-4c0,.552-.448,1-1,1h-8c-.552,0-1-.448-1-1s.448-1,1-1h8c.552,0,1,.448,1=1Zm-6-5h5c.552,0,1,.448,1,1s-.448,1-1,1h-5c-.552,0-1-.448-1-1s.448-1,1-1Z"/>
                                    </svg><?= lang('Nav.filter'); ?>
                                </button>
                            </div>
                        </section>
                        <!--- End Filter --->

                        <!--- Table --->
                        <section class="app-datatable-default">
                            <table id="teacherTable" class="display w-100 nowrap table-sm table-striped table-hover app-data-table default-data-table">
                                <thead>
                                    <tr>
                                        <th><?= lang('Input.teacher_name'); ?></th>
                                        <th><?= lang('Input.age'); ?></th>
                                        <th><?= lang('Input.highest_qualification'); ?></th>
                                        <th><?= lang('Input.kap_certificate'); ?></th>
                                        <th><?= lang('Input.hired_date'); ?></th>
                                        <th><?= lang('Input.phone'); ?></th>
                                        <th><?= lang('Input.branch'); ?></th>
                                        <th><?= lang('Input.status'); ?></th>
                                        <th><?= lang('Input.actions'); ?></th>
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
<section class="modal fade modal-addTeacher" id="modal-addTeacher" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-addTeacher" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary-800 d-flex justify-content-between align-items-center">
                <h1 class="modal-title fs-5 text-white"><?= lang('Nav.add_teacher'); ?></h1>
                <button type="button" class="border-0 bg-none text-white" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x fs-3"></i></button>
            </div>
            <form id="form-validation" class="form-validation app-form addTeacherForm" novalidate="novalidate">
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Personal Information -->
                    <div class="col-12">
                        <h6 class="fw-bold text-primary mb-3"><?= lang('Label.personal_information'); ?></h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.teacher_name'); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="teacherName" required>
                        <span class="invalid-feedback text-danger">Invalid Teacher Name.</span>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.age'); ?> <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="age" min="18" max="99" required>
                        <span class="invalid-feedback text-danger">Invalid Age.</span>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.id_number'); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="idNumber" required>
                        <span class="invalid-feedback text-danger">Invalid ID Number.</span>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.phone_number'); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phoneNumber" required>
                        <span class="invalid-feedback text-danger">Invalid Phone Number.</span>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><?= lang('Input.address'); ?> <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" rows="3" required></textarea>
                        <span class="invalid-feedback text-danger">Invalid Address.</span>
                    </div>

                    <!-- Professional Information -->
                    <div class="col-12">
                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-3"><?= lang('Label.professional_information'); ?></h6>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.highest_qualification'); ?> <span class="text-danger">*</span></label>
                        <select class="form-select" name="qualification" required>
                            <option value="" selected="selected" disabled="disabled"><?= lang('Input.select_one'); ?></option>
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
                        <select class="form-select" name="kapCertificate">
                            <option value="2"><?= lang('Input.no'); ?></option>
                            <option value="1"><?= lang('Input.yes'); ?></option>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><?= lang('Input.hired_date'); ?> <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="hiredDate" required>
                        <span class="invalid-feedback text-danger">Invalid Hired Date.</span>
                    </div>

                    <!-- Assignment Information -->
                    <div class="col-12">
                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-3"><?= lang('Label.assignment_information'); ?></h6>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label"><?= lang('Input.kindergarden'); ?> <span class="text-danger">*</span></label>
                        <select class="form-select" name="kdgnId" required>
                            <option value=""><?= lang('Input.select_kindergarden'); ?></option>
                            <?php if (isset($kindergartens) && is_array($kindergartens)): ?>
                                <?php foreach ($kindergartens as $kg): ?>
                                    <option value="<?= $kg['kdgn_id']; ?>"><?= $kg['kindergarden_name']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <span class="invalid-feedback text-danger">Invalid Kindergarden.</span>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label"><?= lang('Input.branch'); ?> <span class="text-danger">*</span></label>
                        <select class="form-select" name="branchId" required>
                            <option value=""><?= lang('Input.select_branch'); ?></option>
                            <?php if (isset($branches) && is_array($branches)): ?>
                                <?php foreach ($branches as $branch): ?>
                                    <option value="<?= $branch['branch_id']; ?>"><?= $branch['branch_name']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <span class="invalid-feedback text-danger">Invalid Branch.</span>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label"><?= lang('Input.management_id'); ?> <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="kdmgmId" value="1" required>
                        <span class="invalid-feedback text-danger">Invalid Management ID.</span>
                    </div>

                    <!-- Login Account -->
                    <div class="col-12">
                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-3"><?= lang('Label.create_login_account'); ?></h6>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label"><?= lang('Input.username'); ?></label>
                            <input type="text" class="form-control" name="username">
                        </div>
                            
                        <div class="col-md-4">
                            <label class="form-label"><?= lang('Input.password'); ?></label>
                            <input type="password" class="form-control" name="password">
                        </div>
                            
                        <div class="col-md-4">
                            <label class="form-label"><?= lang('Input.child_care_access'); ?></label>
                            <select class="form-select" name="branchChildcare">
                                <option value="2"><?= lang('Input.no'); ?></option>
                                <option value="1"><?= lang('Input.yes'); ?></option>
                            </select>
                        </div>
                    </div>                  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal"><?= lang('Nav.cancel'); ?></button>
                <button type="submit" class="btn btn-primary"><?= lang('Nav.add_teacher'); ?></button>
            </div>
            </form>
        </div>
    </div>
</section>

<!-- JavaScript and CSS -->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendors/datepikar/flatpickr.min.css'); ?>">
<script type="text/javascript" src="<?= base_url('assets/vendors/datepikar/flatpickr.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/date_picker.js'); ?>"></script>

<link rel="stylesheet" href="<?= base_url('assets/vendors/datatable/jquery.dataTables.min.css'); ?>">
<script type="text/javascript" src="<?= base_url('assets/vendors/datatable/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/custom/table_lang.js'); ?>"></script>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Global functions
function editTeacherStatus(teacherId, newStatus) {
    var params = {};
    params['teacherId'] = teacherId;
    params['status'] = newStatus;

    $.ajax({
        url: 'teacher/modify-status',
        type: 'POST',
        data: { params: params },
        dataType: 'json',
        success: function(data) {
            if (data.code == 1) {
                Swal.fire("", data.message, "success").then(() => {
                    $('#teacherTable').DataTable().ajax.reload(null, false);
                });
            } else if (data.code == 69) {
                Swal.fire("", data.message + " (Code: " + data.code + ")", "warning").then(() => {
                    userLogOut();
                });
            } else {
                Swal.fire("", data.message + " (Code: " + data.code + ")", "error");
            }
        },
        error: function(xhr, status, error) {
            try {
                var errorData = JSON.parse(xhr.responseText);
                if (errorData.code == 1) {
                    Swal.fire("", errorData.message, "success").then(() => {
                        $('#teacherTable').DataTable().ajax.reload(null, false);
                    });
                    return;
                }
            } catch (e) {
                // Silent fail
            }
            
            Swal.fire("Error!", "Something went wrong", "error");
        }
    });
}

function getTeacher(teacherId) {
    window.location.href = 'teacher/view/' + teacherId;
}

document.addEventListener('DOMContentLoaded', function() {
    // Language setup with fallback
    var langs = {};
    try {
        <?php if (isset($_SESSION['lang'])): ?>
        if ('<?= $_SESSION['lang'] ?>' == 'ms') {
            langs = typeof malay !== 'undefined' ? malay : {};
        } else if ('<?= $_SESSION['lang'] ?>' == 'cn') {
            langs = typeof chinese !== 'undefined' ? chinese : {};
        } else if ('<?= $_SESSION['lang'] ?>' == 'zh') {
            langs = typeof tradchinese !== 'undefined' ? tradchinese : {};
        } else if ('<?= $_SESSION['lang'] ?>' == 'th') {
            langs = typeof thai !== 'undefined' ? thai : {};
        } else if ('<?= $_SESSION['lang'] ?>' == 'vn') {
            langs = typeof viet !== 'undefined' ? viet : {};
        } else {
            langs = typeof english !== 'undefined' ? english : {};
        }
        <?php else: ?>
        langs = typeof english !== 'undefined' ? english : {};
        <?php endif; ?>
    } catch (e) {
        langs = {};
    }

    var pageindex = 1;
    
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
        
        columnDefs: [
            { targets: 0, width: '10%', className: 'text-left' },
            { targets: 1, width: '6%', className: 'text-left' },
            { targets: 2, width: '12%', className: 'text-left' },
            { targets: 3, width: '7%', className: 'text-left' },
            { targets: 4, width: '7%', className: 'text-left' },
            { targets: 5, width: '7%', className: 'text-left' },
            { targets: 6, width: '20%', className: 'text-left',
                render: function(data, type, row) {
                    if (type === 'display' && data && data.length > 40) {
                        return '<span title="' + data + '">' + data.substr(0, 40) + '...</span>';
                    }
                    return data;
                }
            },
            { targets: 7, width: '7%', className: 'text-left' },
            { targets: 8, width: '5%', className: 'text-left' }
        ],

        ajax: function(data, callback, settings) {
            if (settings._iRecordsTotal == 0) {
                pageindex = 1;
            } else {
                pageindex = settings._iDisplayStart / settings._iDisplayLength + 1;
            }

            const teacherName = $('.filterForm [name=teacherName]').val();
            const status = $('.filterForm [name=status] option:selected').val();
            const qualification = $('.filterForm [name=qualification]').val();
            const branchId = $('.filterForm [name=branchId] option:selected').val();

            var payload = JSON.stringify({
                pageindex: pageindex,
                rowperpage: data.length,
                teacherName: teacherName || '',
                status: status || 'all',
                qualification: qualification || '',
                branchId: branchId || '',
            });

            $.ajax({
                url: 'list-teachers',
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
                            if (typeof userLogOut === 'function') {
                                userLogOut();
                            }
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
                error: function(xhr, status, error) {
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
    $('.filterForm').off().on('submit', function(e) {
        e.preventDefault();
        teacherTable.draw();
    });

    // Add teacher form submission
    $('.addTeacherForm').off().on('submit', function(e) {
        e.preventDefault();
        
        if (this.checkValidity() !== false) {
            $('.addTeacherForm [type=submit]').prop('disabled', true);
            
            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });

            $.post('teacher/add-new', {
                params: params
            }, function(data, status) {
                const obj = typeof data === 'string' ? JSON.parse(data) : data;
                if (obj.code === 1) {
                    Swal.fire("", obj.message, "success").then(() => {
                        $('.modal-addTeacher').modal('hide');
                        teacherTable.draw();
                    });
                } else {
                    Swal.fire("", obj.message + " (Code: " + obj.code + ")", "error");
                }
            })
            .done(function() {
                $('.addTeacherForm [type=submit]').prop('disabled', false);
            })
            .fail(function() {
                Swal.fire("", "Something went wrong", "error");
                $('.addTeacherForm [type=submit]').prop('disabled', false);
            });
        }
    });

    // Modal reset event
    const addTeacherEvent = document.getElementById('modal-addTeacher');
    if (addTeacherEvent) {
        addTeacherEvent.addEventListener('hidden.bs.modal', function (event) {
            $('form').removeClass('was-validated');
            $('form').trigger('reset');
        });
    }
});
</script>