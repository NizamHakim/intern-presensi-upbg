const deleteTes = document.querySelector('.delete-tes');
if(deleteTes){
    deleteTes.addEventListener('click', (e) => {
        e.stopPropagation();
        const deleteTesModal = document.getElementById('delete-tes-modal');
        const modalForm = deleteTesModal.querySelector('form');

        openModal(deleteTesModal, removeEventListener);

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

// const mulaiTes = document.querySelector('.mulai-tes');
// if(mulaiTes){
//     mulaiTes.addEventListener('click', (e) => {
//         e.stopPropagation();
//         const mulaiTesModal = document.getElementById('mulai-tes-modal');

//         const modalForm = mulaiTesModal.querySelector('form');

//         async function handleSubmit(e){
//             e.preventDefault();
//             clearErrors(modalForm);
//             const route = modalForm.action;
//             const submitButton = e.submitter;
//             const formData = new FormData(modalForm);
//             const data = Object.fromEntries(formData.entries());

//             playFetchingAnimation(submitButton, 'blue', 'Updating...');
//             const response = await fetchRequest(route, 'PATCH', data);
//             stopFetchingAnimation(submitButton);

//             if(response.ok){
//                 const json = await response.json();
//                 window.location.replace(json.redirect);
//             }else{
//                 handleError(response, modalForm);
//             }
//         }
//         modalForm.addEventListener('submit', handleSubmit);

//         function closeCallback(){
//             modalForm.removeEventListener('submit', handleSubmit);
//         }

//         openModal(mulaiTesModal, closeCallback);
//     });
// }

const daftarPeserta = document.getElementById('daftar-peserta'); 
if(daftarPeserta) {
    document.addEventListener('click', (e) => {
        if(e.target.closest('.peserta-container .menu')){
            e.stopPropagation();
            const menu = e.target.closest('.peserta-container .menu');
            const dialog = menu.parentElement.querySelector('.dialog');
            if(!dialog.classList.contains('open')){
              openDialog(dialog);
            }
        }
    });

    const pesertaContainer = daftarPeserta.querySelector('.peserta-container');
    pesertaContainer.addEventListener('submit', async (e) => {
        if(e.target.matches('.form-toggle-kehadiran')){
            e.preventDefault();
            const form = e.target;
            const route = form.action;
            const data = {'hadir': e.submitter.value};
            const response = await fetchRequest(route, 'PATCH', data);
            console.log(response);
            if(response.ok){
                const json = await response.json();
                togglePesertaButton(form, e.submitter.value);
                updateHadirCount(json.hadir, json.total);
            }else{
                handleError(response, null);
            }
        }
    });

    pesertaContainer.addEventListener('click', async (e) => {
      if(e.target.closest('.delete-peserta')){
          e.stopPropagation();
          const pesertaItem = e.target.closest('.peserta-item');
          showDeletePesertaModal(pesertaItem);
      }
    });

    function showDeletePesertaModal(pesertaItem){
      const deletePesertaModal = document.getElementById('delete-peserta-modal');
      const modalForm = deletePesertaModal.querySelector('form');

      const pesertaId = pesertaItem.dataset.pesertaId;
      const nama = pesertaItem.querySelector('.nama-peserta').textContent;
      const nik = pesertaItem.querySelector('.nik-peserta').textContent;

      const namaNikPeserta = deletePesertaModal.querySelector('.nama-nik-peserta');
      const inputPesertaId = deletePesertaModal.querySelector('input[name=peserta-id]');
      namaNikPeserta.textContent = `${nama} - ${nik}`;
      inputPesertaId.value = pesertaId;

      openModal(deletePesertaModal, removeEventListener);

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

    function togglePesertaButton(form, hadir){
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

    const filterRuangan = document.querySelector('.filter-ruangan');
    filterRuangan.addEventListener('change', async (e) => {
        const ruangan = filterRuangan.querySelector('[name=ruangan]').value;
        const url = new URL(window.location.href);
        url.searchParams.set('ruangan', ruangan);

        const response = await fetchRequest(url.href, 'GET');
        if(response.ok){
            const html = await response.text();
            const pesertaContainer = document.querySelector('.peserta-container');
            pesertaContainer.innerHTML = html;
        }
    });
}