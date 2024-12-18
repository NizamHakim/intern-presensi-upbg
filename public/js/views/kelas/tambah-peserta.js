const tambahPesertaForm = document.querySelector('.tambah-peserta-form');
tambahPesertaForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    clearErrors(tambahPesertaForm);
    const route = tambahPesertaForm.getAttribute('action');
    const submitButton = e.submitter;

    const form = e.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    delete data['nik-peserta'];
    delete data['nama-peserta'];
    delete data['occupation-peserta'];
    data['nik-peserta'] = formData.getAll('nik-peserta');
    data['nama-peserta'] = formData.getAll('nama-peserta');
    data['occupation-peserta'] = formData.getAll('occupation-peserta');
    
    playFetchingAnimation(submitButton, 'green', 'Validating...');
    const response = await fetchRequest(route, 'POST', data);
    stopFetchingAnimation(submitButton);

    if(response.ok){
        const json = await response.json();
        saveToast('success', json.message);
        window.location.replace(json.redirect);
    }else{
        handleError(response, tambahPesertaForm);
    }
});