const tambahTesForm = document.querySelector('.tambah-tes-form');
tambahTesForm.addEventListener('submit', async function(e){
  e.preventDefault();
  clearErrors(tambahTesForm);
  const route = tambahTesForm.getAttribute('action');
  const submitButton = e.submitter;

  const formData = new FormData(tambahTesForm);
  const data = Object.fromEntries(formData);
  delete data['ruangan'];
  delete data['pengawas'];
  data['ruangan'] = formData.getAll('ruangan');
  data['pengawas'] = formData.getAll('pengawas');

  playFetchingAnimation(submitButton, 'green', 'Validating...');
  const response = await fetchRequest(route, 'POST', data);
  stopFetchingAnimation(submitButton);

  if(response.ok){
    const json = await response.json();
    saveToast('success', json.message);
    window.location.replace(json.redirect);
  }else{
    handleError(response, tambahTesForm);
  }
});