const inputDates = document.querySelectorAll('.input-date');
inputDates.forEach(inputDate => {
    const input = inputDate.querySelector('input');
    flatpickr(input, {
        altInput: true,
        altFormat: 'l, j F Y',
        dateFormat: 'Y-m-d',
        defaultDate: input.value,
        locale: 'id',
    });
});

function resetDate(inputDate){
    const input = inputDate.querySelector('input');
    const defaultDate = inputDate.dataset.default;
    input._flatpickr.setDate(defaultDate, true, "Y-m-d");
}