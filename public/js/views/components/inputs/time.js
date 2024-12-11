const inputTimes = document.querySelectorAll('.input-time');
inputTimes.forEach(inputTime => {
    const input = inputTime.querySelector('input');
    flatpickr(input, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        defaultDate: input.value,
        time_24hr: true,
        locale: 'id',
    });
});

function resetTime(inputTime){
    const input = inputTime.querySelector('input')._flatpickr;
    const defaultTime = inputTime.dataset.default;
    input.setDate(defaultTime, true, "H:i");
}

function changeTimeValue(inputTime, value){
    const input = inputTime.querySelector('input')._flatpickr;
    input.setDate(value, true, "H:i");
}

function attachTimepicker(inputTime){
    const input = inputTime.querySelector('input');
    const fp = flatpickr(input, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        defaultDate: input.value,
        time_24hr: true,
        locale: 'id',
    });
    // return fp;
}