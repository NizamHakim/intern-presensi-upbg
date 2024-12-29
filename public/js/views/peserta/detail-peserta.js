const editPeserta = document.querySelector('.edit-peserta');
editPeserta.addEventListener('click', (e) => {
  e.stopPropagation();
  showEditPesertaModal();
});

function showEditPesertaModal(){
  const nikPeserta = document.querySelector('.nik-peserta').textContent;
  const namaPeserta = document.querySelector('.nama-peserta').textContent;
  const occupationPeserta = document.querySelector('.occupation-peserta').textContent;

  const editPesertaModal = document.getElementById('edit-peserta-modal');
  const modalForm = editPesertaModal.querySelector('form');
  modalForm.querySelector('input[name="nik"]').value = nikPeserta;
  modalForm.querySelector('input[name="nama"]').value = namaPeserta;
  modalForm.querySelector('input[name="occupation"]').value = occupationPeserta;

  const closeCallback = openModal(editPesertaModal, removeEventListeners);

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
      const json = await response.json();
      updatePeserta(json.updatedPeserta);
      closeModal(editPesertaModal, closeCallback);
      createToast('success', json.message);
    }else{
      handleError(response, modalForm);
    }
  }
  modalForm.addEventListener('submit', handleSubmit);

  function removeEventListeners(){
    modalForm.removeEventListener('submit', handleSubmit);
  }
}

function updatePeserta(updatedPeserta){
  document.querySelector('.nik-peserta').textContent = updatedPeserta.nik;
  document.querySelector('.nama-peserta').textContent = updatedPeserta.nama;
  document.querySelector('.occupation-peserta').textContent = updatedPeserta.occupation;
}

const deletePeserta = document.querySelector('.delete-peserta');
deletePeserta.addEventListener('click', (e) => {
  e.stopPropagation();
  showDeletePesertaModal();
});

function showDeletePesertaModal(){
  const deletePesertaModal = document.getElementById('delete-peserta-modal');
  const modalForm = deletePesertaModal.querySelector('form');

  openModal(deletePesertaModal, removeEventListeners);

  async function handleSubmit(e){
    e.preventDefault();
    const route = modalForm.getAttribute('action');
    const submitButton = e.submitter;
    playFetchingAnimation(submitButton, 'red', 'Deleting...');
    const response = await fetchRequest(route, 'DELETE');
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