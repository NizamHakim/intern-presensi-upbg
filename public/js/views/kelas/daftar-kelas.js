const resetFilterButton = document.querySelector('.reset-filter');
resetFilterButton.addEventListener('click', function(){
    const inputsDropdown = document.querySelectorAll('.filter-field.input-dropdown');
    inputsDropdown.forEach(inputDropdown => {
        resetInputDropdown(inputDropdown);
    });

    const inputsNumber = document.querySelectorAll('.filter-field.input-number');
    inputsNumber.forEach(inputNumber => {
        resetInputNumber(inputNumber);
    });

    const inputsDate = document.querySelectorAll('.filter-field.input-date');
    inputsDate.forEach(inputDate => {
        resetInputDate(inputDate);
    });
})

function resetInputDropdown(inputDropdown){
    const firstOption = inputDropdown._x_dataStack[0].options[0];
    inputDropdown._x_dataStack[0].selected = firstOption;
}

function resetInputNumber(inputNumber){
    inputNumber.value = '';
}

function resetInputDate(inputDate){
    inputDate.value = '';
}