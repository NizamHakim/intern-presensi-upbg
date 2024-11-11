document.addEventListener('click', (e) => {
    if(e.target.matches('.edit-level')){
        e.stopPropagation();
        const row = e.target.closest('tr');
        const clone = startEditing(row);
        row.replaceWith(clone);
        clone.querySelector('[name="nama-level"]').focus();
    }else if(e.target.matches('.delete-level')){
        e.stopPropagation();
        const row = e.target.closest('tr');
        showDeleteDialog(row);
    }
});

function startEditing(row){
    const clone = row.cloneNode(true);
    const namaLevel = clone.querySelector('.nama-level');
    const kodeLevel = clone.querySelector('.kode-level');
    const statusLevel = clone.querySelector('.status-level');
    const editButton = clone.querySelector('.edit-level');
    const deleteButton = clone.querySelector('.delete-level');

    const namaLevelInput = document.createElement('input');
    namaLevelInput.setAttribute('type', 'text');
    namaLevelInput.setAttribute('value', namaLevel.textContent);
    namaLevelInput.setAttribute('class', 'px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light');
    namaLevelInput.setAttribute('placeholder', 'Nama Level');
    namaLevelInput.setAttribute('name', 'nama-level');
    namaLevel.replaceWith(namaLevelInput);

    const kodeLevelInput = document.createElement('input');
    kodeLevelInput.setAttribute('type', 'text');
    kodeLevelInput.setAttribute('value', (kodeLevel.textContent != '-') ? kodeLevel.textContent : '');
    kodeLevelInput.setAttribute('class', 'px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light');
    kodeLevelInput.setAttribute('placeholder', 'Kode Level');
    kodeLevelInput.setAttribute('name', 'kode-level');
    kodeLevel.replaceWith(kodeLevelInput);
    
    const statusLevelCheckbox = createCheckboxWithIcon('status-level', true, statusLevel.textContent === 'Aktif');
    statusLevel.replaceWith(statusLevelCheckbox);

    const cancelButton = document.createElement('button');
    cancelButton.setAttribute('type', 'button');
    cancelButton.setAttribute('class', 'cancel-button px-3 py-2 text-gray-400 font-semibold');
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
    saveButton.setAttribute('class', 'px-3 py-2 text-green-600 font-semibold');
    saveButton.textContent = 'Save';
    saveButton.value = row.getAttribute('data-level-id');
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
    if(response.ok){
        const json = await response.json();
        const newRow = updateRow(row, json);
        clone.replaceWith(newRow);
    }else{
        const errors = await response.json();
        for(const key in errors){
            console.log(key, errors[key]);
            const input = clone.querySelector(`[name="${key}"]`);
            const errorSpan = createErrorSpan(errors[key][0]);
            input.parentNode.appendChild(errorSpan);
        }
        stopFetchingAnimation(clone);
        document.addEventListener('click', handleClickOutside); // if error, add back click outside
    }
}

function fetchSubmit(id, clone){
    const inputNamaLevel = clone.querySelector('[name="nama-level"]');
    const inputKodeLevel = clone.querySelector('[name="kode-level"]');
    const inputStatusLevel = clone.querySelector('[name="status-level"]');

    return fetch(`/level-kelas/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
            "nama-level": inputNamaLevel.value,
            "kode-level": inputKodeLevel.value,
            "status-level": inputStatusLevel.checked,
        }),
    });
}

function updateRow(row, json){
    const namaLevel = row.querySelector('.nama-level');
    const kodeLevel = row.querySelector('.kode-level');
    const statusLevel = row.querySelector('.status-level');

    row.setAttribute('data-level-id', json.id);
    namaLevel.textContent = json.nama;
    kodeLevel.textContent = json.kode;
    statusLevel.textContent = json.aktif ? 'Aktif' : 'Tidak aktif';
    if(json.aktif){
        statusLevel.classList.add('bg-green-300', 'text-green-800');
        statusLevel.classList.remove('bg-red-300', 'text-red-800');
    }else{
        statusLevel.classList.add('bg-red-300', 'text-red-800');
        statusLevel.classList.remove('bg-green-300', 'text-green-800');
    }

    return row;
}

function playFetchingAnimation(clone){
    const buttonContainer = clone.querySelector('.button-container');
    const loading = createLoadingAnimation('Updating...');
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
    const id = row.getAttribute('data-level-id');
    const namaLevel = row.querySelector('.nama-level').textContent;
    const kodeLevel = row.querySelector('.kode-level').textContent;

    const deleteDialogContent = document.getElementById('delete-dialog-content');
    const namaKodeLevel = deleteDialogContent.querySelector('.nama-kode-level')
    namaKodeLevel.textContent = `${namaLevel} - ${kodeLevel}`;

    const levelId = deleteDialogContent.querySelector('[name="level-id"]');
    levelId.value = id;

    openDialog();
}