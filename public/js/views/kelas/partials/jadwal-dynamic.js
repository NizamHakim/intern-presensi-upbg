const jadwalContainer = document.querySelector('.jadwal-container');

document.addEventListener('click', function(e){
    if(e.target.closest('.jadwal-container .menu')){
        e.stopPropagation();
        const menu = e.target.closest('.jadwal-container .menu');
        const dialog = menu.parentElement.querySelector('.dialog');
        if(!dialog.classList.contains('open')){
          openDialog(dialog);
        }
    }else if(e.target.closest('.jadwal-container .edit-jadwal')){
        e.stopPropagation();
        const jadwalItem = e.target.closest('.jadwal-item');
        showEditJadwalModal(jadwalItem);
    }else if(e.target.closest('.jadwal-container .delete-jadwal')){
        e.stopPropagation();
        const jadwalItem = e.target.closest('.jadwal-item');
        jadwalItem.remove();
    }
});

jadwalContainer.addEventListener('change', function(e){
    if(e.target.matches('.hari-dropdown')){
        e.stopPropagation();
        const dropdown = e.target;
        const jadwalItem = dropdown.closest('.jadwal-item');
        jadwalItem.querySelector('.hari').textContent = dropdown.querySelector('.dropdown-text').textContent;
    }else if(e.target.closest('.waktu-mulai-fp')){
        e.stopPropagation();
        const timepickr = e.target;
        const jadwalItem = timepickr.closest('.jadwal-item');
        jadwalItem.querySelector('.waktu-mulai').textContent = timepickr.value;
    }else if(e.target.closest('.waktu-selesai-fp')){
        e.stopPropagation();
        const timepickr = e.target;
        const jadwalItem = timepickr.closest('.jadwal-item');
        jadwalItem.querySelector('.waktu-selesai').textContent = timepickr.value;
    }
});

const tambahJadwal = document.querySelector('.tambah-jadwal');
tambahJadwal.addEventListener('click', function(e){
    e.stopPropagation();
    if(window.matchMedia('(max-width: 768px)').matches){
        showAddJadwalModal();
    }else{
        createNewJadwalItem();
    }
});

function createNewJadwalItem(hari = '', waktuMulai = '', waktuSelesai = ''){
    const templateJadwal = document.getElementById('template-jadwal');
    const jadwalItem = templateJadwal.content.cloneNode(true);
    const hariDropdown = jadwalItem.querySelector('.hari-dropdown');
    changeDropdownValue(hariDropdown, hari);
    
    const waktuMulaiInput = jadwalItem.querySelector('.waktu-mulai-fp');
    attachTimepicker(waktuMulaiInput);
    changeTimeValue(waktuMulaiInput, waktuMulai);
    
    const waktuSelesaiInput = jadwalItem.querySelector('.waktu-selesai-fp');
    attachTimepicker(waktuSelesaiInput);
    changeTimeValue(waktuSelesaiInput, waktuSelesai);

    const hariArray = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    jadwalItem.querySelector('.hari').textContent = (hari == '') ? 'Hari' : hariArray[hari];
    jadwalItem.querySelector('.waktu-mulai').textContent = (waktuMulai == '') ? 'Mulai' : waktuMulai;
    jadwalItem.querySelector('.waktu-selesai').textContent = (waktuSelesai == '') ? 'Selesai' : waktuSelesai;

    jadwalContainer.appendChild(jadwalItem);
}

