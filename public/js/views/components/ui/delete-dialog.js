function openDialog(){
    const deleteDialog = document.getElementById('delete-dialog');
    const deleteDialogContent = document.getElementById('delete-dialog-content');

    const forceDelete = deleteDialogContent.querySelector('[name="force-delete"]');
    if(forceDelete){
        forceDelete.checked = false;
    }

    deleteDialog.classList.replace('hidden', 'flex');
    setTimeout(() => {
        deleteDialog.classList.replace('opacity-0', 'opacity-100');
        deleteDialogContent.classList.replace('scale-0', 'scale-100');
    }, 100);

    const cancelButton = deleteDialogContent.querySelector('.cancel-button');
    function handleCancel(e){
        e.stopPropagation();
        closeDialog(() => {
            cancelButton.removeEventListener('click', handleCancel);
            document.removeEventListener('click', handleClickOutside);
        });
    }
    cancelButton.addEventListener('click', handleCancel);

    function handleClickOutside(e){
        if(!deleteDialogContent.contains(e.target)){
            closeDialog(() => {
                cancelButton.removeEventListener('click', handleCancel);
                document.removeEventListener('click', handleClickOutside);
            });
        }
    }
    document.addEventListener('click', handleClickOutside);
}

function closeDialog(callback){
    const deleteDialogContent = document.getElementById('delete-dialog-content');
    deleteDialogContent.classList.replace('scale-100', 'scale-0');

    const deleteDialog = document.getElementById('delete-dialog');
    deleteDialog.classList.replace('opacity-100', 'opacity-0');

    deleteDialogContent.addEventListener('transitionend', () => {
        deleteDialog.classList.replace('flex', 'hidden');
    }, {once: true});
    
    callback();
}