function openDialog(deleteDialog){
    const deleteDialogContent = deleteDialog.querySelector('.delete-dialog-content');
    const body = document.querySelector('body');

    const forceDelete = deleteDialogContent.querySelector('[name="force-delete"]');
    if(forceDelete){
        forceDelete.checked = false;
    }

    deleteDialog.classList.replace('hidden', 'flex');
    setTimeout(() => {
        deleteDialog.classList.replace('opacity-0', 'opacity-100');
        deleteDialogContent.classList.replace('-translate-y-5', 'translate-y-0');
        body.classList.remove('overflow-y-scroll');
        body.classList.add('overflow-y-hidden', 'pr-[10px]');
    }, 100);

    const cancelButton = deleteDialogContent.querySelector('.cancel-button');
    function handleCancel(e){
        e.stopPropagation();
        closeDialog(deleteDialog, closeCallback);
    }
    cancelButton.addEventListener('click', handleCancel);

    function handleClickOutside(e){
        e.stopPropagation();
        const dimensions = deleteDialogContent.getBoundingClientRect();
        if(e.clientX < dimensions.left || e.clientX > dimensions.right || e.clientY < dimensions.top || e.clientY > dimensions.bottom){
            closeDialog(deleteDialog, closeCallback); 
        }
    }
    document.addEventListener('click', handleClickOutside);

    function closeCallback(){
        cancelButton.removeEventListener('click', handleCancel);
        document.removeEventListener('click', handleClickOutside);
    }
}

function closeDialog(deleteDialog, callback){
    const deleteDialogContent = deleteDialog.querySelector('.delete-dialog-content');
    const body = document.querySelector('body');

    deleteDialogContent.classList.replace('translate-y-0', '-translate-y-5');
    deleteDialog.classList.replace('opacity-100', 'opacity-0');

    deleteDialog.addEventListener('transitionend', handleTransitionEnd);
    function handleTransitionEnd(e){
        if(e.propertyName === 'opacity'){
            deleteDialog.classList.replace('flex', 'hidden');
            body.classList.remove('overflow-y-hidden', 'pr-[10px]');
            body.classList.add('overflow-y-scroll');
            deleteDialog.removeEventListener('transitionend', handleTransitionEnd);
        }
    }
    
    callback();
}