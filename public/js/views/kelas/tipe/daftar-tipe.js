document.addEventListener('click', (e) => {
    if(e.target.matches('.edit-tipe')){
        e.stopPropagation();
        const row = e.target.closest('tr');
        const clone = startEditing(row);
        row.replaceWith(clone);
        clone.querySelector('[name="nama-tipe"]').focus();
    }else if(e.target.matches('.delete-tipe')){
        e.stopPropagation();
        const row = e.target.closest('tr');
        showDeleteDialog(row);
    }
});

function startEditing(row){
    const clone = row.cloneNode(true);
    const namaTipe = clone.querySelector('.nama-tipe');
    const kodeTipe = clone.querySelector('.kode-tipe');
    const statusTipe = clone.querySelector('.status-tipe');
    const editButton = clone.querySelector('.edit-tipe');
    const deleteButton = clone.querySelector('.delete-tipe');

    const namaTipeInput = document.createElement('input');
    namaTipeInput.setAttribute('type', 'text');
    namaTipeInput.setAttribute('value', namaTipe.textContent);
    namaTipeInput.setAttribute('class', 'px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light');
    namaTipeInput.setAttribute('placeholder', 'Nama Tipe');
    namaTipeInput.setAttribute('name', 'nama-tipe');
    namaTipe.replaceWith(namaTipeInput);

    const kodeTipeInput = document.createElement('input');
    kodeTipeInput.setAttribute('type', 'text');
    kodeTipeInput.setAttribute('value', (kodeTipe.textContent != '-') ? kodeTipe.textContent : '');
    kodeTipeInput.setAttribute('class', 'px-3 h-10 rounded-md border border-gray-200 text-gray-600 font-medium placeholder:text-gray-400 outline outline-transparent outline-1.5 outline-offset-0 transition-all focus:outline-upbg-light');
    kodeTipeInput.setAttribute('placeholder', 'Kode Tipe');
    kodeTipeInput.setAttribute('name', 'kode-tipe');
    kodeTipe.replaceWith(kodeTipeInput);
    
    const statusTipeCheckbox = createCheckboxWithIcon('status-tipe', true, statusTipe.textContent === 'Aktif');
    statusTipe.replaceWith(statusTipeCheckbox);

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
    saveButton.value = row.getAttribute('data-tipe-id');
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
    const inputNamaTipe = clone.querySelector('[name="nama-tipe"]');
    const inputKodeTipe = clone.querySelector('[name="kode-tipe"]');
    const inputStatusTipe = clone.querySelector('[name="status-tipe"]');

    return fetch(`/tipe-kelas/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
            "nama-tipe": inputNamaTipe.value,
            "kode-tipe": inputKodeTipe.value,
            "status-tipe": inputStatusTipe.checked,
        }),
    });
}

function updateRow(row, json){
    const namaTipe = row.querySelector('.nama-tipe');
    const kodeTipe = row.querySelector('.kode-tipe');
    const statusTipe = row.querySelector('.status-tipe');

    row.setAttribute('data-tipe-id', json.id);
    namaTipe.textContent = json.nama;
    kodeTipe.textContent = json.kode;
    statusTipe.textContent = json.aktif ? 'Aktif' : 'Tidak aktif';
    if(json.aktif){
        statusTipe.classList.add('bg-green-300', 'text-green-800');
        statusTipe.classList.remove('bg-red-300', 'text-red-800');
    }else{
        statusTipe.classList.add('bg-red-300', 'text-red-800');
        statusTipe.classList.remove('bg-green-300', 'text-green-800');
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
    const id = row.getAttribute('data-tipe-id');
    const namaTipe = row.querySelector('.nama-tipe').textContent;
    const kodeTipe = row.querySelector('.kode-tipe').textContent;

    const deleteDialogContent = document.getElementById('delete-dialog-content');
    const namaKodeTipe = deleteDialogContent.querySelector('.nama-kode-tipe')
    namaKodeTipe.textContent = `${namaTipe} - ${kodeTipe}`;

    const tipeId = deleteDialogContent.querySelector('[name="tipe-id"]');
    tipeId.value = id;

    openDialog();
}