const food_calories_array = document.getElementsByClassName('food_calories');
const food_proteins_array = document.getElementsByClassName('food_proteins');
const food_fats_array = document.getElementsByClassName('food_fats');
const food_sugars_array = document.getElementsByClassName('food_sugars');
const food_amount_array = document.getElementsByClassName('food_amount_p');

const summary_element = document.getElementsByClassName('summary_box')[0];



const element_to_remove = document.getElementsByClassName('meals_container')[0];

let AreMeals = document.getElementsByClassName('meal_ul')[0];

if(AreMeals == undefined){
    element_to_remove.remove();
}



let calories_SUM = 0;
let proteins_SUM = 0;
let fats_SUM = 0;
let sugars_SUM = 0;


for(i = 0; i < food_calories_array.length; i++ ){
    calories_SUM += (parseFloat(food_calories_array[i].textContent) * parseFloat(food_amount_array[i].textContent));
}
for(i = 0; i < food_proteins_array.length; i++ ){
    proteins_SUM += (parseFloat(food_proteins_array[i].textContent) * parseFloat(food_amount_array[i].textContent));
}
for(i = 0; i < food_fats_array.length; i++ ){
    fats_SUM += (parseFloat(food_fats_array[i].textContent) * parseFloat(food_amount_array[i].textContent));
}
for(i = 0; i < food_sugars_array.length; i++ ){
    sugars_SUM += (parseFloat(food_sugars_array[i].textContent) * parseFloat(food_amount_array[i].textContent));
}

if(calories_SUM != 0 && proteins_SUM != 0 && fats_SUM != 0 && sugars_SUM != 0){
    let cal_box = document.createElement('div');
    cal_box.classList.add("summary_child");
    cal_box.textContent = calories_SUM;
    
    let prot_box = document.createElement('div');
    prot_box.classList.add("summary_child");
    prot_box.textContent = proteins_SUM;
    
    let fats_box = document.createElement('div');
    fats_box.classList.add("summary_child");
    fats_box.textContent = fats_SUM;
    
    let sug_box = document.createElement('div');
    sug_box.classList.add("summary_child");
    sug_box.textContent = sugars_SUM;
    
    summary_element.appendChild(cal_box);
    summary_element.appendChild(prot_box);
    summary_element.appendChild(fats_box);
    summary_element.appendChild(sug_box);
}