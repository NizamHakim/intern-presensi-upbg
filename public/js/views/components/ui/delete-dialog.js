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
        deleteDialogContent.classList.replace('scale-0', 'scale-100');
        body.classList.remove('overflow-y-scroll');
        body.classList.add('overflow-y-hidden', 'pr-[10px]');
    }, 100);

    const cancelButton = deleteDialogContent.querySelector('.cancel-button');
    function handleCancel(e){
        e.stopPropagation();
        closeDialog(deleteDialog, () => {
            cancelButton.removeEventListener('click', handleCancel);
            document.removeEventListener('click', handleClickOutside);
        });
    }
    cancelButton.addEventListener('click', handleCancel);

    function handleClickOutside(e){
        if(!deleteDialogContent.contains(e.target)){
            closeDialog(deleteDialog, () => {
                cancelButton.removeEventListener('click', handleCancel);
                document.removeEventListener('click', handleClickOutside);
            });
        }
    }
    document.addEventListener('click', handleClickOutside);
}

function closeDialog(deleteDialog, callback){
    const deleteDialogContent = deleteDialog.querySelector('.delete-dialog-content');
    const body = document.querySelector('body');

    deleteDialogContent.classList.replace('scale-100', 'scale-0');
    deleteDialog.classList.replace('opacity-100', 'opacity-0');

    deleteDialogContent.addEventListener('transitionend', () => {
        deleteDialog.classList.replace('flex', 'hidden');
        body.classList.remove('overflow-y-hidden', 'pr-[10px]');
        body.classList.add('overflow-y-scroll');
    }, {once: true});
    
    callback();
}