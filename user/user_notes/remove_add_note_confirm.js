const add_note_btn_element = document.getElementsByClassName('add_note_confirm_btn')[0];
const add_note_btn_parent_element = add_note_btn_element.parentElement;

function name(){
    add_note_btn_parent_element.remove();
}

add_note_btn_element.addEventListener('click', name);