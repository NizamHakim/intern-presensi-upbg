const editForm = document.querySelector('.edit-form');
editForm.addEventListener('submit', async function(e){
    e.preventDefault();
    clearErrors(editForm);
    const route = editForm.getAttribute('action');
    const submitButton = e.submitter;

    const formData = new FormData(editForm);
    const data = Object.fromEntries(formData);
    data['pengajar'] = formData.getAll('pengajar[]');
    
    playFetchingAnimation(submitButton, 'green', 'Validating...');
    const response = await fetchRequest(route, 'PUT', data);
    stopFetchingAnimation(submitButton);

    if(response.ok){
        const json = await response.json();
        window.location.replace(json.redirect);
    }else{
        handleError(response, editForm);
    }
});

const kodeFormers = editForm.querySelectorAll('.kode-former');
kodeFormers.forEach(former => {
    const input = former.querySelector('input');
    if(input.type == 'number'){
        input.addEventListener('input', function(){
            updateKodeKelas();
        });
    }else{
        input.addEventListener('change', function(){
            updateKodeKelas();
        });
    }
});

function updateKodeKelas(){
    const kodeKelas = editForm.querySelector('[name="kode-kelas"]');
    const kodeProgram = extractDropdownText(editForm.querySelector('[name="program-kode"]').previousElementSibling);
    const kodeTipe = extractDropdownText(editForm.querySelector('[name="tipe-kode"]').previousElementSibling);
    const nomorKelas = editForm.querySelector('[name="nomor-kelas"]').value;
    const kodeLevel = extractDropdownText(editForm.querySelector('[name="level-kode"]').previousElementSibling);
    const banyakPertemuan = editForm.querySelector('[name="banyak-pertemuan"]').value;
    const tanggalMulai = new Date(editForm.querySelector('[name="tanggal-mulai"]').value)
    const bulanMulai = monthParse(tanggalMulai.getMonth());
    const tahunMulai = tanggalMulai.getFullYear();

    let array = [`${kodeProgram}`, `${kodeTipe}.${nomorKelas}`, `${kodeLevel}`, `${banyakPertemuan}`, `${bulanMulai}`, `${tahunMulai}`];
    array = array.filter(item => item !== '' && item !== null && item !== 'NaN' && item !== 'undefined' && item !== '.');
    kodeKelas.value = array.join('/');
}

function extractDropdownText(dropdownButton){
    const text = dropdownButton.querySelector('span').textContent;
    return (text.match(/\(([^)]+)\)/)) ? text.match(/\(([^)]+)\)/)[1] : '';
}

function monthParse(num){
    const roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
    return roman[num];
}

const pengajarContainer = editForm.querySelector('.pengajar-container');
pengajarContainer.addEventListener('click', function(e){
    if(e.target.closest('.delete-pengajar')){
        e.stopPropagation();
        const dropdownPengajar = e.target.closest('.dropdown-pengajar');
        dropdownPengajar.remove();
    }
});

const tambahPengajar = editForm.querySelector('.tambah-pengajar');
tambahPengajar.addEventListener('click', function(){
    const dropdownPengajar = document.querySelector('.dropdown-pengajar');
    const dropdownPengajarClone = dropdownPengajar.cloneNode(true);
    addDeletePengajarButton(dropdownPengajarClone);
    resetDropdownValue(dropdownPengajarClone.querySelector('.input-dropdown'));
    pengajarContainer.appendChild(dropdownPengajarClone);
});

function addDeletePengajarButton(dropdownPengajar){
    const deleteButton = document.createElement('button');
    deleteButton.setAttribute('type', 'button');
    deleteButton.setAttribute('class', 'delete-pengajar font-medium text-red-600 bg-white border size-10 rounded-full transition hover:bg-red-600 hover:text-white hover:border-red-600');
    deleteButton.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
    dropdownPengajar.appendChild(deleteButton);
}