function showAddJadwalModal(){
    const addEditJadwalModal = document.getElementById('add-edit-jadwal-modal');
    const submitButton = addEditJadwalModal.querySelector('.submit-button');
    submitButton.classList.remove('btn-upbg-solid');
    submitButton.classList.add('btn-green-solid');
    submitButton.textContent = 'Tambah';

    const modalForm = addEditJadwalModal.querySelector('form');

    const hariDropdown = modalForm.querySelector('.hari-dropdown');
    changeDropdownValue(hariDropdown, '');

    const waktuMulaiInput = modalForm.querySelector('.waktu-mulai-fp');
    attachTimepicker(waktuMulaiInput);
    changeTimeValue(waktuMulaiInput, '');

    const waktuSelesaiInput = modalForm.querySelector('.waktu-selesai-fp');
    attachTimepicker(waktuSelesaiInput);
    changeTimeValue(waktuSelesaiInput, '');

    const closeCallback = openModal(addEditJadwalModal, removeSubmitEvent);

    function handleSubmit(e){
        e.preventDefault();
        clearErrors(modalForm);

        const hari = modalForm.querySelector('[name="hari"]');
        const waktuMulai = modalForm.querySelector('[name="waktu-mulai"]');
        const waktuSelesai = modalForm.querySelector('[name="waktu-selesai"]');
        
        if(validateJadwalModal(hari, waktuMulai, waktuSelesai)){
            createNewJadwalItem(hari.value, waktuMulai.value, waktuSelesai.value);
            closeModal(addEditJadwalModal, closeCallback);
        }
    }
    modalForm.addEventListener('submit', handleSubmit);

    function removeSubmitEvent(){
        modalForm.removeEventListener('submit', handleSubmit);
    }
}

function showEditJadwalModal(jadwalItem){
    const addEditJadwalModal = document.getElementById('add-edit-jadwal-modal');
    const submitButton = addEditJadwalModal.querySelector('.submit-button');
    submitButton.classList.remove('btn-green-solid');
    submitButton.classList.add('btn-upbg-solid');
    submitButton.textContent = 'Simpan';

    const hariDropdown = jadwalItem.querySelector('.hari-dropdown');
    const waktuMulaiInput = jadwalItem.querySelector('.waktu-mulai-fp');
    const waktuSelesaiInput = jadwalItem.querySelector('.waktu-selesai-fp');

    const modalForm = addEditJadwalModal.querySelector('form');
    const modalHari = modalForm.querySelector('.hari-dropdown');
    const modalWaktuMulai = modalForm.querySelector('.waktu-mulai-fp');
    const modalWaktuSelesai = modalForm.querySelector('.waktu-selesai-fp');

    changeDropdownValue(modalHari, hariDropdown.querySelector('[name="hari"]').value);
    changeTimeValue(modalWaktuMulai, waktuMulaiInput.querySelector('[name="waktu-mulai"]').value);
    changeTimeValue(modalWaktuSelesai, waktuSelesaiInput.querySelector('[name="waktu-selesai"]').value);

    const closeCallback = openModal(addEditJadwalModal, removeSubmitEvent);

    function handleSubmit(e){
        e.preventDefault();
        clearErrors(modalForm);

        const hari = modalForm.querySelector('[name="hari"]');
        const waktuMulai = modalForm.querySelector('[name="waktu-mulai"]');
        const waktuSelesai = modalForm.querySelector('[name="waktu-selesai"]');

        if(validateJadwalModal(hari, waktuMulai, waktuSelesai)){
            changeDropdownValue(hariDropdown, hari.value);
            changeTimeValue(waktuMulaiInput, waktuMulai.value);
            changeTimeValue(waktuSelesaiInput, waktuSelesai.value);
            closeModal(addEditJadwalModal, closeCallback);
        }
    }
    modalForm.addEventListener('submit', handleSubmit);

    function removeSubmitEvent(){
        modalForm.removeEventListener('submit', handleSubmit);
    }
}

function validateJadwalModal(hari, waktuMulai, waktuSelesai){
    let valid = true;

    if(hari.value == ''){
        const error = createErrorText('Hari tidak boleh kosong');
        hari.closest('.input-group').appendChild(error);
        valid = false;
    }
    if(waktuMulai.value == ''){
        const error = createErrorText('Waktu mulai tidak boleh kosong');
        waktuMulai.closest('.input-group').appendChild(error);
        valid = false;
    }
    if(waktuSelesai.value == ''){
        const error = createErrorText('Waktu selesai tidak boleh kosong');
        waktuSelesai.closest('.input-group').appendChild(error);
        valid = false;
    }

    return valid;
}