const pass1 = document.querySelector('input[name="password"]');
const pass2 = document.querySelector('input[name="password2"]');
const deb = document.querySelector('span.bad_pass');

const eye1 = document.getElementsByClassName("pass_visibility_icon")[0];
const eye2 = document.getElementsByClassName("pass_visibility_icon")[1];

function ValidatePassword(){
    if(pass1.value != "" & pass2.value != "" & pass1.value != pass2.value){
        // jest źle
        deb.textContent = "Podane hasła nie są identyczne.";
    }
    else{
        //jest git
        deb.textContent = "";
    }
}

function fun1(e){
    if(e.target.classList.contains('fa-eye-slash')){
        e.target.classList.remove('fa-eye-slash');
        e.target.classList.add('fa-eye');

        if(e.target.getAttribute('data-pass_ref_nr') == "1"){
            pass1.type="password";
        }
        else if(e.target.getAttribute('data-pass_ref_nr') == "2"){
            pass2.type="password";
        }
    }
    else{
        e.target.classList.remove('fa-eye');
        e.target.classList.add('fa-eye-slash');

        if(e.target.getAttribute('data-pass_ref_nr') == "1"){
            pass1.type="text";
        }
        else if(e.target.getAttribute('data-pass_ref_nr') == "2"){
            pass2.type="text";
        }
    }
};

eye1.addEventListener('click', fun1);
eye2.addEventListener('click', fun1);

setInterval(ValidatePassword, 1000);