const deletePertemuanButton = document.querySelector('.delete-pertemuan');
deletePertemuanButton.addEventListener('click', (e) => {
    e.stopPropagation();
    const deletePertemuanDialog = document.querySelector('.delete-pertemuan-dialog');
    openDialog(deletePertemuanDialog);
});

const editTopikCatatanButton = document.querySelector('.edit-topik-catatan');
editTopikCatatanButton.addEventListener('click', (e) => {
    e.stopPropagation();
    startEditing(editTopikCatatanButton);
});

function startEditing(editTopikCatatanButton){
    editTopikCatatanButton.classList.add('hidden');
    const topikCatatanSection = document.getElementById('topik-catatan');

    const buttonContainer = document.createElement('div');
    buttonContainer.setAttribute('class', 'button-container flex flex-row justify-end gap-4');

    const cancelButton = document.createElement('button');
    cancelButton.setAttribute('class', 'text-gray-800 text-center font-medium text-sm rounded-md px-6 py-2 h-fit bg-white transition duration-300 hover:bg-gray-100')
    cancelButton.textContent = 'Cancel';
    buttonContainer.appendChild(cancelButton);

    cancelButton.addEventListener('click', (e) => {
        e.stopPropagation();
        stopEditing(editTopikCatatanButton);
    });

    const simpanButton = document.createElement('button');
    simpanButton.setAttribute('class', 'text-white text-center font-medium text-sm rounded-md px-6 py-2 h-fit bg-upbg transition duration-300 hover:bg-upbg-dark')
    simpanButton.textContent = 'Simpan';
    buttonContainer.appendChild(simpanButton);

    simpanButton.addEventListener('click', async (e) => {
        e.stopPropagation();

        playFetchingAnimation(simpanButton);
        clearErrors(topikCatatanSection);
        const response = await fetchTopikCatatan(topikCatatanSection.dataset.slug, topikCatatanSection.dataset.id);
        stopFetchingAnimation(simpanButton);

        if(response.ok){
            const json = await response.json();
            updateText(json, topikText, catatanText);
            stopEditing(editTopikCatatanButton);
            createToast('success', json.message);
        }else{
            if(response.status === 422){
                const errors = await response.json();
                for(const key in errors){
                    const input = topikCatatanSection.querySelector(`textarea[name="${key}"]`);
                    const inputGroup = input.closest('.input-group');
                    const error = createErrorText(errors[key][0]);
                    inputGroup.appendChild(error);
                }
            }else{
                createToast('error', 'Terjadi kesalahan. Silahkan coba lagi.');
            }
        }
    });

    topikCatatanSection.appendChild(buttonContainer);


    const topikContainer = topikCatatanSection.querySelector('.topik');
    const topikText = topikContainer.querySelector('p');
    topikText.classList.add('hidden');

    const topikTextArea = document.createElement('textarea');
    topikTextArea.setAttribute('class', 'resize-none text-gray-600 w-full h-24 p-2 rounded-md border bg-gray-100 outline outline-1.5 outline-transparent outline-offset-0 transition-all duration-300 focus:outline-upbg-light');
    topikTextArea.setAttribute('placeholder', 'Topik bahasan pertemuan ini');
    topikTextArea.textContent = (topikText.textContent != '-') ? topikText.textContent : '';
    topikContainer.appendChild(topikTextArea);

    const catatanContainer = topikCatatanSection.querySelector('.catatan');
    const catatanText = catatanContainer.querySelector('p');
    catatanText.classList.add('hidden');

    const catatanTextArea = document.createElement('textarea');
    catatanTextArea.setAttribute('class', 'resize-none text-gray-600 w-full h-24 p-2 rounded-md border bg-gray-100 outline outline-1.5 outline-transparent outline-offset-0 transition-all duration-300 focus:outline-upbg-light');
    catatanTextArea.setAttribute('placeholder', 'Catatan untuk admin');
    catatanTextArea.textContent = (catatanText.textContent != '-') ? catatanText.textContent : '';
    catatanContainer.appendChild(catatanTextArea);
}

function stopEditing(editTopikCatatanButton){
    editTopikCatatanButton.classList.remove('hidden');

    const topikCatatanSection = document.getElementById('topik-catatan');
    const buttonContainer = topikCatatanSection.querySelector('.button-container');
    buttonContainer.remove();

    const topikContainer = topikCatatanSection.querySelector('.topik');
    const topikText = topikContainer.querySelector('p');
    topikText.classList.remove('hidden');

    const topikTextArea = topikContainer.querySelector('textarea');
    topikTextArea.remove();

    const catatanContainer = topikCatatanSection.querySelector('.catatan');
    const catatanText = catatanContainer.querySelector('p');
    catatanText.classList.remove('hidden');

    const catatanTextArea = catatanContainer.querySelector('textarea');
    catatanTextArea.remove();
}

