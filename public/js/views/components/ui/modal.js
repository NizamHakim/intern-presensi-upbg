function openModal(modal, callback = null){
    const modalContent = modal.querySelector('.modal-content');
    const body = document.querySelector('body');

    modal.classList.replace('hidden', 'flex');
    setTimeout(() => {
        modal.classList.replace('opacity-0', 'opacity-100');
        modalContent.classList.replace('scale-0', 'scale-100');
        body.classList.remove('overflow-y-scroll');
        body.classList.add('overflow-y-hidden', 'pr-[10px]');
    }, 100);

    const cancelButton = modalContent.querySelector('.cancel-button');
    function handleCancel(e){
        e.stopPropagation();
        closeModal(modal, closeCallback);
    }
    cancelButton.addEventListener('click', handleCancel);

    function handleClickOutside(e){
        if(!modalContent.contains(e.target) &&  e.target.closest('.flatpickr-calendar') === null){ 
            // bug on flatpickr, prevent closing modal when clicking datepicker
            closeModal(modal, closeCallback);
        }
    }
    document.addEventListener('click', handleClickOutside);
    
    function closeCallback(){
        cancelButton.removeEventListener('click', handleCancel);
        document.removeEventListener('click', handleClickOutside);
        if(callback) callback();
    }

    return closeCallback;
}

function closeModal(modal, callback){
    const modalContent = modal.querySelector('.modal-content');
    const body = document.querySelector('body');

    modalContent.classList.replace('scale-100', 'scale-0');
    modal.classList.replace('opacity-100', 'opacity-0');

    modalContent.addEventListener('transitionend', () => {
        modal.classList.replace('flex', 'hidden');
        body.classList.remove('overflow-y-hidden', 'pr-[10px]');
        body.classList.add('overflow-y-scroll');
    }, {once: true});
    
    callback();
}