<main>
    <div class="container-fluid">

        <!--- Page Title --->
        <h4 class="main-title"><?=$pageName;?></h4>
        <!--- End Page Title --->

        <!-- Content -->
        <div class="row">
            <!-- Classroom -->
            <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><?=lang('Label.classroomlist');?></h5>
                </div>
                <div class="card-body px-0">

                    <!--- Filter --->
                    <section class="d-block w-100 px-3 mb-3">
                        <menu class="m-0 text-end">
                            <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addClassroom">
                                <i class="ph-bold ph-plus me-1"></i><?=lang('Nav.classroom');?>
                            </a>    

                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" fill="#FFF" class="me-1" width="15" height="15"><path d="m18,5.92c0-2.162-1.758-3.92-3.92-3.92H3.92C1.758,2,0,3.758,0,5.92c0,.935.335,1.841.944,2.551l5.056,5.899v3.63c0,.315.148.611.4.8l4,3c.177.132.388.2.6.2.152,0,.306-.035.447-.105.339-.169.553-.516.553-.895v-6.63l5.056-5.899c.609-.71.944-1.616.944-2.551Zm-2.462,1.25l-5.297,6.18c-.155.181-.241.412-.241.651v5l-2-1.5v-3.5c0-.239-.085-.47-.241-.651L2.462,7.169c-.298-.348-.462-.792-.462-1.25,0-1.059.861-1.92,1.92-1.92h10.16c1.059,0,1.92.861,1.92,1.92,0,.458-.164.902-.462,1.25Zm8.462,12.831c0,.552-.448,1-1,1h-8c-.552,0-1-.448-1-1s.448-1,1-1h8c.552,0,1,.448,1,1Zm0-4c0,.552-.448,1-1,1h-8c-.552,0-1-.448-1-1s.448-1,1-1h8c.552,0,1,.448,1,1Zm-6-5h5c.552,0,1,.448,1,1s-.448,1-1,1h-5c-.552,0-1-.448-1-1s.448-1,1-1Z"/></svg>
                                    <?=lang('Nav.filter');?>
                                </div>
                            </a>
                        </menu>

                        <div class="collapse" id="collapseExample">
                            <div class="card card-body px-0 shadow-none">
                                <?=form_open('',['class'=>'row g-2 align-items-center filterForm','novalidate'=>'novalidate']);?>
                                <div class="col-xl-auto col-lg-auto col-md-auto col-12">
                                    <input type="text" class="form-control" placeholder="<?=lang('Input.clsrmname');?>" name="classRoomName">
                                </div>
                                <div class="col-xl-auto col-lg-auto col-md-auto col-12">
                                    <select class="form-select" name="status">
                                    <option value="" selected><?=lang('Input.status');?></option>
                                    <option value="1"><?=lang('Label.active');?></option>
                                    <option value="2"><?=lang('Label.inactive');?></option>
                                    </select>
                                </div>
                                <div class="col-xl-auto col-lg-auto col-md-auto col-12">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" fill="#FFF" class="me-1" width="15" height="15"><path d="M23.707,22.293l-5.969-5.969a10.016,10.016,0,1,0-1.414,1.414l5.969,5.969a1,1,0,0,0,1.414-1.414ZM10,18a8,8,0,1,1,8-8A8.009,8.009,0,0,1,10,18Z"/></svg>
                                        <?=lang('Nav.search');?>
                                    </button>
                                </div>
                                <?=form_close();?>
                            </div>
                        </div>
                    </section>
                    <!--- End Filter --->
                
                    <!--- Table --->
                    <section class="app-datatable-default">
                        <table id="classroomTable" class="display w-100 nowrap table-sm table-striped table-hover app-data-table default-data-table">
                        <thead>
                            <tr>
                            <th><?=lang('Input.clsrmname');?></th>
                            <th><?=lang('Input.batchyrs');?></th>
                            <th><?=lang('Input.session');?></th>
                            <th><?=lang('Input.totalchild');?></th>
                            <th><?=lang('Input.totalteacher');?></th>
                            <th><?=lang('Input.createdate');?></th>
                            <th><?=lang('Input.modifiedate');?></th>
                            <th><?=lang('Input.action');?></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        </table>
                    </section>
                    <!--- End Table --->
                
                </div>
            </div>
            <!-- End Classroom -->
        </div>
        <!-- End Content -->

    </div>
