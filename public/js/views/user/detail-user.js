const updateRoleForm = document.querySelector('.update-role-form');
const roleContainer = document.querySelector('.role-container');

roleContainer.addEventListener('change', startEditing);

function startEditing(){
  roleContainer.removeEventListener('change', startEditing);

  const editingContainer = document.createElement('div');
  editingContainer.setAttribute('class', 'editing-container mt-4');

  const dangerContainer = document.createElement('div');
  dangerContainer.setAttribute('class', 'danger-container');
  dangerContainer.innerHTML = `
    <p class="font-semibold mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i> Peringatan</p>
    <p>Melepas role tertentu dapat menghilangkan akses untuk menambahkannya kembali, tekan Simpan untuk melanjutkan</p>
  `;
  editingContainer.appendChild(dangerContainer);

  const buttonContainer = document.createElement('div');
  buttonContainer.setAttribute('class', 'flex justify-end gap-2 mt-4');

  const cancelButton = document.createElement('button');
  cancelButton.setAttribute('type', 'button');
  cancelButton.setAttribute('class', 'btn btn-white');
  cancelButton.innerHTML = 'Batal';
  cancelButton.addEventListener('click', stopEditing);
  
  const submitButton = document.createElement('button');
  submitButton.setAttribute('type', 'submit');
  submitButton.setAttribute('class', 'btn btn-upbg-solid');
  submitButton.innerHTML = 'Simpan';

  buttonContainer.appendChild(cancelButton);
  buttonContainer.appendChild(submitButton);
  editingContainer.appendChild(buttonContainer);

  updateRoleForm.appendChild(editingContainer);
}

function stopEditing(){
  const checkboxes = roleContainer.querySelectorAll('.checkbox');
  checkboxes.forEach((checkbox) => {
    checkbox.querySelector('input[type="checkbox"]').checked = Number(checkbox.dataset.checkedOrigin);
  });
  const editingContainer = document.querySelector('.editing-container');
  editingContainer.remove();

  roleContainer.addEventListener('change', startEditing);
}

updateRoleForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const route = updateRoleForm.getAttribute('action');
  const submitButton = e.submitter;

  const formData = new FormData(updateRoleForm);
  const data = Object.fromEntries(formData);
  delete data['role'];
  data['role'] = formData.getAll('role');

  playFetchingAnimation(submitButton, 'blue', 'Updating...');
  const response = await fetchRequest(route, 'PATCH', data);
  stopFetchingAnimation(submitButton);

  if(response.ok){
      const json = await response.json();
      updateRole(json.roles);
      createToast('success', json.message);
  }else{
      handleError(response, updateRoleForm);
  }
})

function updateRole(roles){
  const checkboxes = roleContainer.querySelectorAll('.checkbox');
  checkboxes.forEach((checkbox) => {
    const input = checkbox.querySelector('input[type="checkbox"]');
    if(roles.includes(Number(input.value))){
      input.checked = true;
      checkbox.dataset.checkedOrigin = 1;
    }else{
      input.checked = false;
      checkbox.dataset.checkedOrigin = 0;
    }
  });
  const editingContainer = document.querySelector('.editing-container');
  editingContainer.remove();

  roleContainer.addEventListener('change', startEditing);
}