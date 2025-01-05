const ruanganSection = document.getElementById('ruangan-section');

const ruanganContainer = ruanganSection.querySelector('.ruangan-container');
ruanganContainer.addEventListener('click', function(e){
    if(e.target.closest('.delete-ruangan')){
        e.stopPropagation();
        const ruanganItem = e.target.closest('.ruangan-item');
        ruanganItem.remove();
    }
});

const tambahRuangan = ruanganSection.querySelector('.tambah-ruangan');
tambahRuangan.addEventListener('click', function(){
    const templateRuangan = document.getElementById('template-ruangan');
    const ruanganItem = templateRuangan.content.cloneNode(true);
    ruanganContainer.appendChild(ruanganItem);
});