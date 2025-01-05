const pengawasSection = document.getElementById('pengawas-section');

const pengawasContainer = pengawasSection.querySelector('.pengawas-container');
pengawasContainer.addEventListener('click', function(e){
    if(e.target.closest('.delete-pengawas')){
        e.stopPropagation();
        const pengawasItem = e.target.closest('.pengawas-item');
        pengawasItem.remove();
    }
});

const tambahPengawas = pengawasSection.querySelector('.tambah-pengawas');
tambahPengawas.addEventListener('click', function(){
    const templatePengawas = document.getElementById('template-pengawas');
    const pengawasItem = templatePengawas.content.cloneNode(true);
    pengawasContainer.appendChild(pengawasItem);
});