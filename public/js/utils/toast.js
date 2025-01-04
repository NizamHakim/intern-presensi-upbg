document.addEventListener('DOMContentLoaded', () => {
    const toast = sessionStorage.getItem('toast');
    if(toast){
        const {type, message} = JSON.parse(toast);
        createToast(type, message);
        sessionStorage.removeItem('toast');
    }
});

function saveToast(type, message){
    sessionStorage.setItem('toast', JSON.stringify({type, message}));
}

function showToast(toast){
    toast.classList.replace('hidden', 'flex');
    setTimeout(() => {
        toast.classList.add('show');
    }, 100)
}

function closeToast(toast){
    toast.classList.remove('show');
    toast.addEventListener('transitionend', () => {
        toast.classList.replace('flex', 'hidden');
        toast.remove();
    });
}

function createToast(type, message){
    const oldToast = document.getElementById('toast');
    if(oldToast){
        closeToast(oldToast);  
    }

    const newToast = document.createElement('div');
    newToast.id = 'toast';
    newToast.setAttribute('class', 'hidden toast');

    switch (type) {
        case 'success':
            newToast.classList.add('toast-success');
            newToast.innerHTML = `
                <i class="fa-solid fa-circle-check text-green-600 text-3xl mx-1"></i>
                <div class="flex flex-col flex-1">
                    <h1 class="text-base font-semibold">Success</h1>
                    <p class="text-sm text-gray-600 font-normal">
                        ${message}
                    </p>
                </div>
                <button type="button" class="close-toast-button btn-rounded btn-white size-7 shadow-none border-none">
                    <i class="fa-solid fa-xmark text-gray-600"></i>
                </button>
            `;
            break;
        case 'error':
            newToast.classList.add('toast-error');
            newToast.innerHTML = `
                <i class="fa-solid fa-circle-xmark text-red-600 text-3xl mx-1"></i>
                <div class="flex flex-col flex-1">
                    <h1 class="text-base font-semibold">Error</h1>
                    <p class="text-sm text-gray-600 font-normal">
                        ${message}
                    </p>
                </div>
                <button type="button" class="close-toast-button btn-rounded btn-white size-7 shadow-none border-none">
                    <i class="fa-solid fa-xmark text-gray-600"></i>
                </button>
            `;
            break;
    }

    document.body.appendChild(newToast);
    showToast(newToast);

    let toastTimer = null;
    if(type == 'success'){
        toastTimer = setTimeout(() => {
            closeToast(newToast);
        }, 2500);
    }

    const closeToastButton = newToast.querySelector('.close-toast-button');
    closeToastButton.addEventListener('click', () => {
        if(toastTimer){
            clearTimeout(toastTimer);
        }
        closeToast(newToast);
    });
}