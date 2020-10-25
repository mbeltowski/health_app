const form_el = document.getElementsByClassName('add_pora_form')[0];
const hide_btn_el = document.getElementsByClassName('hide_form')[0];
const show_form_btn_el = document.getElementsByClassName('add_pora_dnia_btn')[0];

function show(){
    form_el.style.display = "flex";
}

function hide(){
    form_el.style.display = "none";
}

show_form_btn_el.addEventListener('click', show);
hide_btn_el.addEventListener('click', hide);