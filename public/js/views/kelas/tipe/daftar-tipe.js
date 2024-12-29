document.addEventListener('click', (e) => {
  if(e.target.closest('#daftar-tipe .menu')){
      e.stopPropagation();
      const menu = e.target.closest('#daftar-tipe .menu');
      const dialog = menu.parentElement.querySelector('.dialog');
      if(!dialog.classList.contains('open')){
          openDialog(dialog);
      }
  }else if(e.target.closest('#daftar-tipe .edit-tipe')){
      e.stopPropagation();
      const tipeItem = e.target.closest('.tipe-item');
      showEditTipeModal(tipeItem);
  }else if(e.target.closest('#daftar-tipe .delete-tipe')){
      e.stopPropagation();
      const tipeItem = e.target.closest('.tipe-item');
      showDeleteTipeModal(tipeItem);
  }
});

function showEditTipeModal(tipeItem){
  const tipeId = tipeItem.dataset.tipeId;
  const namaTipe = tipeItem.querySelector('.nama-tipe').textContent;
  const kodeTipe = tipeItem.querySelector('.kode-tipe').textContent;
  const statusTipe = tipeItem.querySelector('.status-tipe').textContent;

  const editTipeModal = document.getElementById('edit-tipe-modal');
  const modalForm = editTipeModal.querySelector('form');
  modalForm.querySelector('input[name="tipe-id"]').value = tipeId;
  modalForm.querySelector('input[name="nama-tipe"]').value = namaTipe;
  modalForm.querySelector('input[name="kode-tipe"]').value = kodeTipe;
  const modalStatusTipe = modalForm.querySelector('.status-tipe');
  modalStatusTipe.querySelector('.checkbox-label').textContent = statusTipe;
  modalStatusTipe.querySelector('input').checked = (statusTipe === 'Aktif') ? true : false;

  const closeCallback = openModal(editTipeModal, removeEventListeners);

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
      const updatedTipe = await response.json();
      updateTipe(tipeItem, updatedTipe);
      closeModal(editTipeModal, closeCallback);
    }else{
      handleError(response, modalForm);
    }
  }
  modalForm.addEventListener('submit', handleSubmit);

  function handleStatusChange(e){
    modalStatusTipe.querySelector('.checkbox-label').textContent = (e.target.checked) ? 'Aktif' : 'Tidak Aktif';
  }
  modalStatusTipe.addEventListener('change', handleStatusChange);

  function removeEventListeners(){
    modalForm.removeEventListener('submit', handleSubmit);
    modalStatusTipe.removeEventListener('change', handleStatusChange);
  }
}

function updateTipe(tipeItem, updatedTipe){
  tipeItem.querySelector('.nama-tipe').textContent = updatedTipe.nama;
  tipeItem.querySelector('.kode-tipe').textContent = updatedTipe.kode;
  if(updatedTipe.aktif){
    tipeItem.querySelector('.status-tipe').classList.remove('bg-red-300', 'text-red-800');
    tipeItem.querySelector('.status-tipe').classList.add('bg-green-300', 'text-green-800');
    tipeItem.querySelector('.status-tipe').textContent = 'Aktif';
  }else{
    tipeItem.querySelector('.status-tipe').classList.remove('bg-green-300', 'text-green-800');
    tipeItem.querySelector('.status-tipe').classList.add('bg-red-300', 'text-red-800');
    tipeItem.querySelector('.status-tipe').textContent = 'Tidak Aktif';
  }
}

function showDeleteTipeModal(tipeItem){
  const tipeId = tipeItem.dataset.tipeId;
  const namaTipe = tipeItem.querySelector('.nama-tipe').textContent;
  const kodeTipe = tipeItem.querySelector('.kode-tipe').textContent;

  const deleteTipeModal = document.getElementById('delete-tipe-modal');
  const namaKodeTipe = deleteTipeModal.querySelector('.nama-kode-tipe');
  const inputTipeId = deleteTipeModal.querySelector('[name="tipe-id"]');
  const forceDelete = deleteTipeModal.querySelector('[name="force-delete"]');

  namaKodeTipe.textContent = `${namaTipe} - ${kodeTipe}`;
  inputTipeId.value = tipeId;
  forceDelete.checked = false;

  openModal(deleteTipeModal, removeEventListeners);

  const modalForm = deleteTipeModal.querySelector('form');
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

const tambahTipe = document.querySelector('.tambah-tipe');
tambahTipe.addEventListener('click', (e) => {
  e.stopPropagation();
  const tambahTipeModal = document.getElementById('add-tipe-modal');
  const modalForm = tambahTipeModal.querySelector('form');
  modalForm.querySelector('input[name="nama-tipe"]').value = '';
  modalForm.querySelector('input[name="kode-tipe"]').value = '';
  const modalStatusTipe = modalForm.querySelector('.status-tipe');
  modalStatusTipe.querySelector('.checkbox-label').textContent = 'Aktif';
  modalStatusTipe.querySelector('input').checked = true;

  openModal(tambahTipeModal, removeEventListeners);

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
    modalStatusTipe.querySelector('.checkbox-label').textContent = (e.target.checked) ? 'Aktif' : 'Tidak Aktif';
  }
  modalStatusTipe.addEventListener('change', handleStatusChange);

  function removeEventListeners(){
    modalForm.removeEventListener('submit', handleSubmit);
    modalStatusTipe.removeEventListener('change', handleStatusChange);
  }
});