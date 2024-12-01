document.addEventListener('click', (e) => {
    if(e.target.closest('.edit-program')){
        e.stopPropagation();
        const row = e.target.closest('tr');
        const clone = startEditing(row);
        row.replaceWith(clone);
        clone.querySelector('[name="nama-program"]').focus();
    }else if(e.target.closest('.delete-program')){
        e.stopPropagation();
        const row = e.target.closest('tr');
        showDeleteDialog(row);
    }
});

function startEditing(row){
    const clone = row.cloneNode(true);
    const namaProgram = clone.querySelector('.nama-program');
    const kodeProgram = clone.querySelector('.kode-program');
    const statusProgram = clone.querySelector('.status-program');
    const editButton = clone.querySelector('.edit-program');
    const deleteButton = clone.querySelector('.delete-program');

    const namaProgramInput = document.createElement('input');
    namaProgramInput.setAttribute('type', 'text');
    namaProgramInput.setAttribute('value', namaProgram.textContent);
    namaProgramInput.setAttribute('class', 'px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light');
    namaProgramInput.setAttribute('placeholder', 'Nama Program');
    namaProgramInput.setAttribute('name', 'nama-program');
    namaProgram.replaceWith(namaProgramInput);

    const kodeProgramInput = document.createElement('input');
    kodeProgramInput.setAttribute('type', 'text');
    kodeProgramInput.setAttribute('value', (kodeProgram.textContent != '-') ? kodeProgram.textContent : '');
    kodeProgramInput.setAttribute('class', 'px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light');
    kodeProgramInput.setAttribute('placeholder', 'Kode Program');
    kodeProgramInput.setAttribute('name', 'kode-program');
    kodeProgram.replaceWith(kodeProgramInput);
    
    const statusProgramCheckbox = createCheckboxWithIcon('status-program', true, statusProgram.textContent === 'Aktif');
    statusProgram.replaceWith(statusProgramCheckbox);

    const cancelButton = document.createElement('button');
    cancelButton.setAttribute('type', 'button');
    cancelButton.setAttribute('class', 'cancel-button bg-transparent hover:bg-white transition duration-300 text-sm px-6 py-2 font-medium text-gray-800 rounded-md');
    cancelButton.textContent = 'Cancel';
    deleteButton.replaceWith(cancelButton);

    function handleCancel(e){
        e.stopPropagation();
        stopEditing(clone, row, () => {
            cancelButton.removeEventListener('click', handleCancel);
            document.removeEventListener('click', handleClickOutside);
        });
    }
    cancelButton.addEventListener('click', handleCancel);

    function handleClickOutside(e){
        if(!clone.contains(e.target)){
            stopEditing(clone, row, () => {
                cancelButton.removeEventListener('click', handleCancel);
                document.removeEventListener('click', handleClickOutside);
            });
        }
    }
    document.addEventListener('click', handleClickOutside);

    const saveButton = document.createElement('button');
    saveButton.setAttribute('type', 'button');
    saveButton.setAttribute('class', 'bg-green-600 transition duration-300 hover:bg-green-700 text-sm px-6 py-2 font-medium text-white rounded-md');
    saveButton.textContent = 'Save';
    saveButton.value = row.getAttribute('data-program-id');
    editButton.replaceWith(saveButton);

    function handleSave(e){
        e.stopPropagation();
        saveInput(saveButton.value, clone, row, handleClickOutside);
    }
    saveButton.addEventListener('click', handleSave);

    return clone;
}

function stopEditing(clone, row, callback){
    clone.replaceWith(row);
    callback();
}

async function saveInput(id, clone, row, handleClickOutside){
    clone.querySelectorAll('.error').forEach(error => error.remove());
    playFetchingAnimation(clone);
    document.removeEventListener('click', handleClickOutside); // temporarily remove click outside

    const response = await fetchSubmit(id, clone);
    stopFetchingAnimation(clone);

    if(response.ok){
        const json = await response.json();
        const newRow = updateRow(row, json);
        clone.replaceWith(newRow);
        createToast('success', 'Program berhasil diubah');
    }else{
        if(response.status === 422){
            const errors = await response.json();
            for(const key in errors){
                const input = clone.querySelector(`[name="${key}"]`);
                const errorText = createErrorText(errors[key][0]);
                input.parentNode.appendChild(errorText);
            }
        }else{
            createToast('error', 'Terjadi kesalahan. Silahkan coba lagi.');
        }
        document.addEventListener('click', handleClickOutside); // if error, add back click outside
    }
}

function fetchSubmit(id, clone){
    const inputNamaProgram = clone.querySelector('[name="nama-program"]');
    const inputKodeProgram = clone.querySelector('[name="kode-program"]');
    const inputStatusProgram = clone.querySelector('[name="status-program"]');

    return fetch(`/program-kelas/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
            "nama-program": inputNamaProgram.value,
            "kode-program": inputKodeProgram.value,
            "status-program": inputStatusProgram.checked,
        }),
    });
}

function updateRow(row, json){
    const namaProgram = row.querySelector('.nama-program');
    const kodeProgram = row.querySelector('.kode-program');
    const statusProgram = row.querySelector('.status-program');

    row.setAttribute('data-program-id', json.id);
    namaProgram.textContent = json.nama;
    kodeProgram.textContent = json.kode ? json.kode : '-';
    statusProgram.textContent = json.aktif ? 'Aktif' : 'Tidak aktif';
    if(json.aktif){
        statusProgram.classList.add('bg-green-300', 'text-green-800');
        statusProgram.classList.remove('bg-red-300', 'text-red-800');
    }else{
        statusProgram.classList.add('bg-red-300', 'text-red-800');
        statusProgram.classList.remove('bg-green-300', 'text-green-800');
    }

    return row;
}

function playFetchingAnimation(clone){
    const buttonContainer = clone.querySelector('.button-container');
    const loading = document.createElement('div');
    loading.setAttribute('class', 'loading flex flex-row items-center justify-center font-semibold');
    loading.innerHTML = createLoadingAnimation('Updating...');
    buttonContainer.parentNode.appendChild(loading);
    buttonContainer.classList.add('hidden');
}

function stopFetchingAnimation(clone){
    const buttonContainer = clone.querySelector('.button-container');
    const loading = clone.querySelector('.loading');
    loading.remove();
    buttonContainer.classList.remove('hidden');
}

function showDeleteDialog(row){
    const id = row.getAttribute('data-program-id');
    const namaProgram = row.querySelector('.nama-program').textContent;
    const kodeProgram = (row.querySelector('.kode-program').textContent != '-') ? row.querySelector('.kode-program').textContent : '';

    const deleteProgramDialog = document.querySelector('.delete-program-dialog');
    const deleteDialogContent = deleteProgramDialog.querySelector('.delete-dialog-content');
    const namaKodeProgram = deleteDialogContent.querySelector('.nama-kode-program')
    namaKodeProgram.textContent = `${namaProgram}`;
    namaKodeProgram.textContent += (kodeProgram) ? ` - ${kodeProgram}` : '';

    const programId = deleteDialogContent.querySelector('[name="program-id"]');
    programId.value = id;

    openDialog(deleteProgramDialog);
}