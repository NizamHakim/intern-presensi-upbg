const excelCsv = document.getElementById('excel-csv');
excelCsv.addEventListener('change', async function(e){
    const file = e.target.files[0];
    try{
        const json = await parseFile(file);
        const pesertaContainer = document.querySelector('.peserta-container');
        playParsingAnimation(pesertaContainer);

        json.forEach(data => {
            appendPeserta(data['NIK/NRP'], data['Nama'], data['Dept./Occupation']);
        });

        stopParsingAnimation(pesertaContainer);
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

document.addEventListener('click', (e) => {
  if(e.target.closest('.peserta-container .delete-peserta')){
    e.stopPropagation();
    const pesertaItem = e.target.closest('.peserta-item');
    pesertaItem.remove();
    togglePesertaItemPlaceholder();
  }else if(e.target.closest('.peserta-container .edit-peserta')){
    e.stopPropagation();
    const pesertaItem = e.target.closest('.peserta-item');
    showEditPesertaModal(pesertaItem);
  }else if(e.target.closest('.peserta-container .menu')){
    e.stopPropagation();
    const menu = e.target.closest('.peserta-container .menu');
    const dialog = menu.parentElement.querySelector('.dialog');
    if(!dialog.classList.contains('open')){
      openDialog(dialog);
    }
  }
});
pesertaContainer.addEventListener('change', function(e){
  if(e.target.matches('[name="nama-peserta"]')){
    e.stopPropagation();
    const pesertaItem = e.target.closest('.peserta-item');
    pesertaItem.querySelector('.mobile-view .nama').textContent = e.target.value;
  }else if(e.target.matches('[name="nik-peserta"]')){
    e.stopPropagation();
    const pesertaItem = e.target.closest('.peserta-item');
    pesertaItem.querySelector('.mobile-view .nik').textContent = e.target.value;
  }else if(e.target.matches('[name="occupation-peserta"]')){
    e.stopPropagation();
    const pesertaItem = e.target.closest('.peserta-item');
    pesertaItem.querySelector('.mobile-view .occupation').textContent = e.target.value;
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
    submitButton.classList.remove('btn-upbg-solid');
    submitButton.classList.add('btn-green-solid');
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
    const templatePeserta = document.getElementById('template-peserta');
    const pesertaItem = templatePeserta.content.cloneNode(true);
    pesertaItem.querySelector('.nama').textContent = nama;
    pesertaItem.querySelector('.nik').textContent = nik;
    pesertaItem.querySelector('.occupation').textContent = occupation;
    pesertaItem.querySelector('[name="nik-peserta"]').value = nik;
    pesertaItem.querySelector('[name="nama-peserta"]').value = nama;
    pesertaItem.querySelector('[name="occupation-peserta"]').value = occupation;
    pesertaContainer.appendChild(pesertaItem);
    togglePesertaItemPlaceholder(); 
}

function showEditPesertaModal(pesertaItem){
    const addEditPesertaModal = document.getElementById('add-edit-peserta-modal');
    const submitButton = addEditPesertaModal.querySelector('.submit-button');
    submitButton.classList.remove('btn-green-solid');
    submitButton.classList.add('btn-upbg-solid');
    submitButton.textContent = 'Simpan';

    const pesertaNik = pesertaItem.querySelector('[name="nik-peserta"]');
    const pesertaNama = pesertaItem.querySelector('[name="nama-peserta"]');
    const pesertaOccupation = pesertaItem.querySelector('[name="occupation-peserta"]');
    
    const modalForm = addEditPesertaModal.querySelector('form');
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
        const event = new Event("change", { bubbles: true });
        pesertaNik.dispatchEvent(event);
        pesertaNama.dispatchEvent(event);
        pesertaOccupation.dispatchEvent(event);
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

const panduanPenggunaan = document.querySelector('.panduan-penggunaan');
panduanPenggunaan.addEventListener('click', (e) => {
    e.stopPropagation();
    const modal = document.getElementById('panduan-penggunaan-modal');
    openModal(modal);
});