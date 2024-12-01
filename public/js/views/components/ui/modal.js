function openModal(modal, callback = null){
    const modalContent = modal.querySelector('.modal-content');
    const body = document.querySelector('body');

    modal.classList.replace('hidden', 'flex');
    setTimeout(() => {
        modal.classList.replace('opacity-0', 'opacity-100');
        modalContent.classList.replace('-translate-y-5', 'translate-y-0');
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
        e.stopPropagation();
        const dimensions = modalContent.getBoundingClientRect();
        if(e.clientX < dimensions.left || e.clientX > dimensions.right || e.clientY < dimensions.top || e.clientY > dimensions.bottom){
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

    modalContent.classList.replace('translate-y-0', '-translate-y-5');
    modal.classList.replace('opacity-100', 'opacity-0');

    modal.addEventListener('transitionend', handleTransitionEnd);

    function handleTransitionEnd(e){
        if(e.propertyName === 'opacity'){
            modal.classList.replace('flex', 'hidden');
            body.classList.remove('overflow-y-hidden', 'pr-[10px]');
            body.classList.add('overflow-y-scroll');
            modal.removeEventListener('transitionend', handleTransitionEnd);
        }
    }
    
    const form = modalContent.querySelector('form');
    if(form) resetForm(form);
    
    callback();
}

function resetForm(form){
    const dropdowns = form.querySelectorAll('.input-dropdown');
    dropdowns.forEach(dropdown => {
        resetDropdownValue(dropdown);
    });
    const dateInputs = form.querySelectorAll('.input-date');
    dateInputs.forEach(dateInput => {
        resetDate(dateInput);
    });
    const timeInputs = form.querySelectorAll('.input-time');
    timeInputs.forEach(timeInput => {
        resetTime(timeInput);
    });
    clearErrors(form);
}