</main>

<section class="modal fade modal-addClassroom" id="modal-addClassroom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-addClassroom" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary-800 d-flex justify-content-between align-items-center">
                <h1 class="modal-title fs-5 text-white">Add Classroom</h1>
                <button type="button" class="border-0 bg-none text-white" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x fs-3"></i></button>
            </div>
            <?=form_open('',['id'=>'form-validation','class'=>'form-validation app-form addClassroomForm','novalidate'=>'novalidate']);?>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="userName" class="form-label"><?=lang('Input.clsrmname');?></label>
                    <input type="text" class="form-control" pattern="^[a-zA-Z0-9]{6,}$" name="classRoomName" required>
                    <span class="invalid-feedback text-danger">Invalid Classroom Name. Please enter at least 6 characters.</span>
                </div>
                <div class="mb-3">
                    <label for="userName" class="form-label"><?=lang('Input.batchyrs');?></label>
                    <input type="text" class="form-control" name="batchYear" required>
                    <span class="invalid-feedback text-danger">Invalid Batch.</span>
                </div>
                <div class="mb-3">
                    <label for="userName" class="form-label"><?=lang('Input.session');?></label>
                    <div class="d-flex flex-wrap gap-2">
                        <label class="check-box">
                            <input type="radio" class="form-check-input" name="session" value="1" checked required>
                            <span class="radiomark light-primary ms-2"></span>
                            <span class="text-primary">Morning</span>
                        </label>
                        <label class="check-box">
                            <input type="radio" class="form-check-input" name="session" value="2">
                            <span class="radiomark light-primary ms-2"></span>
                            <span class="text-primary">Afternoon</span>
                        </label>
                        <label class="check-box">
                            <input type="radio" class="form-check-input" name="session" value="3">
                            <span class="radiomark light-primary ms-2"></span>
                            <span class="text-primary">Morning & Afternoon</span>
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="userName" class="form-label"><?=lang('Input.starttime');?></label>
                    <input type="text" class="form-control date-time-picker" name="sessionStartTime" value="07:00">
                </div>
                <div class="mb-3">
                    <label for="userName" class="form-label"><?=lang('Input.endtime');?></label>
                    <input type="text" class="form-control date-time-picker" name="sessionEndTime" value="12:00">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><?=lang('Nav.submit');?></button>
            </div>
            <?=form_close();?>
        </div>
    </div>
</section>

<section class="modal fade modal-modifyClassroom" id="modal-modifyClassroom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-modifyClassroom" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary-800 d-flex justify-content-between align-items-center">
                <h1 class="modal-title fs-5 text-white">Modify Classroom</h1>
                <button type="button" class="border-0 bg-none text-white" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x fs-3"></i></button>
            </div>
            <?=form_open('',['id'=>'form-validation','class'=>'form-validation app-form modifyClassroomForm','novalidate'=>'novalidate'],['classRoomId'=>'']);?>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="userName" class="form-label"><?=lang('Input.clsrmname');?></label>
                    <input type="text" class="form-control" pattern="^[a-zA-Z0-9]{6,}$" name="classRoomName" required>
                    <span class="invalid-feedback text-danger">Invalid Classroom Name. Please enter at least 6 characters.</span>
                </div>
                <div class="mb-3">
                    <label for="userName" class="form-label"><?=lang('Input.batchyrs');?></label>
                    <input type="text" class="form-control" name="batchYear" required>
                    <span class="invalid-feedback text-danger">Invalid Batch.</span>
                </div>
                <div class="mb-3">
                    <label for="userName" class="form-label"><?=lang('Input.session');?></label>
                    <div class="d-flex flex-wrap gap-2">
                        <label class="check-box">
                            <input type="radio" class="form-check-input" name="session" id="session-1" value="1" checked required>
                            <span class="radiomark light-primary ms-2"></span>
                            <span class="text-primary">Morning</span>
                        </label>
                        <label class="check-box">
                            <input type="radio" class="form-check-input" name="session" id="session-2" value="2">
                            <span class="radiomark light-primary ms-2"></span>
                            <span class="text-primary">Afternoon</span>
                        </label>
                        <label class="check-box">
                            <input type="radio" class="form-check-input" name="session" id="session-3" value="3">
                            <span class="radiomark light-primary ms-2"></span>
                            <span class="text-primary">Morning & Afternoon</span>
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?=lang('Input.starttime');?></label>
                    <input type="text" class="form-control date-time-picker" name="sessionStartTime" value="07:00">
                </div>
                <div class="mb-3">
                    <label class="form-label"><?=lang('Input.endtime');?></label>
                    <input type="text" class="form-control date-time-picker" name="sessionEndTime" value="12:00">
                </div>
                <div class="mb-3">
                    <label class="form-label"><?=lang('Input.totalchild');?></label>
                    <input type="number" min="0" class="form-control" name="totalChild" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?=lang('Input.totalteacher');?></label>
                    <input type="number" min="0" class="form-control" name="totalTeacher" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><?=lang('Nav.submit');?></button>
            </div>
            <?=form_close();?>
        </div>
    </div>
