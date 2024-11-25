const inputTimes = document.querySelectorAll('.input-time');
inputTimes.forEach(inputTime => {
    flatpickr(inputTime, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        defaultDate: inputTime.value,
        time_24hr: true,
        locale: 'id',
    });
});