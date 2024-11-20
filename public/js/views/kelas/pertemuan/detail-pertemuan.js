const mulaiPertemuanButton = document.getElementById('mulai-pertemuan');
mulaiPertemuanButton.addEventListener('click', (e) => {
    e.stopPropagation();    
    openModal('mulai-pertemuan-modal');
});

const tambahPartisipanButton = document.getElementById('tambah-partisipan');
tambahPartisipanButton.addEventListener('click', (e) => {
    e.stopPropagation();
    openModal('tambah-partisipan-modal');
});