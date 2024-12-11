const daftarPeserta = document.getElementById('daftar-peserta');
if (daftarPeserta) {
    const pesertaContainer = daftarPeserta.querySelector('.peserta-container');
    pesertaContainer.addEventListener('click', (e) => {
        if(e.target.closest('.peserta-content')){
            e.stopPropagation();
            const pesertaContent = e.target.closest('.peserta-content');
            const deletePesertaContainer = pesertaContent.parentElement.querySelector('.delete-peserta-container');
            if(deletePesertaContainer.classList.contains('open')){
                deletePesertaContainer.classList.remove('open');
            }else{
                const deletePesertaContainerOpen = pesertaContainer.querySelector('.delete-peserta-container.open');
                if(deletePesertaContainerOpen){
                    deletePesertaContainerOpen.classList.remove('open');
                }
                deletePesertaContainer.classList.add('open');
            }
        }else if(e.target.closest('.delete-peserta')){
            e.stopPropagation();
            const pesertaItem = e.target.closest('.peserta-item');
            console.log(pesertaItem);
            createDeletePesertaDialog(pesertaItem);
        }
    });

    function createDeletePesertaDialog(pesertaItem){
        const namaPeserta = pesertaItem.querySelector('.nama-peserta').textContent;
        const nikPeserta = pesertaItem.querySelector('.nik-peserta').textContent;

        const deletePesertaDialog = daftarPeserta.querySelector('.delete-peserta-dialog');
        const deleteDialogContent = deletePesertaDialog.querySelector('.delete-dialog-content');
        const namaNikUser = deleteDialogContent.querySelector('.nama-nik-user');
        namaNikUser.textContent = `${namaPeserta} - ${nikPeserta}`;

        const inputId = deletePesertaDialog.querySelector('[name="peserta-id"]');
        inputId.value = pesertaItem.dataset.pesertaId;

        openDialog(deletePesertaDialog);
    }
}