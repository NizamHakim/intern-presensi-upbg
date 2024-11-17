if(document.body.dataset.toastType && document.body.dataset.toastMessage){
    document.addEventListener('DOMContentLoaded', () => {
        createToast(document.body.dataset.toastType, document.body.dataset.toastMessage);
    }, {once: true});
}

function showToast(toast){
    toast.classList.replace('hidden', 'flex');
    setTimeout(() => {
        toast.classList.replace('opacity-0', 'opacity-100');
        toast.classList.replace('translate-y-2', 'translate-y-0');
    }, 100)
}

function closeToast(toast){
    toast.classList.replace('opacity-100', 'opacity-0');
    toast.classList.replace('translate-y-0', 'translate-y-2');
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
    newToast.setAttribute('class', 'fixed hidden transition border-l-4 translate-y-2 duration-300 opacity-0 flex-row gap-4 items-center px-4 py-4 right-5 bottom-10 rounded-md bg-white shadow-strong w-96 z-10 after:absolute after:rounded-bl-md after:h-1 after:bottom-0 after:left-0 after:animate-[toast-progress_2s_linear]');
    
    switch (type) {
        case 'success':
            newToast.classList.add('after:bg-green-600');
            newToast.classList.add('border-green-600');
            newToast.innerHTML = `
                <i class="fa-solid fa-circle-check text-green-600 text-3xl mx-1"></i>
                <div class="flex flex-col flex-1">
                    <h1 class="text-base font-semibold">Success</h1>
                    <p class="text-sm text-gray-600">
                        ${message}
                    </p>
                </div>
                <button type="button" class="close-toast-button bg-white size-6 rounded-full transition hover:bg-gray-100">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;
            break;
        case 'error':
            newToast.classList.add('after:bg-red-600');
            newToast.classList.add('border-red-600');
            newToast.innerHTML = `
                <i class="fa-solid fa-circle-xmark text-red-600 text-3xl mx-1"></i>
                <div class="flex flex-col flex-1">
                    <h1 class="text-base font-semibold">Error</h1>
                    <p class="text-sm text-gray-600">
                        ${message}
                    </p>
                </div>
                <button type="button" class="close-toast-button bg-white size-6 rounded-full transition hover:bg-gray-100">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;
            break;
    }

    document.body.appendChild(newToast);
    showToast(newToast);
    const toastTimer = setTimeout(() => {
        closeToast(newToast);
    }, 2000);

    const closeToastButton = newToast.querySelector('.close-toast-button');
    closeToastButton.addEventListener('click', () => {
        clearTimeout(toastTimer);
        closeToast(newToast);
    });
}