const inputDates = document.querySelectorAll('.input-date');
inputDates.forEach(inputDate => {
    const input = inputDate.querySelector('input');
    if(inputDate.dataset.plugin === 'default'){
        flatpickr(input, {
            altInput: true,
            altFormat: 'l, j F Y',
            dateFormat: 'Y-m-d',
            defaultDate: input.value,
            disableMobile: true,
            locale: 'id',
        });
    }else if(inputDate.dataset.plugin === 'month'){
        flatpickr(input, {
            altInput: true,
            altFormat: 'F Y',
            defaultDate: input.value,
            disableMobile: true,
            plugins: [
                new monthSelectPlugin({
                    shorthand: true,
                    dateFormat: 'Y-m',
                })
            ],
            locale: 'id',
        })
    }
});

function resetDate(inputDate){
    const input = inputDate.querySelector('input')._flatpickr;
    const defaultDate = inputDate.dataset.default;
    input.setDate(defaultDate, true, "Y-m-d");
}

function changeDateValue(inputDate, value){
    const input = inputDate.querySelector('input')._flatpickr;
    input.setDate(value, true, "H:i");
}

function attachDatepicker(inputDate){
    const input = inputDate.querySelector('input');
    input.value = '';
    flatpickr(input, {
        altInput: true,
        altFormat: 'l, j F Y',
        dateFormat: 'Y-m-d',
        defaultDate: input.value,
        locale: 'id',
    });
}