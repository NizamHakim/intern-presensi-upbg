const editForm = document.querySelector('.edit-form');
editForm.addEventListener('submit', async function(e){
    e.preventDefault();
    clearErrors(editForm);
    const route = editForm.getAttribute('action');
    const submitButton = e.submitter;

    const formData = new FormData(editForm);
    const data = Object.fromEntries(formData);
    delete data['ruangan'];
    delete data['pengawas'];
    data['ruangan'] = formData.getAll('ruangan');
    data['pengawas'] = formData.getAll('pengawas');
    
    playFetchingAnimation(submitButton, 'blue', 'Validating...');
    const response = await fetchRequest(route, 'PUT', data);
    stopFetchingAnimation(submitButton);
  
    if(response.ok){
      const json = await response.json();
      saveToast('success', json.message);
      window.location.replace(json.redirect);
    }else{
      handleError(response, editForm);
    }
});