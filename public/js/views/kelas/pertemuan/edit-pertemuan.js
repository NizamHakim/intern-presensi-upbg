const form = document.getElementById('edit-pertemuan-form');
form.addEventListener('submit', async function(e){
    e.preventDefault();
    clearErrors(form);
    const route = form.action;
    const submitButton = e.submitter;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);

    playFetchingAnimation(submitButton, 'blue', 'Validating...');
    const response = await fetchRequest(route, 'PUT', data);
    stopFetchingAnimation(submitButton);

    if(response.ok){
        const json = await response.json();
        saveToast('success', json.message);
        window.location.replace(json.redirect);
    }else{
        handleError(response, form);
    }
});

const terlaksanaDropdown = form.querySelector('.terlaksana-dropdown');
terlaksanaDropdown.addEventListener('change', function(){
    const warning = document.querySelector('.terlaksana-warning');
    if(warning){
        warning.remove();
    }
    const terlaksana = terlaksanaDropdown.querySelector('[name="terlaksana"]');
    if(terlaksana.value === '0'){
        const warning = document.createElement('div');
        warning.setAttribute('class', 'terlaksana-warning flex flex-col justify-start p-4 bg-red-100 rounded-sm-md mt-2');
        warning.innerHTML = `
            <p class="text-red-600 font-semibold mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Peringatan</p>
            <p class="text-red-600">Mengubah status pertemuan menjadi <span class="font-semibold">tidak terlaksana</span> berarti <span class="font-semibold">menghapus daftar presensi</span> untuk pertemuan ini secara permanen!</p>
        `;
        terlaksanaDropdown.insertAdjacentElement('afterend', warning);
    }else if(terlaksana.value === '1'){
        const warning = document.createElement('div');
        warning.setAttribute('class', 'terlaksana-warning flex flex-col justify-start p-4 bg-green-100 rounded-sm-md mt-2');
        warning.innerHTML = `
            <p class="text-green-600 font-semibold mb-2"><i class="fa-solid fa-circle-info mr-2"></i> Info</p>
            <p class="text-green-600">Mengubah status pertemuan menjadi <span class="font-semibold">terlaksana</span> akan <span class="font-semibold">membuat daftar presensi</span> untuk pertemuan ini.</p>
        `;
        terlaksanaDropdown.insertAdjacentElement('afterend', warning);
    }
})