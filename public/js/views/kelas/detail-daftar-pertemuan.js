const detailKelasSection = document.getElementById('detail-kelas');
const deleteKelas = detailKelasSection.querySelector('.delete-kelas');
if(deleteKelas){
    deleteKelas.addEventListener('click', function(e){
        e.stopPropagation();
        const deleteKelasModal = document.getElementById('delete-kelas-modal');
        const modalForm = deleteKelasModal.querySelector('form');
        
        openModal(deleteKelasModal, removeEventListener);

        async function handleSubmit(e){
            e.preventDefault();
            const route = modalForm.action;
            const submitButton = e.submitter;

            playFetchingAnimation(submitButton, 'red', 'Deleting...');
            const response = await fetchRequest(route, 'DELETE');
            stopFetchingAnimation(submitButton);

            if(response.ok){
                const json = await response.json();
                saveToast('success', json.message);
                window.location.replace(json.redirect);
            }else{
                handleError(response, modalForm);
            }
        }   
        modalForm.addEventListener('submit', handleSubmit);

        function removeEventListener(){
            modalForm.removeEventListener('submit', handleSubmit);
        }
    });
}


const pertemuanTerlaksanaSection = document.getElementById('pertemuan-terlaksana');
const tambahPertemuan = pertemuanTerlaksanaSection.querySelector('.tambah-pertemuan');
tambahPertemuan.addEventListener('click', function(e){
    e.stopPropagation();
    const tambahPertemuanModal = document.getElementById('tambah-pertemuan-modal');
    const modalForm = tambahPertemuanModal.querySelector('form');

    async function handleSubmit(e){
        e.preventDefault();
        clearErrors(modalForm);
        
        const route = modalForm.action;
        const formData = new FormData(modalForm);
        const data = Object.fromEntries(formData.entries());
        
        const submitButton = e.submitter;
        playFetchingAnimation(submitButton, 'green', 'Validating...');
        const response = await fetchRequest(route, 'POST', data);
        stopFetchingAnimation(submitButton);

        if(response.ok){
            const json = await response.json();
            saveToast('success', json.message);
            window.location.replace(json.redirect);
        }else{
            handleError(response, modalForm);
        }
    }
    modalForm.addEventListener('submit', handleSubmit);

    function closeCallback(){
        modalForm.removeEventListener('submit', handleSubmit);
    }
    openModal(tambahPertemuanModal, closeCallback);
})