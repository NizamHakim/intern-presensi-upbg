document.addEventListener('click', (e) => {
  if(e.target.closest('#daftar-level .menu')){
      e.stopPropagation();
      const menu = e.target.closest('#daftar-level .menu');
      const dialog = menu.parentElement.querySelector('.dialog');
      if(!dialog.classList.contains('open')){
          openDialog(dialog);
      }
  }else if(e.target.closest('#daftar-level .edit-level')){
      e.stopPropagation();
      const levelItem = e.target.closest('.level-item');
      showEditLevelModal(levelItem);
  }else if(e.target.closest('#daftar-level .delete-level')){
      e.stopPropagation();
      const levelItem = e.target.closest('.level-item');
      showDeleteLevelModal(levelItem);
  }
});

function showEditLevelModal(levelItem){
  const levelId = levelItem.dataset.levelId;
  const namaLevel = levelItem.querySelector('.nama-level').textContent;
  const kodeLevel = levelItem.querySelector('.kode-level').textContent;
  const statusLevel = levelItem.querySelector('.status-level').textContent;

  const editLevelModal = document.getElementById('edit-level-modal');
  const modalForm = editLevelModal.querySelector('form');
  modalForm.querySelector('input[name="level-id"]').value = levelId;
  modalForm.querySelector('input[name="nama-level"]').value = namaLevel;
  modalForm.querySelector('input[name="kode-level"]').value = kodeLevel;
  const modalStatusLevel = modalForm.querySelector('.status-level');
  modalStatusLevel.querySelector('.checkbox-label').textContent = statusLevel;
  modalStatusLevel.querySelector('input').checked = (statusLevel === 'Aktif') ? true : false;

  const closeCallback = openModal(editLevelModal, removeEventListeners);

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
      const updatedLevel = await response.json();
      updateLevel(levelItem, updatedLevel);
      closeModal(editLevelModal, closeCallback);
    }else{
      handleError(response, modalForm);
    }
  }
  modalForm.addEventListener('submit', handleSubmit);

  function handleStatusChange(e){
    modalStatusLevel.querySelector('.checkbox-label').textContent = (e.target.checked) ? 'Aktif' : 'Tidak Aktif';
  }
  modalStatusLevel.addEventListener('change', handleStatusChange);

  function removeEventListeners(){
    modalForm.removeEventListener('submit', handleSubmit);
    modalStatusLevel.removeEventListener('change', handleStatusChange);
  }
}

function updateLevel(levelItem, updatedLevel){
  levelItem.querySelector('.nama-level').textContent = updatedLevel.nama;
  levelItem.querySelector('.kode-level').textContent = updatedLevel.kode;
  if(updatedLevel.aktif){
    levelItem.querySelector('.status-level').classList.remove('bg-red-300', 'text-red-800');
    levelItem.querySelector('.status-level').classList.add('bg-green-300', 'text-green-800');
    levelItem.querySelector('.status-level').textContent = 'Aktif';
  }else{
    levelItem.querySelector('.status-level').classList.remove('bg-green-300', 'text-green-800');
    levelItem.querySelector('.status-level').classList.add('bg-red-300', 'text-red-800');
    levelItem.querySelector('.status-level').textContent = 'Tidak Aktif';
  }
}

function showDeleteLevelModal(levelItem){
  const levelId = levelItem.dataset.levelId;
  const namaLevel = levelItem.querySelector('.nama-level').textContent;
  const kodeLevel = levelItem.querySelector('.kode-level').textContent;

  const deleteLevelModal = document.getElementById('delete-level-modal');
  const namaKodeLevel = deleteLevelModal.querySelector('.nama-kode-level');
  const inputLevelId = deleteLevelModal.querySelector('[name="level-id"]');
  const forceDelete = deleteLevelModal.querySelector('[name="force-delete"]');

  namaKodeLevel.textContent = `${namaLevel} - ${kodeLevel}`;
  inputLevelId.value = levelId;
  forceDelete.checked = false;

  openModal(deleteLevelModal, removeEventListeners);

  const modalForm = deleteLevelModal.querySelector('form');
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

const tambahLevel = document.querySelector('.tambah-level');
tambahLevel.addEventListener('click', (e) => {
  e.stopPropagation();
  const tambahLevelModal = document.getElementById('add-level-modal');
  const modalForm = tambahLevelModal.querySelector('form');
  modalForm.querySelector('input[name="nama-level"]').value = '';
  modalForm.querySelector('input[name="kode-level"]').value = '';
  const modalStatusLevel = modalForm.querySelector('.status-level');
  modalStatusLevel.querySelector('.checkbox-label').textContent = 'Aktif';
  modalStatusLevel.querySelector('input').checked = true;

  openModal(tambahLevelModal, removeEventListeners);

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
    modalStatusLevel.querySelector('.checkbox-label').textContent = (e.target.checked) ? 'Aktif' : 'Tidak Aktif';
  }
  modalStatusLevel.addEventListener('change', handleStatusChange);

  function removeEventListeners(){
    modalForm.removeEventListener('submit', handleSubmit);
    modalStatusLevel.removeEventListener('change', handleStatusChange);
  }
});