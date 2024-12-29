document.addEventListener('click', (e) => {
  if(e.target.closest('#daftar-ruangan .menu')){
      e.stopPropagation();
      const menu = e.target.closest('#daftar-ruangan .menu');
      const dialog = menu.parentElement.querySelector('.dialog');
      if(!dialog.classList.contains('open')){
          openDialog(dialog);
      }
  }else if(e.target.closest('#daftar-ruangan .edit-ruangan')){
      e.stopPropagation();
      const ruanganItem = e.target.closest('.ruangan-item');
      showEditRuanganModal(ruanganItem);
  }else if(e.target.closest('#daftar-ruangan .delete-ruangan')){
      e.stopPropagation();
      const ruanganItem = e.target.closest('.ruangan-item');
      showDeleteRuanganModal(ruanganItem);
  }
});

function showEditRuanganModal(ruanganItem){
  const ruanganId = ruanganItem.dataset.ruanganId;
  const kodeRuangan = ruanganItem.querySelector('.kode-ruangan').textContent;
  const kapasitasRuangan = ruanganItem.querySelector('.kapasitas-ruangan').textContent;
  const statusRuangan = ruanganItem.querySelector('.status-ruangan').textContent;

  const editRuanganModal = document.getElementById('edit-ruangan-modal');
  const modalForm = editRuanganModal.querySelector('form');
  modalForm.querySelector('input[name="ruangan-id"]').value = ruanganId;
  modalForm.querySelector('input[name="kode-ruangan"]').value = kodeRuangan;
  modalForm.querySelector('input[name="kapasitas-ruangan"]').value = kapasitasRuangan;
  const modalStatusRuangan = modalForm.querySelector('.status-ruangan');
  modalStatusRuangan.querySelector('.checkbox-label').textContent = statusRuangan;
  modalStatusRuangan.querySelector('input').checked = (statusRuangan === 'Aktif') ? true : false;

  const closeCallback = openModal(editRuanganModal, removeEventListeners);

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
      const updatedRuangan = await response.json();
      updateRuangan(ruanganItem, updatedRuangan);
      closeModal(editRuanganModal, closeCallback);
    }else{
      handleError(response, modalForm);
    }
  }
  modalForm.addEventListener('submit', handleSubmit);

  function handleStatusChange(e){
    modalStatusRuangan.querySelector('.checkbox-label').textContent = (e.target.checked) ? 'Aktif' : 'Tidak Aktif';
  }
  modalStatusRuangan.addEventListener('change', handleStatusChange);

  function removeEventListeners(){
    modalForm.removeEventListener('submit', handleSubmit);
    modalStatusRuangan.removeEventListener('change', handleStatusChange);
  }
}

function updateRuangan(ruanganItem, updatedRuangan){
  ruanganItem.querySelector('.kode-ruangan').textContent = updatedRuangan.kode;
  ruanganItem.querySelector('.kapasitas-ruangan').textContent = updatedRuangan.kapasitas;
  if(updatedRuangan.status){
    ruanganItem.querySelector('.status-ruangan').classList.remove('bg-red-300', 'text-red-800');
    ruanganItem.querySelector('.status-ruangan').classList.add('bg-green-300', 'text-green-800');
    ruanganItem.querySelector('.status-ruangan').textContent = 'Aktif';
  }else{
    ruanganItem.querySelector('.status-ruangan').classList.remove('bg-green-300', 'text-green-800');
    ruanganItem.querySelector('.status-ruangan').classList.add('bg-red-300', 'text-red-800');
    ruanganItem.querySelector('.status-ruangan').textContent = 'Tidak Aktif';
  }
}

function showDeleteRuanganModal(ruanganItem){
  const ruanganId = ruanganItem.dataset.ruanganId;
  const kodeRuangan = ruanganItem.querySelector('.kode-ruangan').textContent;

  const deleteRuanganModal = document.getElementById('delete-ruangan-modal');
  const modalKodeRuangan = deleteRuanganModal.querySelector('.kode-ruangan');
  const inputRuanganId = deleteRuanganModal.querySelector('[name="ruangan-id"]');
  const forceDelete = deleteRuanganModal.querySelector('[name="force-delete"]');

  modalKodeRuangan.textContent = kodeRuangan;
  inputRuanganId.value = ruanganId;
  forceDelete.checked = false;

  openModal(deleteRuanganModal, removeEventListeners);

  const modalForm = deleteRuanganModal.querySelector('form');
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

const tambahRuangan = document.querySelector('.tambah-ruangan');
tambahRuangan.addEventListener('click', (e) => {
  e.stopPropagation();
  const tambahRuanganModal = document.getElementById('add-ruangan-modal');
  const modalForm = tambahRuanganModal.querySelector('form');
  modalForm.querySelector('input[name="kode-ruangan"]').value = '';
  modalForm.querySelector('input[name="kapasitas-ruangan"]').value = '';
  const modalStatusRuangan = modalForm.querySelector('.status-ruangan');
  modalStatusRuangan.querySelector('.checkbox-label').textContent = 'Aktif';
  modalStatusRuangan.querySelector('input').checked = true;

  openModal(tambahRuanganModal, removeEventListeners);

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
    modalStatusRuangan.querySelector('.checkbox-label').textContent = (e.target.checked) ? 'Aktif' : 'Tidak Aktif';
  }
  modalStatusRuangan.addEventListener('change', handleStatusChange);

  function removeEventListeners(){
    modalForm.removeEventListener('submit', handleSubmit);
    modalStatusRuangan.removeEventListener('change', handleStatusChange);
  }
});