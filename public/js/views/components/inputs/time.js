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
    const input = inputTime.querySelector('input');
    const defaultTime = inputTime.dataset.default;
    input._flatpickr.setDate(defaultTime, true, "H:i");
}