function fetchTopikCatatan(slug, id){
    const topikTextArea = document.querySelector('.topik textarea');
    const catatanTextArea = document.querySelector('.catatan textarea');

    return fetch(`/kelas/${slug}/pertemuan/${id}/updateTopikCatatan`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            topik: topikTextArea.value,
            catatan: catatanTextArea.value
        })
    })
}

function updateText(json, topikText, catatanText){
    topikText.innerHTML = (json.topik) ? json.topik : '-';
    catatanText.innerHTML = (json.catatan) ? json.catatan : '-';
}

function playFetchingAnimation(button){
    button.classList.add('hidden');

    const loading = document.createElement('button');
    loading.setAttribute('class', 'button-loading text-sm flex flex-row items-center justify-center font-semibold px-10 py-2 border border-upbg bg-white rounded-md cursor-progress');
    loading.setAttribute('disabled', 'true');
    loading.innerHTML = createLoadingAnimation('Updating...', 'blue');
    button.insertAdjacentElement('afterend', loading);
}

function stopFetchingAnimation(button){
    const loading = button.nextElementSibling;
    loading.remove();
    
    button.classList.remove('hidden');
}

const daftarPresensi = document.getElementById('daftar-presensi'); 
if(daftarPresensi) {
    const daftarPresensiTable = daftarPresensi.querySelector('table');
    daftarPresensiTable.addEventListener('submit', async (e) => {
        if(e.target.matches('.form-toggle-kehadiran')){
            e.preventDefault();
            const form = e.target;
            const route = form.action;
            const hadir = e.submitter.value;
            const response = await fetchUpdatePresensi(route, hadir);
            if(response.ok){
                togglePresensiButton(form, hadir);
            }else{
                createToast('error', 'Terjadi kesalahan. Silahkan coba lagi.');
            }
        }
    });

    daftarPresensiTable.addEventListener('click', (e) => {
        if(e.target.closest('.delete-presensi')){
            e.stopPropagation();
            const row = e.target.closest('tr');
            showDeleteDialog(row);
        }
    })

    const tandaiSemuaHadirButton = daftarPresensi.querySelector('.tandai-semua-hadir');
    tandaiSemuaHadirButton.addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const route = form.action;

        tandaiSemuaHadirButton.classList.add('hidden');
        const loading = document.createElement('button');
        loading.setAttribute('class', 'button-loading text-sm flex flex-row items-center justify-center font-semibold px-10 py-2 border border-green-600 bg-white rounded-md cursor-progress');
        loading.setAttribute('disabled', 'true');
        loading.innerHTML = createLoadingAnimation('Updating...', 'green');
        form.insertAdjacentElement('afterend', loading);

        const response = await fetchTandaiSemuaHadir(route);
        loading.remove();
        tandaiSemuaHadirButton.classList.remove('hidden');

        if(response.ok){
            const hadirButtons = document.querySelectorAll('.button-hadir');
            hadirButtons.forEach(button => {
                button.classList.add('active');
                button.nextElementSibling.classList.remove('active');
            });
        }else{
            createToast('error', 'Terjadi kesalahan. Silahkan coba lagi.');
        }
    });
}

function fetchUpdatePresensi(route, hadir){
    return fetch(route, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            hadir: hadir
        })
    });
}

function togglePresensiButton(form, hadir){
    const hadirButton = form.querySelector('.button-hadir');
    const buttonAlfa = form.querySelector('.button-alfa');
    if(hadir == 1){
        hadirButton.classList.add('active');
        buttonAlfa.classList.remove('active');
    }else{
        hadirButton.classList.remove('active');
        buttonAlfa.classList.add('active');
    }
}

function fetchTandaiSemuaHadir(route){
    return fetch(route, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });
}

function showDeleteDialog(row){
    const namaPeserta = row.querySelector('.nama-partisipan').textContent;
    const nikPeserta = row.querySelector('.nik-partisipan').textContent;
    const deletePresensiDialog = document.querySelector('.delete-presensi-dialog');
    const deleteDialogContent = deletePresensiDialog.querySelector('.delete-dialog-content');
    const namaNikUser = deleteDialogContent.querySelector('.nama-nik-user');
    namaNikUser.textContent = `${namaPeserta} - ${nikPeserta}`;

    const inputId = deletePresensiDialog.querySelector('input[name="id"]');
    inputId.value = row.dataset.presensiId;

    openDialog(deletePresensiDialog);
}