</section>

<!-- <link rel="stylesheet" href="<?//=base_url('assets/vendors/datatable/custom/datatables.min.css');?>"> -->
<!-- <script src="<?//=base_url('assets/vendors/datatable/custom/datatables.min.js');?>"></script> -->

<link rel="stylesheet" type="text/css" href="<?=base_url('assets/vendors/datepikar/flatpickr.min.css');?>">
<script type="text/javascript" src="<?=base_url('assets/vendors/datepikar/flatpickr.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/date_picker.js');?>"></script>

<link rel="stylesheet" href="<?=base_url('assets/vendors/datatable/jquery.dataTables.min.css');?>">
<script type="text/javascript" src="<?=base_url('assets/vendors/datatable/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/custom/table_lang.js');?>"></script>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    if( '<?=$_SESSION['lang']?>' == 'ms' ) {
        langs = malay;
    } else if( '<?=$_SESSION['lang']?>' == 'cn' ) {
        langs = chinese;
    } else if( '<?=$_SESSION['lang']?>' == 'zh' ) {
        langs = tradchinese;
    } else if( '<?=$_SESSION['lang']?>' == 'th' ) {
        langs = thai;
    } else if( '<?=$_SESSION['lang']?>' == 'vn' ) {
        langs = viet;
    } else {
        langs = english;
    }

    var pageindex = 1, debug = false;
    const classroomTable = $('#classroomTable').DataTable({
        dom: "<'d-block'<'overflow-auto'tr>>" + "<'row mt-2'<'col-xl-6 col-lg-6 col-md-6 col-12'i><'col-xl-6 col-lg-6 col-md-6 col-12'p>>",
        // responsive: {
        //     details: {
        //         renderer: $.fn.dataTable.Responsive.renderer.tableAll({
        //             tableClass: 'table table-sm table-bordered table-hover'
        //         })
        //     }
        // },
        language: langs,
        ordering: false,
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
                var pageindex = settings._iDisplayStart/settings._iDisplayLength + 1;
            }

            const classRoomName = $('.filterForm [name=classRoomName]').val();
            const status = $('.filterForm [name=status] option:selected').val();
            
            var payload = JSON.stringify({
                pageindex: pageindex,
                rowperpage: data.length,
                classRoomName: classRoomName,
                status: status,
            });

            $.ajax({
                url: '/list-classroom',
                type: 'post',
                data: payload,
                contentType:"application/json; charset=utf-8",
                dataType:"json",
                success: function(res){
                    if (res.code !== 1) {
                        // alert(res.message);
                        callback({
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            data: []
                        });

                        return;
                    } else if(res.code == 69) {
                        swal.fire("", res.message + " (Code: "+res.code+")", "warning").then(() => {
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
                    return;
                }
            });
        },
        // aoColumnDefs: [{
        //     aTargets: [2],
        //     render: function ( data, type, row ) {
        //         return parseFloat(data).toFixed(5).replace(/(\.\d{2})\d*/, "$1").replace(/(\d)(?=(\d{3})+\b)/g, "$1,");
        //     }
        // }]
    });

    $('.filterForm').off().on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            classroomTable.draw();
        }
    });

    // Add Classroom
    $('.addClassroomForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.addClassroomForm [type=submit]').prop('disabled', true);

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });

            $.post('/classroom/add-new', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
					swal.fire("", obj.message, "success").then(() => { 
                        $('.modal-addClassroom').modal('hide');
                        $('#classroomTable').DataTable().ajax.reload(null,false);
                    });
                } else {
					swal.fire("", obj.message + " (Code: "+obj.code+")", "error").then(() => { 
                        $('.addClassroomForm [type=submit]').prop('disabled', false);
                    });
                }
            })
            .done(function() {
				$('.addClassroomForm [type=submit]').prop('disabled', false);
            })
            .fail(function() {
                swal.fire("", "Sorry! Something wrong.", "error").then(() => {
					$('.addClassroomForm [type=submit]').prop('disabled', false);
                });
            });
        }
    });

    const addClassroomEvent = document.getElementById('modal-addClassroom');
    addClassroomEvent.addEventListener('hidden.bs.modal', function (event) {
        $('form').removeClass('was-validated');
        $('form').trigger('reset');
    });
    // End Add Classroom

    // Modify Classroom
    $('.modifyClassroomForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.modifyClassroomForm [type=submit]').prop('disabled', true);

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });

            $.post('/classroom/modify', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
					swal.fire("", obj.message, "success").then(() => { 
                        $('.modal-modifyClassroom').modal('hide');
                        $('#classroomTable').DataTable().ajax.reload(null,false);
                    });
                } else {
					swal.fire("", obj.message + " (Code: "+obj.code+")", "error").then(() => { 
                        $('.modifyClassroomForm [type=submit]').prop('disabled', false);
                    });
                }
            })
            .done(function() {
				$('.modifyClassroomForm [type=submit]').prop('disabled', false);
            })
            .fail(function() {
                swal.fire("", "Sorry! Something wrong.", "error").then(() => {
					$('.modifyClassroomForm [type=submit]').prop('disabled', false);
                });
            });
        }
    });

    const modifyClassroomEvent = document.getElementById('modal-modifyClassroom');
    modifyClassroomEvent.addEventListener('hidden.bs.modal', function (event) {
        $('form').removeClass('was-validated');
        $('form').trigger('reset');
    });
    // End Add Classroom
});

