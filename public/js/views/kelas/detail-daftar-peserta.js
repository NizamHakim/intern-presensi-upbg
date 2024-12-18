const daftarPeserta = document.getElementById('daftar-peserta');
const pesertaContainer = daftarPeserta.querySelector('.peserta-container');

pesertaContainer.addEventListener('click', (e) => {
    if(e.target.closest('.detail-peserta')){
        e.stopPropagation();
        const pesertaItem = e.target.closest('.peserta-item');
        showDetailPesertaModal(pesertaItem);
    }else if(e.target.closest('.delete-peserta')){
        e.stopPropagation();
        const pesertaItem = e.target.closest('.peserta-item');
        showDeletePesertaModal(pesertaItem);
    }else if(e.target.closest('.edit-peserta')){
        e.stopPropagation();
        const pesertaItem = e.target.closest('.peserta-item');
        showDetailPesertaModal(pesertaItem);
    }
})

function showDetailPesertaModal(pesertaItem){
    const namaPeserta = pesertaItem.querySelector('.nama-peserta').textContent;
    const nikPeserta = pesertaItem.querySelector('.nik-peserta').textContent;
    const tanggalBergabungPeserta = pesertaItem.querySelector('.tanggal-bergabung-peserta').textContent;
    const aktifPeserta = pesertaItem.querySelector('.aktif-peserta').textContent;
    const pesertaId = pesertaItem.dataset.pesertaId;
    
    const detailPesertaModal = document.getElementById('detail-peserta-modal');
    const modalNamaPeserta = detailPesertaModal.querySelector('.nama-peserta');
    const modalNikPeserta = detailPesertaModal.querySelector('.nik-peserta');
    const modalTanggalBergabungPeserta = detailPesertaModal.querySelector('.tanggal-bergabung-peserta');
    const modalAktifPeserta = detailPesertaModal.querySelector('[name="aktif"]');
    const modalAktifLabel = detailPesertaModal.querySelector('.label-aktif');
    const inputPesertaId = detailPesertaModal.querySelector('[name="peserta-id"]');

    modalNamaPeserta.textContent = namaPeserta;
    modalNikPeserta.textContent = nikPeserta;
    modalTanggalBergabungPeserta.textContent = tanggalBergabungPeserta;
    modalAktifPeserta.checked = (aktifPeserta == 'Aktif') ? true : false;
    modalAktifLabel.textContent = aktifPeserta;
    inputPesertaId.value = pesertaId;
    
    const closeCallback = openModal(detailPesertaModal, removeEventListeners);

    const modalForm = detailPesertaModal.querySelector('form');
    async function handleSubmit(e){
        e.preventDefault();
        const route = modalForm.getAttribute('action');
        const submitButton = e.submitter;

        const formData = new FormData(modalForm);
        const data = Object.fromEntries(formData.entries());
        playFetchingAnimation(submitButton, 'green', 'Updating...');
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
        modalAktifLabel.textContent = (e.target.checked) ? 'Aktif' : 'Tidak Aktif';
    }
    modalAktifPeserta.addEventListener('change', handleAktifChange);

    const deletePesertaButton = detailPesertaModal.querySelector('.delete-peserta');
    function handleDeletePeserta(e){
        e.stopPropagation();
        closeModal(detailPesertaModal, closeCallback);
        showDeletePesertaModal(pesertaItem);
    }
    deletePesertaButton.addEventListener('click', handleDeletePeserta);

    function removeEventListeners(){
        modalForm.removeEventListener('submit', handleSubmit);
        modalAktifPeserta.removeEventListener('change', handleAktifChange);
        deletePesertaButton.removeEventListener('click', handleDeletePeserta);
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
    const aktifPeserta = pesertaItem.querySelector('.aktif-peserta');
    if(aktif){
        aktifPeserta.textContent = 'Aktif';
        aktifPeserta.classList.remove('bg-red-300', 'text-red-800')
        aktifPeserta.classList.add('bg-green-300', 'text-green-800');
    }else{
        aktifPeserta.textContent = 'Tidak Aktif';
        aktifPeserta.classList.remove('bg-green-300', 'text-green-800');
        aktifPeserta.classList.add('bg-red-300', 'text-red-800');
    }
}