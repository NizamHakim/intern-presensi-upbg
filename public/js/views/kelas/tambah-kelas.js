const tambahKelasForm = document.querySelector('.tambah-kelas-form');
tambahKelasForm.addEventListener('submit', async function(e){
    e.preventDefault();
    clearErrors(tambahKelasForm);
    const route = tambahKelasForm.getAttribute('action');
    const submitButton = e.submitter;

    const formData = new FormData(tambahKelasForm);
    const data = Object.fromEntries(formData);
    delete data['pengajar'];
    delete data['hari'];
    delete data['waktu-mulai'];
    delete data['waktu-selesai'];
    delete data['nik-peserta'];
    delete data['nama-peserta'];
    delete data['occupation-peserta'];
    data['nik-peserta'] = formData.getAll('nik-peserta');
    data['nama-peserta'] = formData.getAll('nama-peserta');
    data['occupation-peserta'] = formData.getAll('occupation-peserta');
    data['pengajar'] = formData.getAll('pengajar');
    data['hari'] = formData.getAll('hari');
    data['waktu-mulai'] = formData.getAll('waktu-mulai');
    data['waktu-selesai'] = formData.getAll('waktu-selesai');
    console.log(data);
    
    playFetchingAnimation(submitButton, 'green', 'Validating...');
    const response = await fetchRequest(route, 'POST', data);
    stopFetchingAnimation(submitButton);

    if(response.ok){
        const json = await response.json();
        saveToast('success', json.message);
        window.location.replace(json.redirect);
    }else{
        handleError(response, tambahKelasForm);
    }
});