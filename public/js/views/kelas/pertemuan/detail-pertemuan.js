const deletePertemuan = document.querySelector('.delete-pertemuan');
if(deletePertemuan){
    deletePertemuan.addEventListener('click', (e) => {
        e.stopPropagation();
        const deletePertemuanDialog = document.querySelector('.delete-pertemuan-dialog');
        openDialog(deletePertemuanDialog);
    });
}

// const reschedulePertemuan = document.querySelector('.reschedule-pertemuan');
// if(reschedulePertemuan){
//     reschedulePertemuan.addEventListener('click', (e) => {
//         e.stopPropagation();
//         const reschedulePertemuanModal = document.getElementById('reschedule-pertemuan-modal');

//         const modalForm = reschedulePertemuanModal.querySelector('form');

//         async function handleSubmit(e){
//             e.preventDefault();
//             clearErrors(modalForm);

//             const submitButton = e.submitter;
//             submitButton.classList.add('hidden');
//             const loading = document.createElement('button');
//             loading.setAttribute('class', 'button-loading button-style border-upbg');
//             loading.setAttribute('disabled', 'true');
//             loading.innerHTML = createLoadingAnimation('Validating...', 'blue');
//             submitButton.insertAdjacentElement('afterend', loading);

//             const route = modalForm.action;
//             const formData = new FormData(modalForm);
//             const data = Object.fromEntries(formData.entries());

//             const response = await fetchReschedule(route, data);
//             loading.remove();
//             submitButton.classList.remove('hidden');

//             if(response.ok){
//                 const json = await response.json();
//                 window.location.replace(json.redirect);
//             }else{
//                 if(response.status === 422){
//                     const errors = await response.json();
//                     for(const key in errors){
//                         const input = modalForm.querySelector(`[name="${key}"]`);
//                         const inputGroup = input.closest('.input-group');
//                         const error = createErrorText(errors[key][0]);
//                         inputGroup.appendChild(error);
//                     }
//                 }else{
//                     createToast('error', 'Terjadi kesalahan. Silahkan coba lagi.');
//                 }
//             }
//         }
//         modalForm.addEventListener('submit', handleSubmit);

//         function closeCallback(){
//             modalForm.removeEventListener('submit', handleSubmit);
//         }

//         openModal(reschedulePertemuanModal, closeCallback);
//     });
// }

// const mulaiPertemuan = document.querySelector('.mulai-pertemuan');
// if(mulaiPertemuan){
//     mulaiPertemuan.addEventListener('click', (e) => {
//         e.stopPropagation();
//         const mulaiPertemuanModal = document.getElementById('mulai-pertemuan-modal');

//         const modalForm = mulaiPertemuanModal.querySelector('form');

//         async function handleSubmit(e){
//             e.preventDefault();
//             clearErrors(modalForm);

//             const submitButton = e.submitter;
//             submitButton.classList.add('hidden');
//             const loading = document.createElement('button');
//             loading.setAttribute('class', 'button-loading text-sm flex flex-row items-center justify-center font-semibold px-4 py-2 border border-upbg bg-white rounded-md cursor-progress');
//             loading.setAttribute('disabled', 'true');
//             loading.innerHTML = createLoadingAnimation('Validating...', 'blue');
//             submitButton.insertAdjacentElement('afterend', loading);

//             const route = modalForm.action;
//             const formData = new FormData(modalForm);
//             const data = Object.fromEntries(formData.entries());

//             const response = await fetchMulaiPertemuan(route, data);
//             loading.remove();
//             submitButton.classList.remove('hidden');

//             if(response.ok){
//                 const json = await response.json();
//                 window.location.replace(json.redirect);
//             }else{
//                 if(response.status === 422){
//                     const errors = await response.json();
//                     for(const key in errors){
//                         const input = modalForm.querySelector(`[name="${key}"]`);
//                         const inputGroup = input.closest('.input-group');
//                         const error = createErrorText(errors[key][0]);
//                         inputGroup.appendChild(error);
//                     }
//                 }else{
//                     createToast('error', 'Terjadi kesalahan. Silahkan coba lagi.');
//                 }
//             }
//         }
//         modalForm.addEventListener('submit', handleSubmit);

//         function closeCallback(){
//             modalForm.removeEventListener('submit', handleSubmit);
//         }

//         openModal(mulaiPertemuanModal, closeCallback);
//     });
// }

const editTopikCatatan = document.querySelector('.edit-topik-catatan');
editTopikCatatan.addEventListener('click', (e) => {
    e.stopPropagation();
    startEditing(editTopikCatatan);
});

