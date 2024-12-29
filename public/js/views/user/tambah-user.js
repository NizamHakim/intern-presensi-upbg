const togglePasswordNik = document.querySelector('[name="toggle-password-nik"]');
const inputNik = document.querySelector('[name="nik"]');
const inputPassword = document.querySelector('[name="password"]');
const inputKonfirmasiPassword = document.querySelector('[name="konfirmasi-password"]');

function attached(){
  inputPassword.value = inputNik.value;
  inputKonfirmasiPassword.value = inputNik.value;
}

togglePasswordNik.addEventListener('change', function(){
  if(this.checked){
    inputPassword.type = 'text';
    inputPassword.readOnly = true;
    inputPassword.value = inputNik.value;

    inputKonfirmasiPassword.type = 'text';
    inputKonfirmasiPassword.readOnly = true;
    inputKonfirmasiPassword.value = inputNik.value;

    inputNik.addEventListener('input', attached);
  }else{
    inputPassword.type = 'password';
    inputPassword.readOnly = false;
    inputPassword.value = '';

    inputKonfirmasiPassword.type = 'password';
    inputKonfirmasiPassword.readOnly = false;
    inputKonfirmasiPassword.value = '';

    inputNik.removeEventListener('input', attached);
  }
});

const tambahUserForm = document.querySelector('.tambah-user-form');
tambahUserForm.addEventListener('submit', async function(e){
    e.preventDefault();
    clearErrors(tambahUserForm);
    const route = tambahUserForm.getAttribute('action');
    const submitButton = e.submitter;

    const formData = new FormData(tambahUserForm);
    const data = Object.fromEntries(formData);
    delete data['toggle-password-nik'];
    delete data['role'];
    data['role'] = formData.getAll('role');

    playFetchingAnimation(submitButton, 'green', 'Validating...');
    const response = await fetchRequest(route, 'POST', data);
    stopFetchingAnimation(submitButton);

    if(response.ok){
        const json = await response.json();
        saveToast('success', json.message);
        window.location.replace(json.redirect);
    }else{
        handleError(response, tambahUserForm);
    }
});