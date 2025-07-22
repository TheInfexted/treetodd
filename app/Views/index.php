<main current-page="login" class="p-0">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                <div class="login-form-container">
                    <!--- Logo --->
                    <figure class="p-0 mt-3 mb-4 text-center">
                        <a class="logo d-inline-block" href="<?=base_url();?>">
                            <img class="w-100" src="<?=base_url('assets/img/logo/1.png');?>" alt="<?=$_ENV['company'];?>">
                        </a>
                    </figure>
                    <!--- End Logo --->

                    <div class="form_container">
                        
                        <?=form_open('',['class'=>'form-validation app-form loginForm','novalidate'=>'novalidate']);?>
                        <div class="mb-3 text-center">
                            <h3>Login to your Account</h3>
                            <p class="f-s-12 text-secondary">Get started with our app, just create an account and enjoy the experience.</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?=lang('Input.email');?></label>
                            <input type="email" class="form-control" name="loginUsername" id="loginUsername" required>
                            <div class="form-text text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?=lang('Input.password');?></label>
                            <input type="password" class="form-control" name="loginPass" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" value="isRememberMe">
                            <label class="form-check-label" for="rememberMe"><?=lang('Input.rememberme');?></label>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary w-100" onclick="isRememberMe();"><?=lang('Nav.submit');?></button>
                        </div>
                        <div class="app-divider-v justify-content-center">
                            <p class="text-uppercase"><?=lang('Nav.support');?></p>
                        </div>
                        <div class="text-center mb-3">
                            <button type="button" class="btn btn-light"><i class="ph-duotone ph-chats-circle me-1"></i><?=lang('Nav.gethelp');?></button>
                        </div>
                        <div class="text-center">
                            <?=lang('Label.powerby');?>
                            <a target="_blank" href="<?=$_ENV['powerCompanyWebsite'];?>" class="text-secondary"><?=$_ENV['powerBy'];?></a>
                        </div>
                        <?=form_close();?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    // Login
    $('.loginForm').on('submit', function(e) {
        e.preventDefault();

        if (this.checkValidity() !== false) {
            generalLoading();

            $('.loginForm [type=submit]').prop('disabled', true);

            var params = {};
            var formObj = $(this).closest("form");
            $.each($(formObj).serializeArray(), function (index, value) {
                params[value.name] = value.value;
            });

            $.post('/user-login', {
                params
            }, function(data, status) {
                const obj = JSON.parse(data);
                if( obj.code==1 ) {
					window.location.replace("<?=base_url('dashboard');?>");
                } else {
					swal.fire("", obj.message + " (Code: "+obj.code+")", "error").then(() => { 
                        $('.loginForm [type=submit]').prop('disabled', false);
                    });
                }
            })
            .done(function() {
				$('.loginForm [type=submit]').prop('disabled', false);
            })
            .fail(function() {
                swal.fire("", "Sorry! Something wrong.", "error").then(() => {
					$('.loginForm [type=submit]').prop('disabled', false);
                });
            });
        }
    });
    // End Login
});

// Remember Me
const rmCheck = document.getElementById("rememberMe"),
	usernameInput = document.getElementById("loginUsername");

if (localStorage.checkbox && localStorage.checkbox !== "") {
	rmCheck.setAttribute("checked", "checked");
	usernameInput.value = localStorage.username;
} else {
	rmCheck.removeAttribute("checked");
	usernameInput.value = "";
}
// End Remember Me

function isRememberMe()
{
    if (rmCheck.checked && usernameInput.value !== "") {
        localStorage.username = usernameInput.value;
        localStorage.checkbox = rmCheck.value;
    } else {
        localStorage.username = "";
        localStorage.checkbox = "";
    }
}
// End Remember Me
</script>