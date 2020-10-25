const select_template_el = document.getElementsByClassName('food_select_input')[0];
const input_template_el = document.getElementsByClassName('food_amount_input')[0];

const add_btn_el = document.getElementById('add_food_select_btn');
const select_parent_el = select_template_el.parentElement;

let index = 2;

function add_select(){

    if(index < 7){
        newSelect_el = select_template_el.cloneNode(true);
        newInput_el = input_template_el.cloneNode(true);
    
        newSelect_el.name = newSelect_el.name + (index);
        newInput_el.name = newInput_el.name + (index);
        select_template_el.after(newSelect_el);
        select_template_el.after(newInput_el);
    
        index++;
    }
}

add_btn_el.addEventListener('click', add_select);