function editClassroomStatus(classRoomId,status)
{
    generalLoading();

    var params = {};
        params['classRoomId'] = classRoomId;
        params['status'] = status;

    $.post('/classroom/modify-status', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.fire("", obj.message, "success").then(() => { 
                $('#classroomTable').DataTable().ajax.reload(null,false);
            });
        } else if( obj.code==69 ) {
            swal.fire("", obj.message + " (Code: "+obj.code+")", "warning").then(() => {
                userLogOut();
            });
        } else {
            swal.fire("", obj.message + " (Code: "+obj.code+")", "error").then(() => { 
            });
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("", "Sorry! Something wrong.", "error").then(() => {
        });
    });
}

function getClassroom(classRoomId)
{
    generalLoading();

    var params = {};
        params['classRoomId'] = classRoomId;

    $.post('/get-classroom', {
        params
    }, function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==1 ) {
            swal.close();
            $('.modal-modifyClassroom').modal('toggle');
            $('.modifyClassroomForm [name="classRoomId"]').val(obj.data.classroom_id);

            $('.modifyClassroomForm [name="classRoomName"]').val(obj.data.classroom_name);
            $('.modifyClassroomForm [name="batchYear"]').val(obj.data.batch_year);

            $('.modifyClassroomForm [name="session"]#session-'+obj.data.session).prop('checked',true);
            $('.modifyClassroomForm [name="sessionStartTime"]').val(obj.data.session_start);
            $('.modifyClassroomForm [name="sessionEndTime"]').val(obj.data.session_end);

            $('.modifyClassroomForm [name="totalChild"]').val(obj.data.total_child);
            $('.modifyClassroomForm [name="totalTeacher"]').val(obj.data.total_teachers);
        } else if( obj.code==69 ) {
            swal.fire("", obj.message + " (Code: "+obj.code+")", "warning").then(() => {
                userLogOut();
            });
        } else {
            swal.fire("", obj.message + " (Code: "+obj.code+")", "error").then(() => { 
            });
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire("", "Sorry! Something wrong.", "error").then(() => {
        });
    });
}
</script>