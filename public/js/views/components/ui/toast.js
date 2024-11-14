document.addEventListener('DOMContentLoaded', () => {
    const toast = document.getElementById('toast');
    
    showToast(toast);
    const toastTimer = setTimeout(() => {
        closeToast(toast);
    }, 3000);

    const closeToastButton = toast.querySelector('.close-toast-button');
    closeToastButton.addEventListener('click', () => {
        clearTimeout(toastTimer);
        closeToast(toast);
    });
}, {once: true});

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

function exceptionToast(){
    const oldToast = document.getElementById('toast');
    if(oldToast){
        closeToast(oldToast);  
    }
    
    const newToast = document.createElement('div');
    newToast.id = 'toast';
    newToast.setAttribute('class', 'fixed hidden transition translate-y-2 duration-300 opacity-0 flex-row gap-4 items-center px-4 py-4 right-5 bottom-10 rounded-md bg-white shadow-strong w-96 z-10 after:absolute after:rounded-bl-md after:bg-red-600 after:h-1 after:bottom-0 after:left-0 after:animate-[toast-progress_3s_linear]');
    newToast.innerHTML = `
        <i class="fa-solid fa-circle-xmark text-red-600 text-3xl mx-1"></i>
        <div class="flex flex-col flex-1">
            <h1 class="text-base font-semibold">Error</h1>
            <p class="text-sm text-gray-600">
                Something went wrong. Please try again.
            </p>
        </div>
        <button type="button" class="close-toast-button bg-white size-6 rounded-full transition hover:bg-gray-100">
            <i class="fa-solid fa-xmark"></i>
        </button>
    `;
    document.body.appendChild(newToast);
    showToast(newToast);
    const toastTimer = setTimeout(() => {
        closeToast(newToast);
    }, 3000);

    const closeToastButton = newToast.querySelector('.close-toast-button');
    closeToastButton.addEventListener('click', () => {
        clearTimeout(toastTimer);
        closeToast(newToast);
    });
}