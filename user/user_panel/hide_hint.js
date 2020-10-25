const btn_element = document.getElementsByClassName('daily_hint_hide')[0];
const btn_parent_element = document.getElementsByClassName('daily_hint_hide')[0].parentElement;

function name(){
    btn_parent_element.remove();
}


btn_element.addEventListener('click', name);