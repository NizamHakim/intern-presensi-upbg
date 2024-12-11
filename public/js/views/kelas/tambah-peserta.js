const excelCsv = document.getElementById('excel-csv');
excelCsv.addEventListener('change', async function(e){
    const file = e.target.files[0];
    try{
        const json = await parseFile(file);
        const formSection = document.getElementById('form-section');
        playParsingAnimation(formSection);

        json.forEach(data => {
            appendPeserta(data['NIK/NRP'], data['Nama'], data['Dept./Occupation']);
        });

        stopParsingAnimation(formSection);
    }catch(error){
        createToast('error', error.message);
    }
    excelCsv.value = '';
});

function playParsingAnimation(element){
    element.classList.add('hidden');
    const parsingDiv = document.createElement('div');
    parsingDiv.setAttribute('class', 'parsing-div flex flex-row justify-center items-center w-full h-14 border border-dashed border-gray-400 rounded-md');
    parsingDiv.innerHTML = createLoadingAnimation('Parsing file...', 'blue');
    element.insertAdjacentElement('afterend', parsingDiv);
}

function stopParsingAnimation(element){
    const parsingDiv = document.querySelector('.parsing-div');
    parsingDiv.remove();
    element.classList.remove('hidden');
}

const pesertaContainer = document.querySelector('.peserta-container');
pesertaContainer.addEventListener('click', (e) => {
    if(e.target.closest('.delete-peserta')){
        e.stopPropagation();
        const pesertaItem = e.target.closest('.peserta-item');
        pesertaItem.remove();
        togglePesertaItemPlaceholder();
    }else if(e.target.closest('.edit-peserta')){
        e.stopPropagation();
        const pesertaItem = e.target.closest('.peserta-item');
        showEditPesertaModal(pesertaItem);
    }
});

const tambahPeserta = document.querySelector('.tambah-peserta');
tambahPeserta.addEventListener('click', (e) => {
    e.stopPropagation();
    if(window.matchMedia('(max-width: 768px)').matches){
        showAddPesertaModal();
    }else{
        appendPeserta();
    }
});

function showAddPesertaModal(){
    const addEditPesertaModal = document.getElementById('add-edit-peserta-modal');
    const submitButton = addEditPesertaModal.querySelector('.submit-button');
    submitButton.classList.remove('button-upbg-solid');
    submitButton.classList.add('button-green-solid');
    submitButton.textContent = 'Tambah';

    const modalForm = addEditPesertaModal.querySelector('form');
    modalForm.querySelector('[name="nik-peserta"]').value = '';
    modalForm.querySelector('[name="nama-peserta"]').value = '';
    modalForm.querySelector('[name="occupation-peserta"]').value = '';

    const closeCallback = openModal(addEditPesertaModal, removeSubmitEvent);

    function handleSubmit(e){
        e.preventDefault();
        const nik = modalForm.querySelector('[name="nik-peserta"]').value;
        const nama = modalForm.querySelector('[name="nama-peserta"]').value;
        const occupation = modalForm.querySelector('[name="occupation-peserta"]').value;
        appendPeserta(nik, nama, occupation);
        closeModal(addEditPesertaModal, closeCallback);
    }
    modalForm.addEventListener('submit', handleSubmit);

    function removeSubmitEvent(){
        modalForm.removeEventListener('submit', handleSubmit);
    }
}

