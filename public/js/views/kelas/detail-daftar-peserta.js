const deleteKelas = document.querySelector('.delete-kelas');
if(deleteKelas){
    deleteKelas.addEventListener('click', function(e){
        e.stopPropagation();
        const deleteKelasDialog = document.querySelector('.delete-kelas-dialog');
        openDialog(deleteKelasDialog);
    });
}

const daftarPesertaSection = document.getElementById('daftar-peserta');
if(daftarPesertaSection){
    const daftarPesertaTable = daftarPesertaSection.querySelector('table');
    daftarPesertaTable.addEventListener('click', (e) => {
        if(e.target.closest('.delete-peserta')){
            e.stopPropagation();
            const row = e.target.closest('tr');
            showDeleteDialog(row);
        }
    });
}

function showDeleteDialog(row){
    const namaPeserta = row.querySelector('.nama-peserta').textContent;
    const nikPeserta = row.querySelector('.nik-peserta').textContent;
    const deletePresensiDialog = document.querySelector('.delete-peserta-dialog');
    const deleteDialogContent = deletePresensiDialog.querySelector('.delete-dialog-content');
    const namaNikUser = deleteDialogContent.querySelector('.nama-nik-user');
    namaNikUser.textContent = `${namaPeserta} - ${nikPeserta}`;

    const inputId = deletePresensiDialog.querySelector('input[name="peserta-id"]');
    inputId.value = row.dataset.pesertaId;

    openDialog(deletePresensiDialog);
}