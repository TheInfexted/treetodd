(function () {
    'use strict';

    // Tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    // End Tooltips

    // Toast
    const toastTrigger = document.getElementById('liveToastBtn')
    const toastLiveExample = document.getElementById('liveToast')

    if (toastTrigger) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastTrigger.addEventListener('click', () => {
            toastBootstrap.show()
        })
    }
    // End Toast
  
    // Form Validation
    var forms = document.querySelectorAll('.form-validation');
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false);
    });

    $("#form-validation").submit(function(event) {
        var userName = $("#userName").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var address = $("#address").val();
        var address2 = $("#address2").val();
        var city = $("#city").val();
        var zipCode = $("#zipCode").val();
        var userNameRegex = /^[A-Za-z0-9]+$/;
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        var passwordRegex = /^.{1,8}$/;
        var addressRegex = /^[A-Za-z0-9\s,-]+/;
        var addressRegex2 = /^[A-Za-z0-9\s,-]+/;
        var cityRegex = /^[A-Za-z\s-]+/;
        var zipCodeRegex = /^\d{5}$/;
        var userNameError = $("#userNameError");
        var emailError = $("#emailError");
        var passwordError = $("#passwordError");
        var addressError = $("#addressError");
        var addressError2 = $("#addressError2");
        var cityError = $("#cityError");
        var zipCodeError = $("#zipCodeError");
        userNameError.text("");
        emailError.text("");
        passwordError.text("");
        addressError.text("");
        addressError2.text("");
        cityError.text("");
        zipCodeError.text("");
        if (!userNameRegex.test(userName)) {
        userNameError.text("Invalid User Name. Please use alphanumeric characters.");
        event.preventDefault();
        }
        if (!emailRegex.test(email)) {
        emailError.text("Invalid Email. Please enter a valid email address.");
        event.preventDefault();
        }
        if (!passwordRegex.test(password)) {
        passwordError.text("Invalid Password. It should have a maximum of 8 characters.");
        event.preventDefault();
        }
        if (!addressRegex.test(address)) {
        addressError.text("Invalid Address. Please enter a valid address.");
        event.preventDefault();
        }
        if (!addressRegex2.test(address2)) {
        addressError2.text("Invalid Address. Please enter a valid address.");
        event.preventDefault();
        }
        if (!cityRegex.test(city)) {
        cityError.text("Invalid City. Please enter a valid city name.");
        event.preventDefault();
        }
        if (!zipCodeRegex.test(zipCode)) {
        zipCodeError.text("Invalid Zip Code. Please enter a 5-digit ZIP code.");
        event.preventDefault();
        }
    });
    // End Form Validation

})();

// $(document).keydown(function(e){ 
//     if(e.which === 123){ 
//        return false; 
//     } 
// });

// $(document).bind("contextmenu",function(e) {
// 	e.preventDefault();
// });

// var _z = console;
// Object.defineProperty( window, "console", {
//     get : function(){
//         if( _z._commandLineAPI ){
//         throw "Sorry, Can't execute scripts!";
//             }
//         return _z; 
//     },
//     set : function(val){
//         _z = val;
//     }
// });

// window.console.log = function() {
//     console.error('Sorry , developers tools are blocked here....');
//     window.console.log = function() {
//         return false;
//     }
// }

function showHidePass(element,dom)
{
    const input = document.getElementById(element);
    if (input.type === "password") {
        input.type = "text";

        $('.'+dom).html('<i class="fi fi-rr-eye-crossed"></i>');
    } else {
        input.type = "password";

        $('.'+dom).html('<i class="fi fi-rr-eye"></i>');
    }
}

function isJson(str)
{
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
