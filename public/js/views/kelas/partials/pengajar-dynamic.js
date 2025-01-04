const pengajarSection = document.getElementById('pengajar-section');

const pengajarContainer = pengajarSection.querySelector('.pengajar-container');
pengajarContainer.addEventListener('click', function(e){
    if(e.target.closest('.delete-pengajar')){
        e.stopPropagation();
        const pengajarItem = e.target.closest('.pengajar-item');
        pengajarItem.remove();
    }
});

const tambahPengajar = pengajarSection.querySelector('.tambah-pengajar');
tambahPengajar.addEventListener('click', function(){
    const templatePengajar = document.getElementById('template-pengajar');
    const pengajarItem = templatePengajar.content.cloneNode(true);
    pengajarContainer.appendChild(pengajarItem);
});