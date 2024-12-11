const jadwalSection = document.getElementById('jadwal-section');
const jadwalContainer = jadwalSection.querySelector('.jadwal-container');

jadwalContainer.addEventListener('click', function(e){
    if(e.target.closest('.delete-jadwal')){
        e.stopPropagation();
        const jadwalItem = e.target.closest('.jadwal-item');
        jadwalItem.remove();
    }else if(e.target.closest('.edit-jadwal')){
        e.stopPropagation();
        const jadwalItem = e.target.closest('.jadwal-item');
        showEditJadwalModal(jadwalItem);
    }
});
jadwalContainer.addEventListener('change', function(e){
    if(e.target.matches('.hari-dropdown')){
        e.stopPropagation();
        const dropdown = e.target;
        const text = dropdown.querySelector('.dropdown-text').textContent;
        dropdown.parentElement.querySelector('.hari-mobile').textContent = text;

    }else if(e.target.closest('.waktu-mulai')){
        e.stopPropagation();
        const timepickr = e.target;
        const text = timepickr.value;
        timepickr.closest('.waktu-mulai').parentElement.querySelector('.waktu-mulai-mobile').textContent = text;
        
    }else if(e.target.closest('.waktu-selesai')){
        e.stopPropagation();
        const timepickr = e.target;
        const text = timepickr.value;
        timepickr.closest('.waktu-selesai').parentElement.querySelector('.waktu-selesai-mobile').textContent = text;
    }
});

const tambahJadwal = jadwalSection.querySelector('.tambah-jadwal');
tambahJadwal.addEventListener('click', function(e){
    e.stopPropagation();
    if(window.matchMedia('(max-width: 768px)').matches){
        showAddJadwalModal();
    }else{
        createNewJadwalItem();
    }
});

function createNewJadwalItem(hari = '', waktuMulai = '', waktuSelesai = ''){
    const jadwalItem = jadwalContainer.querySelector('.jadwal-item');
    const jadwalItemClone = jadwalItem.cloneNode(true);

    jadwalItemClone.querySelector('.input-container').classList.remove('md:mr-[3.25rem]');
    addDeleteJadwalButton(jadwalItemClone);
    clearErrors(jadwalItemClone);

    const hariDropdown = jadwalItemClone.querySelector('.hari-dropdown');
    const hariArray = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    changeDropdownValue(hariDropdown, hari);
    jadwalItemClone.querySelector('.hari-mobile').textContent = (hari == '') ? 'Pilih hari' : hariArray[hari];

    const waktuMulaiInput = jadwalItemClone.querySelector('.waktu-mulai');
    attachTimepicker(waktuMulaiInput);
    changeTimeValue(waktuMulaiInput, waktuMulai);
    jadwalItemClone.querySelector('.waktu-mulai-mobile').textContent = (waktuMulai == '') ? 'Waktu mulai' : waktuMulai;

    const waktuSelesaiInput = jadwalItemClone.querySelector('.waktu-selesai');
    attachTimepicker(waktuSelesaiInput);
    changeTimeValue(waktuSelesaiInput, waktuSelesai);
    jadwalItemClone.querySelector('.waktu-selesai-mobile').textContent = (waktuSelesai == '') ? 'Waktu selesai' : waktuSelesai;

    jadwalContainer.appendChild(jadwalItemClone);
}

function addDeleteJadwalButton(jadwalItem){
    const jadwalButtons = jadwalItem.querySelector('.jadwal-buttons');
    jadwalButtons.classList.add('md:ml-3');

    const deleteButton = document.createElement('button');
    deleteButton.setAttribute('type', 'button');
    deleteButton.setAttribute('class', 'delete-jadwal font-medium text-red-600 bg-white size-8 rounded-sm-md transition md:hover:bg-red-600 md:hover:text-white md:hover:border-red-600 md:size-10 md:rounded-full md:border');
    deleteButton.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
    jadwalButtons.appendChild(deleteButton);
}

// for mobile support
function showAddJadwalModal(){
    const addEditJadwalModal = document.getElementById('add-edit-jadwal-modal');
    const submitButton = addEditJadwalModal.querySelector('.submit-button');
    submitButton.classList.remove('button-upbg-solid');
    submitButton.classList.add('button-green-solid');
    submitButton.textContent = 'Tambah';

    const modalForm = addEditJadwalModal.querySelector('form');

    const hariDropdown = modalForm.querySelector('.hari-dropdown');
    changeDropdownValue(hariDropdown, '');

    const waktuMulaiInput = modalForm.querySelector('.waktu-mulai');
    attachTimepicker(waktuMulaiInput);
    changeTimeValue(waktuMulaiInput, '');

    const waktuSelesaiInput = modalForm.querySelector('.waktu-selesai');
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
    submitButton.classList.remove('button-green-solid');
    submitButton.classList.add('button-upbg-solid');
    submitButton.textContent = 'Simpan';

    const hariDropdown = jadwalItem.querySelector('.hari-dropdown');
    const waktuMulaiInput = jadwalItem.querySelector('.waktu-mulai');
    const waktuSelesaiInput = jadwalItem.querySelector('.waktu-selesai');

    const modalForm = addEditJadwalModal.querySelector('form');
    const modalHari = modalForm.querySelector('.hari-dropdown');
    const modalWaktuMulai = modalForm.querySelector('.waktu-mulai');
    const modalWaktuSelesai = modalForm.querySelector('.waktu-selesai');

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