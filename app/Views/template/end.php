</div>

<!--- Toast --->
<section class="toast-container position-static mb-3 position-fixed bottom-0 start-50 translate-middle-x">
    <div id="liveToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <article class="toast-body"></article>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</section>
<!--- End Toast --->


<!-- <script src="<?//=base_url('assets/vendors/bootstrap/bootstrap.bundle.min.js');?>"></script> -->
<script src="<?=base_url('assets/vendors/bootstrap/js/bootstrap.bundle.min.js');?>"></script>

<!--- Phosphor Icons --->
<script src="<?=base_url('assets/vendors/phosphor/phosphor.js');?>"></script>
<!--- End Phosphor Icons --->
<!--- Sweetalert --->
<script src="<?=base_url('assets/vendors/sweetalert/sweetalert.js');?>"></script>
<!--- End Sweetalert --->

<?php if( isset($session) && $session==true ): ?>
<script src="<?=base_url('assets/vendors/simplebar/simplebar.js');?>"></script>
<script src="<?=base_url('assets/js/script.js?v='.rand());?>"></script>
<?php endif; ?>

<script src="<?=base_url('assets/js/custom/master.js?v='.rand());?>"></script>

<script>
document.addEventListener('DOMContentLoaded', (event) => {

});

// User
function userLogOut()
{
    generalLoading();

    $.get('/user-logout', function(data, status) {
    })
    .done(function() {
        swal.close();
        location.reload();
    })
    .fail(function() {
        swal.fire("", "Sorry! Something wrong.", "error").then(() => {
        });
    });
}
// End USer

function deviceCheck()
{
    $.get('/device/check', function(data, status) {
        const obj = JSON.parse(data);
        if( obj.code==0 ) {
            
        } else if( obj.code==6 || obj.code==7 ) {
            // userLogOut();
        } else {
            swal.fire(obj.message, obj.code , "warning").then(() => {
            });
        }
    })
    .done(function() {
    })
    .fail(function() {
        swal.fire('Please try again later','-1', "error").then(() => {
        });
    });
}

function generalLoading()
{
    swal.fire({
        showConfirmButton: false,
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: {
            container: 'swal2-container',
            image: 'w-50',
        },
        html: `<div class="loader_box"><div class="loader_7 mx-auto"></div></div>`
	});
}
</script>
</body>
</html>