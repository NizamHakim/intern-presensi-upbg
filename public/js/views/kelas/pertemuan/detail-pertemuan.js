const deletePertemuan = document.querySelector('.delete-pertemuan');
if(deletePertemuan){
    deletePertemuan.addEventListener('click', (e) => {
        e.stopPropagation();
        const deletePertemuanModal = document.getElementById('delete-pertemuan-modal');
        const modalForm = deletePertemuanModal.querySelector('form');

        openModal(deletePertemuanModal, removeEventListener);

        async function handleSubmit(e){
            e.preventDefault();
            const route = modalForm.action;
            const submitButton = e.submitter;

            playFetchingAnimation(submitButton, 'red', 'Deleting...');
            const response = await fetchRequest(route, 'DELETE')
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
    });
}

const reschedulePertemuan = document.querySelector('.reschedule-pertemuan');
if(reschedulePertemuan){
    reschedulePertemuan.addEventListener('click', (e) => {
        e.stopPropagation();
        const reschedulePertemuanModal = document.getElementById('reschedule-pertemuan-modal');

        const modalForm = reschedulePertemuanModal.querySelector('form');

        async function handleSubmit(e){
            e.preventDefault();
            clearErrors(modalForm);

            const submitButton = e.submitter;
            const route = modalForm.action;
            const formData = new FormData(modalForm);
            const data = Object.fromEntries(formData.entries());

            playFetchingAnimation(submitButton, 'blue', 'Validating...');
            const response = await fetchRequest(route, 'PATCH', data);
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

        function closeCallback(){
            modalForm.removeEventListener('submit', handleSubmit);
        }

        openModal(reschedulePertemuanModal, closeCallback);
    });
}

const mulaiPertemuan = document.querySelector('.mulai-pertemuan');
if(mulaiPertemuan){
    mulaiPertemuan.addEventListener('click', (e) => {
        e.stopPropagation();
        const mulaiPertemuanModal = document.getElementById('mulai-pertemuan-modal');

        const modalForm = mulaiPertemuanModal.querySelector('form');

        async function handleSubmit(e){
            e.preventDefault();
            clearErrors(modalForm);
            const route = modalForm.action;
            const submitButton = e.submitter;
            const formData = new FormData(modalForm);
            const data = Object.fromEntries(formData.entries());

            playFetchingAnimation(submitButton, 'blue', 'Updating...');
            const response = await fetchRequest(route, 'PATCH', data);
            stopFetchingAnimation(submitButton);

            if(response.ok){
                const json = await response.json();
                window.location.replace(json.redirect);
            }else{
                handleError(response, modalForm);
            }
        }
        modalForm.addEventListener('submit', handleSubmit);

        function closeCallback(){
            modalForm.removeEventListener('submit', handleSubmit);
        }

        openModal(mulaiPertemuanModal, closeCallback);
    });
}

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
    cancelButton.setAttribute('class', 'btn btn-white border-none shadow-none');
    cancelButton.textContent = 'Cancel';
    cancelButton.addEventListener('click', (e) => {
        e.stopPropagation();
        stopEditing(editTopikCatatan);
    });
    buttonContainer.appendChild(cancelButton);

    const simpanButton = document.createElement('button');
    simpanButton.setAttribute('class', 'btn btn-upbg-solid');
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
    document.addEventListener('click', (e) => {
        if(e.target.closest('.presensi-container .menu')){
            e.stopPropagation();
            const menu = e.target.closest('.presensi-container .menu');
            const dialog = menu.parentElement.querySelector('.dialog');
            if(!dialog.classList.contains('open')){
              openDialog(dialog);
            }
        }
    });

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
                    saveToast('success', json.message);
                    window.location.replace(json.redirect);
                }else{
                    handleError(response, modalForm);
                }
            }
            modalForm.addEventListener('submit', handleSubmit);

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
        const route = e.target.action;
        const submitButton = e.submitter;

        playFetchingAnimation(submitButton, 'green', 'Updating...');
        const response = await fetchRequest(route, 'PUT');
        stopFetchingAnimation(submitButton);

        if(response.ok){
            const json = await response.json();
            const hadirButtons = document.querySelectorAll('.btn-hadir');
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

    presensiContainer.addEventListener('click', async (e) => {
      if(e.target.closest('.delete-presensi')){
          e.stopPropagation();
          const presensiItem = e.target.closest('.presensi-item');
          showDeletePresensiModal(presensiItem);
      }
    });

    function showDeletePresensiModal(presensiItem){
      const deletePresensiModal = document.getElementById('delete-presensi-modal');
      const modalForm = deletePresensiModal.querySelector('form');

      const presensiId = presensiItem.dataset.presensiId;
      const nama = presensiItem.querySelector('.nama-peserta').textContent;
      const nik = presensiItem.querySelector('.nik-peserta').textContent;

      const hiddenId = modalForm.querySelector('[name="presensi-id"]');
      const namaNikPeserta = deletePresensiModal.querySelector('.nama-nik-peserta');
      hiddenId.value = presensiId;
      namaNikPeserta.textContent = `${nama} - ${nik}`;

      openModal(deletePresensiModal, removeEventListener);

      async function handleSubmit(e){
          e.preventDefault();
          const route = modalForm.action;
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

    function togglePresensiButton(form, hadir){
        const hadirButton = form.querySelector('.btn-hadir');
        const buttonAlfa = form.querySelector('.btn-alfa');
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
}