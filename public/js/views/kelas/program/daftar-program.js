document.addEventListener('click', (e) => {
    if(e.target.closest('#daftar-program .menu')){
        e.stopPropagation();
        const menu = e.target.closest('#daftar-program .menu');
        const dialog = menu.parentElement.querySelector('.dialog');
        if(!dialog.classList.contains('open')){
            openDialog(dialog);
        }
    }else if(e.target.closest('#daftar-program .edit-program')){
        e.stopPropagation();
        const programItem = e.target.closest('.program-item');
        showEditProgramModal(programItem);
    }else if(e.target.closest('#daftar-program .delete-program')){
        e.stopPropagation();
        const programItem = e.target.closest('.program-item');
        showDeleteProgramModal(programItem);
    }
});

function showEditProgramModal(programItem){
  const programId = programItem.dataset.programId;
  const namaProgram = programItem.querySelector('.nama-program').textContent;
  const kodeProgram = programItem.querySelector('.kode-program').textContent;
  const statusProgram = programItem.querySelector('.status-program').textContent;

  const editProgramModal = document.getElementById('edit-program-modal');
  const modalForm = editProgramModal.querySelector('form');
  modalForm.querySelector('input[name="program-id"]').value = programId;
  modalForm.querySelector('input[name="nama-program"]').value = namaProgram;
  modalForm.querySelector('input[name="kode-program"]').value = kodeProgram;
  const modalStatusProgram = modalForm.querySelector('.status-program');
  modalStatusProgram.querySelector('.checkbox-label').textContent = statusProgram;
  modalStatusProgram.querySelector('input').checked = (statusProgram === 'Aktif') ? true : false;

  const closeCallback = openModal(editProgramModal, removeEventListeners);

  async function handleSubmit(e){
    e.preventDefault();
    const route = modalForm.getAttribute('action');
    const submitButton = e.submitter;
    clearErrors(modalForm);

    const formData = new FormData(modalForm);
    const data = Object.fromEntries(formData.entries());
    playFetchingAnimation(submitButton, 'blue', 'Updating...');
    const response = await fetchRequest(route, 'PUT', data);
    stopFetchingAnimation(submitButton);

    if(response.ok){
      const updatedProgram = await response.json();
      updateProgram(programItem, updatedProgram);
      closeModal(editProgramModal, closeCallback);
    }else{
      handleError(response, modalForm);
    }
  }
  modalForm.addEventListener('submit', handleSubmit);

  function handleStatusChange(e){
    modalStatusProgram.querySelector('.checkbox-label').textContent = (e.target.checked) ? 'Aktif' : 'Tidak Aktif';
  }
  modalStatusProgram.addEventListener('change', handleStatusChange);

  function removeEventListeners(){
    modalForm.removeEventListener('submit', handleSubmit);
    modalStatusProgram.removeEventListener('change', handleStatusChange);
  }
}

function updateProgram(programItem, updatedProgram){
  programItem.querySelector('.nama-program').textContent = updatedProgram.nama;
  programItem.querySelector('.kode-program').textContent = updatedProgram.kode;
  if(updatedProgram.aktif){
    programItem.querySelector('.status-program').classList.remove('bg-red-300', 'text-red-800');
    programItem.querySelector('.status-program').classList.add('bg-green-300', 'text-green-800');
    programItem.querySelector('.status-program').textContent = 'Aktif';
  }else{
    programItem.querySelector('.status-program').classList.remove('bg-green-300', 'text-green-800');
    programItem.querySelector('.status-program').classList.add('bg-red-300', 'text-red-800');
    programItem.querySelector('.status-program').textContent = 'Tidak Aktif';
  }
}

function showDeleteProgramModal(programItem){
  const programId = programItem.dataset.programId;
  const namaProgram = programItem.querySelector('.nama-program').textContent;
  const kodeProgram = programItem.querySelector('.kode-program').textContent;

  const deleteProgramModal = document.getElementById('delete-program-modal');
  const namaKodeProgram = deleteProgramModal.querySelector('.nama-kode-program');
  const inputProgramId = deleteProgramModal.querySelector('[name="program-id"]');
  const forceDelete = deleteProgramModal.querySelector('[name="force-delete"]');

  namaKodeProgram.textContent = `${namaProgram} - ${kodeProgram}`;
  inputProgramId.value = programId;
  forceDelete.checked = false;

  openModal(deleteProgramModal, removeEventListeners);

  const modalForm = deleteProgramModal.querySelector('form');
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

  function removeEventListeners(){
    modalForm.removeEventListener('submit', handleSubmit);
  }
}

const tambahProgram = document.querySelector('.tambah-program');
tambahProgram.addEventListener('click', (e) => {
  e.stopPropagation();
  const tambahProgramModal = document.getElementById('add-program-modal');
  const modalForm = tambahProgramModal.querySelector('form');
  modalForm.querySelector('input[name="nama-program"]').value = '';
  modalForm.querySelector('input[name="kode-program"]').value = '';
  const modalStatusProgram = modalForm.querySelector('.status-program');
  modalStatusProgram.querySelector('.checkbox-label').textContent = 'Aktif';
  modalStatusProgram.querySelector('input').checked = true;

  openModal(tambahProgramModal, removeEventListeners);

  async function handleSubmit(e){
    e.preventDefault();
    const route = modalForm.getAttribute('action');
    const submitButton = e.submitter;
    clearErrors(modalForm);

    const formData = new FormData(modalForm);
    const data = Object.fromEntries(formData.entries());
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

  function handleStatusChange(e){
    modalStatusProgram.querySelector('.checkbox-label').textContent = (e.target.checked) ? 'Aktif' : 'Tidak Aktif';
  }
  modalStatusProgram.addEventListener('change', handleStatusChange);

  function removeEventListeners(){
    modalForm.removeEventListener('submit', handleSubmit);
    modalStatusProgram.removeEventListener('change', handleStatusChange);
  }
});