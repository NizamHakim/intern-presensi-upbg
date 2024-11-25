const countdown = document.querySelector('.countdown');

if(countdown){
    const targetDate = new Date(countdown.dataset.waktuMulai).getTime();

    const timerInterval = setInterval(() => {
        const now = new Date().getTime();
        const timeRemaining = targetDate - now;
    
        const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
    
        countdown.innerHTML = `
            ${days}d ${hours}h ${minutes}m ${seconds}s
        `;
    
        if (timeRemaining < 0) {
            clearInterval(timerInterval);
            const countdownLabel = document.querySelector('.countdown-label');
            const countdownFinished = document.createElement('div');
            countdownFinished.setAttribute('class', 'countdown-finished flex flex-col justify-start p-4 bg-blue-100 rounded-md');
            countdownFinished.innerHTML = `
                <p class="text-upbg font-semibold">Silahkan refresh halaman untuk memulai pertemuan</p>
            `;
            countdownLabel.replaceWith(countdownFinished);
        }
    }, 1000);
}
