const inputDates = document.querySelectorAll('.input-date');
inputDates.forEach(inputDate => {
    flatpickr(inputDate, {
        altInput: true,
        altFormat: 'l, j F Y',
        dateFormat: 'Y-m-d',
        defaultDate: inputDate.value,
        locale: 'id',
    });
});