const daftarPeserta = document.getElementById('daftar-peserta');
daftarPeserta.addEventListener('click', (e) => {
  if(e.target.closest('.edit-peserta')){
    e.stopPropagation();
    const pesertaItem = e.target.closest('.peserta-item');
    showDetailPesertaModal(pesertaItem);
  }else if(e.target.closest('.delete-peserta')){
    e.stopPropagation();
    const pesertaItem = e.target.closest('.peserta-item');
    showDeletePesertaModal(pesertaItem);
  }
});

document.addEventListener('click', (e) => {
  if(e.target.closest('#daftar-peserta .menu')){
    e.stopPropagation();
    const menu = e.target.closest('#daftar-peserta .menu');
    const dialog = menu.parentElement.querySelector('.dialog');
    if(!dialog.classList.contains('open')){
      openDialog(dialog);
    }
  }
})

function showDetailPesertaModal(pesertaItem){
    const namaPeserta = pesertaItem.querySelector('.nama-peserta').textContent;
    const nikPeserta = pesertaItem.querySelector('.nik-peserta').textContent;
    const tanggalBergabungPeserta = pesertaItem.querySelector('.tanggal-bergabung-peserta').textContent;
    const statusPeserta = pesertaItem.querySelector('.status-peserta').textContent;
    const pesertaId = pesertaItem.dataset.pesertaId;
    
    const detailPesertaModal = document.getElementById('detail-peserta-modal');
    const modalNamaPeserta = detailPesertaModal.querySelector('.nama-peserta');
    const modalNikPeserta = detailPesertaModal.querySelector('.nik-peserta');
    const modalTanggalBergabungPeserta = detailPesertaModal.querySelector('.tanggal-bergabung-peserta');
    const modalStatusPeserta = detailPesertaModal.querySelector('.status-peserta');
    const inputPesertaId = detailPesertaModal.querySelector('[name="peserta-id"]');

    modalNamaPeserta.textContent = namaPeserta;
    modalNikPeserta.textContent = nikPeserta;
    modalTanggalBergabungPeserta.textContent = tanggalBergabungPeserta;
    modalStatusPeserta.querySelector('.checkbox-label').textContent = statusPeserta;
    modalStatusPeserta.querySelector('input').checked = (statusPeserta === 'Aktif') ? true : false;
    inputPesertaId.value = pesertaId;
    
    const closeCallback = openModal(detailPesertaModal, removeEventListeners);

    const modalForm = detailPesertaModal.querySelector('form');
    async function handleSubmit(e){
        e.preventDefault();
        const route = modalForm.getAttribute('action');
        const submitButton = e.submitter;

        const formData = new FormData(modalForm);
        const data = Object.fromEntries(formData.entries());
        playFetchingAnimation(submitButton, 'blue', 'Updating...');
        const response = await fetchRequest(route, 'PATCH', data);
        stopFetchingAnimation(submitButton);

        if(response.ok){
            const json = await response.json();
            closeModal(detailPesertaModal, closeCallback);
            updateAktifText(pesertaItem, json.aktif);
            createToast('success', json.message);
        }else{
            handleError(response, modalForm);
        }
    }
    modalForm.addEventListener('submit', handleSubmit);

    function handleAktifChange(e){
      modalStatusPeserta.querySelector('.checkbox-label').textContent = (e.target.checked) ? 'Aktif' : 'Tidak Aktif';
    }
    modalStatusPeserta.addEventListener('change', handleAktifChange);

    function removeEventListeners(){
        modalForm.removeEventListener('submit', handleSubmit);
        modalStatusPeserta.removeEventListener('change', handleAktifChange);
    }
}

function showDeletePesertaModal(pesertaItem){
    const namaPeserta = pesertaItem.querySelector('.nama-peserta').textContent;
    const nikPeserta = pesertaItem.querySelector('.nik-peserta').textContent;
    const pesertaId = pesertaItem.dataset.pesertaId;
    
    const deletePesertaModal = document.getElementById('delete-peserta-modal');
    const namaNikPeserta = deletePesertaModal.querySelector('.nama-nik-peserta');
    const inputPesertaId = deletePesertaModal.querySelector('[name="peserta-id"]');

    namaNikPeserta.textContent = `${namaPeserta} - ${nikPeserta}`;
    inputPesertaId.value = pesertaId;

    openModal(deletePesertaModal, removeEventListener);

    const modalForm = deletePesertaModal.querySelector('form');
    async function handleSubmit(e){
        e.preventDefault();
        const route = modalForm.getAttribute('action');
        const submitButton = e.submitter;

        const formData = new FormData(modalForm);
        const data = Object.fromEntries(formData.entries());
        
        playFetchingAnimation(submitButton, 'red', 'Deleting...');
        const response = await fetchRequest(route, 'DELETE', data);
        stopFetchingAnimation(submitButton);

        if(response.ok){
            const json = await response.json();
            saveToast('success', json.message);
            window.location.replace(json.redirect);
        }else{
            handleError(response, modalForm);
        }
    }
    modalForm.addEventListener('submit', handleSubmit);

    function removeEventListener(){
        modalForm.removeEventListener('submit', handleSubmit);
    }
}

function updateAktifText(pesertaItem, aktif){
  const statusPeserta = pesertaItem.querySelector('.status-peserta');
  if(aktif){
    statusPeserta.textContent = 'Aktif';
    statusPeserta.classList.remove('bg-red-300', 'text-red-800')
    statusPeserta.classList.add('bg-green-300', 'text-green-800');
  }else{
    statusPeserta.textContent = 'Tidak Aktif';
    statusPeserta.classList.remove('bg-green-300', 'text-green-800');
    statusPeserta.classList.add('bg-red-300', 'text-red-800');
  }
}