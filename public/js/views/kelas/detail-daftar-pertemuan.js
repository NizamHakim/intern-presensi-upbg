const deleteKelas = document.querySelector('.delete-kelas');
if(deleteKelas){
    deleteKelas.addEventListener('click', function(e){
        e.stopPropagation();
        const deleteKelasDialog = document.querySelector('.delete-kelas-dialog');
        openDialog(deleteKelasDialog);
    });
}

const tambahPertemuan = document.querySelector('.tambah-pertemuan');
tambahPertemuan.addEventListener('click', function(e){
    e.stopPropagation();
    const tambahPertemuanModal = document.getElementById('tambah-pertemuan-modal');

    const modalForm = tambahPertemuanModal.querySelector('form');
    async function handleSubmit(e){
        e.preventDefault();
        clearErrors(modalForm);

        const submitButton = e.submitter;
        submitButton.classList.add('hidden');
        const loading = document.createElement('button');
        loading.setAttribute('class', 'button-loading text-sm flex flex-row items-center justify-center font-semibold px-4 py-2 border border-green-600 bg-white rounded-md cursor-progress');
        loading.setAttribute('disabled', 'true');
        loading.innerHTML = createLoadingAnimation('Validating...', 'green');
        submitButton.insertAdjacentElement('afterend', loading);

        const route = modalForm.action;
        const formData = new FormData(modalForm);
        const data = Object.fromEntries(formData.entries());

        const response = await fetchTambahPertemuan(route, data);
        loading.remove();
        submitButton.classList.remove('hidden');

        if(response.ok){
            const json = await response.json();
            window.location.replace(json.redirect);
        }else{
            if(response.status === 422){
                const errors = await response.json();
                for(const key in errors){
                    const input = modalForm.querySelector(`[name="${key}"]`);
                    const inputGroup = input.closest('.input-group');
                    const error = createErrorText(errors[key][0]);
                    inputGroup.appendChild(error);
                }
            }else{
                createToast('error', 'Terjadi kesalahan. Silahkan coba lagi.');
            }
        }
    }
    modalForm.addEventListener('submit', handleSubmit);
    function closeCallback(){
        modalForm.removeEventListener('submit', handleSubmit);
    }
    openModal(tambahPertemuanModal, closeCallback);
})

function fetchTambahPertemuan(route, data){
    return fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    });
}