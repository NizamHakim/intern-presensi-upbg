const form = document.getElementById('edit-pertemuan-form');
form.addEventListener('submit', async function(e){
    e.preventDefault();

    playFetchingAnimation(form);
    clearErrors(form);
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    const route = form.getAttribute('action');

    const response = await fetchUpdatePertemuan(data, route)
    stopFetchingAnimation(form);

    if(response.ok){
        const json = await response.json();
        window.location.replace(json.redirect);
    }else{
        if(response.status === 422){
            const errors = await response.json();
            for(const key in errors){
                const input = form.querySelector(`[name="${key}"]`);
                const inputGroup = input.closest('.input-group');
                const error = createErrorText(errors[key][0]);
                inputGroup.appendChild(error);
            }
        }else{
            createToast('error', 'Terjadi kesalahan. Silahkan coba lagi.');
        }
    }
});

const terlaksana = form.querySelector('[name="terlaksana"]');
terlaksana.addEventListener('change', function(){
    const warning = document.querySelector('.terlaksana-warning');
    if(warning){
        warning.remove();
    }
    const inputDropdown = terlaksana.closest('.input-dropdown');
    if(terlaksana.value === '0'){
        const warning = document.createElement('div');
        warning.setAttribute('class', 'terlaksana-warning flex flex-col justify-start p-4 bg-red-100 rounded-md');
        warning.innerHTML = `
            <p class="text-red-600 font-semibold mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Peringatan</p>
            <p class="text-red-600">Mengubah status pertemuan menjadi <span class="font-semibold">tidak terlaksana</span> berarti <span class="font-semibold">menghapus daftar presensi</span> untuk pertemuan ini secara permanen!</p>
        `;
        inputDropdown.insertAdjacentElement('afterend', warning);
    }else if(terlaksana.value === '1'){
        const warning = document.createElement('div');
        warning.setAttribute('class', 'terlaksana-warning flex flex-col justify-start p-4 bg-green-100 rounded-md');
        warning.innerHTML = `
            <p class="text-green-600 font-semibold mb-2"><i class="fa-solid fa-circle-info mr-2"></i> Info</p>
            <p class="text-green-600">Mengubah status pertemuan menjadi <span class="font-semibold">terlaksana</span> akan <span class="font-semibold">membuat daftar presensi</span> untuk pertemuan ini.</p>
        `;
        inputDropdown.insertAdjacentElement('afterend', warning);
    }
})

function fetchUpdatePertemuan(data, route){
    return fetch(route, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(data),
    })
}

function playFetchingAnimation(form){
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.classList.add('hidden');

    const loading = document.createElement('button');
    loading.setAttribute('class', 'button-loading flex flex-row items-center justify-center font-semibold px-10 py-2 border border-upbg bg-white rounded-md cursor-progress');
    loading.setAttribute('disabled', 'true');
    loading.innerHTML = createLoadingAnimation('Validating...', 'blue');
    submitButton.insertAdjacentElement('afterend', loading);
}

function stopFetchingAnimation(form){
    const loading = form.querySelector('.button-loading');
    loading.remove();
    
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.classList.remove('hidden');
}