function appendPeserta(nik = '', nama = '', occupation = ''){
    const pesertaItem = document.createElement('div');
    pesertaItem.setAttribute('class', 'peserta-item flex flex-row gap-3 relative border shadow-sm rounded-md md:border-none md:shadow-none');
    pesertaItem.innerHTML = `
        <div class="input-container flex-1 flex flex-col gap-2 flex-wrap p-3 md:p-0 md:flex-row">
            <div class="input-group flex flex-col flex-1">
                <label class="font-medium text-gray-700 md:hidden">NIK / NRP :</label>
                <input type="text" name="nik-peserta" placeholder="NIK / NRP" class="min-w-0 input-text-style max-w-[calc(100%-72px)] md:max-w-none md:input-style" value="${nik}">
            </div>
            <div class="input-group flex flex-col flex-1">
                <label class="font-medium text-gray-700 md:hidden">Nama :</label>
                <input type="text" name="nama-peserta" placeholder="Nama" class="min-w-0 input-text-style md:input-style" value="${nama}">
            </div>
            <div class="input-group flex flex-col flex-1">
                <label class="font-medium text-gray-700 md:hidden">Departemen / Occupation :</label>
                <input type="text" name="occupation-peserta" placeholder="Departemen / Occupation" class="min-w-0 input-text-style md:input-style" value="${occupation}">
            </div>
        </div>
        <div class="flex flex-row gap-2 absolute top-2 right-2 md:static">
            <button type="button" class="edit-peserta font-medium text-upbg bg-white size-8 rounded-sm-md transition hover:bg-upbg hover:text-white hover:border-upbg md:hidden"><i class="fa-regular fa-pen-to-square"></i></button>
            <button type="button" class="delete-peserta font-medium text-red-600 bg-white size-8 rounded-sm-md transition hover:bg-red-600 hover:text-white hover:border-red-600 md:size-10 md:rounded-full md:border"><i class="fa-regular fa-trash-can"></i></button>
        </div>
    `
    pesertaContainer.appendChild(pesertaItem);
    togglePesertaItemPlaceholder();
}

function showEditPesertaModal(pesertaItem){
    const addEditPesertaModal = document.getElementById('add-edit-peserta-modal');
    const submitButton = addEditPesertaModal.querySelector('.submit-button');
    submitButton.classList.remove('button-green-solid');
    submitButton.classList.add('button-upbg-solid');
    submitButton.textContent = 'Simpan';

    const modalForm = addEditPesertaModal.querySelector('form');
    const pesertaNik = pesertaItem.querySelector('[name="nik-peserta"]');
    const pesertaNama = pesertaItem.querySelector('[name="nama-peserta"]');
    const pesertaOccupation = pesertaItem.querySelector('[name="occupation-peserta"]');
    const modalNik = modalForm.querySelector('[name="nik-peserta"]');
    const modalNama = modalForm.querySelector('[name="nama-peserta"]');
    const modalOccupation = modalForm.querySelector('[name="occupation-peserta"]');
    modalNik.value = pesertaNik.value;
    modalNama.value = pesertaNama.value;
    modalOccupation.value = pesertaOccupation.value;
    
    const closeCallback = openModal(addEditPesertaModal, removeSubmitEvent);

    function handleSubmit(e){
        e.preventDefault();
        pesertaNik.value = modalNik.value;
        pesertaNama.value = modalNama.value;
        pesertaOccupation.value = modalOccupation.value;
        clearErrors(pesertaItem);
        closeModal(addEditPesertaModal, closeCallback);
    }
    modalForm.addEventListener('submit', handleSubmit);

    function removeSubmitEvent(){
        modalForm.removeEventListener('submit', handleSubmit);
    }
}

function togglePesertaItemPlaceholder(){
    const pesertaItemPlaceholder = document.querySelector('.peserta-item-placeholder');
    const pesertaItem = document.querySelector('.peserta-item');
    if(pesertaItem){
        pesertaItemPlaceholder.classList.add('hidden');
    }else{
        pesertaItemPlaceholder.classList.remove('hidden');
    }
}

const tambahPesertaForm = document.querySelector('.tambah-peserta-form');
tambahPesertaForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    clearErrors(tambahPesertaForm);
    const route = tambahPesertaForm.getAttribute('action');
    const submitButton = e.submitter;

    const form = e.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    delete data['nik-peserta'];
    delete data['nama-peserta'];
    delete data['occupation-peserta'];
    data['nik-peserta'] = formData.getAll('nik-peserta');
    data['nama-peserta'] = formData.getAll('nama-peserta');
    data['occupation-peserta'] = formData.getAll('occupation-peserta');
    
    playFetchingAnimation(submitButton, 'green', 'Validating...');
    const response = await fetchRequest(route, 'POST', data);
    stopFetchingAnimation(submitButton);

    if(response.ok){
        const json = await response.json();
        window.location.replace(json.redirect);
    }else{
        handleError(response, tambahPesertaForm);
    }
});