function startEditing(editTopikCatatan){
    editTopikCatatan.classList.add('hidden');

    const topikCatatanSection = document.getElementById('topik-catatan');

    const buttonContainer = document.createElement('div');
    buttonContainer.setAttribute('class', 'button-container flex flex-row justify-end gap-4');

    const cancelButton = document.createElement('button');
    cancelButton.setAttribute('class', 'button-style border-none text-gray-700 bg-white hover:bg-gray-100');
    cancelButton.textContent = 'Cancel';
    cancelButton.addEventListener('click', (e) => {
        e.stopPropagation();
        stopEditing(editTopikCatatan);
    });
    buttonContainer.appendChild(cancelButton);

    const simpanButton = document.createElement('button');
    simpanButton.setAttribute('class', 'button-style border-upbg text-white bg-upbg hover:bg-upbg-dark');
    simpanButton.textContent = 'Simpan';
    simpanButton.addEventListener('click', async (e) => {
        e.stopPropagation();

        clearErrors(topikCatatanSection);
        playFetchingAnimation(simpanButton, 'blue', 'Updating...');
        const response = await fetchTopikCatatan(topikCatatanSection.dataset.slug, topikCatatanSection.dataset.id);
        stopFetchingAnimation(simpanButton);

        if(response.ok){
            const json = await response.json();
            updateText(json, topikText, catatanText);
            stopEditing(editTopikCatatan);
            createToast('success', json.message);
        }else{
            handleError(response, topikCatatanSection);
        }
    });
    buttonContainer.appendChild(simpanButton);
    topikCatatanSection.appendChild(buttonContainer);

    const topikContainer = topikCatatanSection.querySelector('.topik');
    const topikText = topikContainer.querySelector('p');
    topikText.classList.add('hidden');
    const topikTextArea = document.createElement('textarea');
    topikTextArea.setAttribute('class', 'resize-none text-gray-600 w-full h-24 p-2 rounded-md border bg-gray-100 outline outline-1.5 outline-transparent outline-offset-0 transition-all duration-300 focus:outline-upbg-light');
    topikTextArea.setAttribute('placeholder', 'Topik bahasan pertemuan ini');
    topikTextArea.name = 'topik';
    topikTextArea.textContent = (topikText.textContent != '-') ? topikText.textContent : '';
    topikContainer.appendChild(topikTextArea);

    const catatanContainer = topikCatatanSection.querySelector('.catatan');
    const catatanText = catatanContainer.querySelector('p');
    catatanText.classList.add('hidden');
    const catatanTextArea = document.createElement('textarea');
    catatanTextArea.setAttribute('class', 'resize-none text-gray-600 w-full h-24 p-2 rounded-md border bg-gray-100 outline outline-1.5 outline-transparent outline-offset-0 transition-all duration-300 focus:outline-upbg-light');
    catatanTextArea.setAttribute('placeholder', 'Catatan untuk admin');
    catatanTextArea.name = 'catatan';
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

    return fetch(`/kelas/${slug}/pertemuan/${id}/update-topik-catatan`, {
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

const daftarPresensi = document.getElementById('daftar-presensi'); 
if(daftarPresensi) {
    const tambahPresensi = daftarPresensi.querySelector('.tambah-presensi');
    tambahPresensi.addEventListener('click', (e) => {
        e.stopPropagation();
        const tambahPresensiModal = document.getElementById('tambah-presensi-modal');

        const modalForm = tambahPresensiModal.querySelector('form');
        if(modalForm){
            async function handleSubmit(e){
                e.preventDefault();
                clearErrors(modalForm);

                const route = modalForm.action;
                const formData = new FormData(modalForm);
                const data = Object.fromEntries(formData.entries());
                const submitButton = e.submitter;

                playFetchingAnimation(submitButton, 'green', 'Validating...');
                const response = await fetchRequest(route, 'POST', data);
                stopFetchingAnimation(submitButton);

                if(response.ok){
                    const json = await response.json();
                    window.location.replace(json.redirect);
                }else{
                    handleError(response, modalForm);
                }
            }
            modalForm.addEventListener('submit', handleSubmit);
            // remove event listener upon closing modal
            function closeCallback(){
                modalForm.removeEventListener('submit', handleSubmit);
            }
            openModal(tambahPresensiModal, closeCallback);
        }else{
            openModal(tambahPresensiModal);
        }
    });

    const tandaiSemuaHadir = daftarPresensi.querySelector('.tandai-semua-hadir');
    tandaiSemuaHadir.addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const route = form.action;

        playFetchingAnimation(tandaiSemuaHadir, 'green', 'Updating...');
        const response = await fetchRequest(route, 'PUT');
        stopFetchingAnimation(tandaiSemuaHadir);

        if(response.ok){
            const json = await response.json();
            const hadirButtons = document.querySelectorAll('.button-hadir');
            hadirButtons.forEach(button => {
                button.classList.add('active');
                button.nextElementSibling.classList.remove('active');
            });
            updateHadirCount(json.hadir, json.total);
        }else{
            handleError(response, null);
        }
    });

    const presensiContainer = daftarPresensi.querySelector('.presensi-container');
    presensiContainer.addEventListener('submit', async (e) => {
        if(e.target.matches('.form-toggle-kehadiran')){
            e.preventDefault();
            const form = e.target;
            const route = form.action;
            const data = {'hadir': e.submitter.value};
            const response = await fetchRequest(route, 'PATCH', data);
            if(response.ok){
                const json = await response.json();
                togglePresensiButton(form, e.submitter.value);
                updateHadirCount(json.hadir, json.total);
            }else{
                handleError(response, null);
            }
        }
    });

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

    function updateHadirCount(hadir, total){
        const hadirCount = document.querySelector('.hadir-count');
        hadirCount.textContent = `${hadir} / ${total}`;
    }

    presensiContainer.addEventListener('click', (e) => {
        if(e.target.closest('.presensi-content') && !e.target.closest('.button-alfa') && !e.target.closest('.button-hadir')){
            e.stopPropagation();
            const presensiContent = e.target.closest('.presensi-content');
            const deletePresensiContainer = presensiContent.parentElement.querySelector('.delete-presensi-container'); 
            if(deletePresensiContainer.classList.contains('open')){
                deletePresensiContainer.classList.remove('open');
            }else{
                const deletePresensiContainerOpen = presensiContainer.querySelector('.delete-presensi-container.open');
                if(deletePresensiContainerOpen){
                    deletePresensiContainerOpen.classList.remove('open');
                }
                deletePresensiContainer.classList.add('open');
            }
        }else if(e.target.closest('.delete-presensi')){
            e.stopPropagation();
            const presensiItem = e.target.closest('.presensi-item');
            createDeletePresensiDialog(presensiItem);
        }
    });

    function createDeletePresensiDialog(presensiItem){
        const namaPeserta = presensiItem.querySelector('.nama-peserta').textContent;
        const nikPeserta = presensiItem.querySelector('.nik-peserta').textContent;

        const deletePresensiDialog = daftarPresensi.querySelector('.delete-presensi-dialog');
        const deleteDialogContent = deletePresensiDialog.querySelector('.delete-dialog-content');
        const namaNikUser = deleteDialogContent.querySelector('.nama-nik-user');
        namaNikUser.textContent = `${namaPeserta} - ${nikPeserta}`;

        const inputId = deletePresensiDialog.querySelector('[name="id"]');
        inputId.value = presensiItem.dataset.presensiId;

        openDialog(deletePresensiDialog);
    }

    // trial
    // const presensiItem = daftarPresensi.querySelectorAll('.presensi-item');
    // presensiItem.forEach(presensi => {
    //     const presensiContent = presensi.querySelector('.presensi-content');
    //     presensiContent.addEventListener('click', (e) => {
    //         if(!e.target.closest('.button-alfa') && !e.target.closest('.button-hadir')){
    //             const deletePresensiContainer = presensi.querySelector('.delete-presensi-container');
    //             if(deletePresensiContainer.classList.contains('flex')){
    //                 deletePresensiContainer.classList.remove('flex');
    //                 deletePresensiContainer.classList.add('hidden');
    //             }else{
    //                 deletePresensiContainer.classList.remove('hidden');
    //                 deletePresensiContainer.classList.add('flex');
    //             }
    //         }
    //     });
    // });

    // daftarPresensiTable.addEventListener('click', (e) => {
    //     if(e.target.closest('.delete-presensi')){
    //         e.stopPropagation();
    //         const row = e.target.closest('tr');
    //         showDeleteDialog(row);
    //     }
    // })
}

// function fetchReschedule(route, data){
//     return fetch(route, {
//         method: 'PATCH',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         },
//         body: JSON.stringify(data)
//     });
// }

// function fetchMulaiPertemuan(route, data){
//     return fetch(route, {
//         method: 'PATCH',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         },
//         body: JSON.stringify(data)
//     })
// }

function fetchRequest(route, method, data = {}){
    return fetch(route, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    });
}

async function handleError(response, container){
    if(response.status === 422){
        const errors = await response.json();
        for(const key in errors){
            const input = container.querySelector(`[name="${key}"]`);
            const inputGroup = input.closest('.input-group');
            const error = createErrorText(errors[key][0]);
            inputGroup.appendChild(error);
        }
    }else{
        createToast('error', 'Terjadi kesalahan. Silahkan coba lagi.');
    }
}

function playFetchingAnimation(element, style, message){
    const colors = {
        'green': 'border-green-600',
        'blue': 'border-upbg',
    };

    element.classList.add('hidden');

    const loading = document.createElement('button');
    loading.setAttribute('class', 'button-loading button-style ' + colors[style]);
    loading.setAttribute('disabled', 'true');
    loading.innerHTML = createLoadingAnimation(message, style);
    element.insertAdjacentElement('afterend', loading);
}

function stopFetchingAnimation(element){
    const loading = element.nextElementSibling;
    loading.remove();

    element.classList.remove('hidden');
}