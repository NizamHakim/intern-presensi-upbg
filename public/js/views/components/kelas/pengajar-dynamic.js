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
    const pengajarItem = pengajarContainer.querySelector('.pengajar-item');
    const pengajarItemClone = pengajarItem.cloneNode(true);
    pengajarItemClone.classList.remove('mr-[3.25rem]');
    changeDropdownValue(pengajarItemClone.querySelector('.input-dropdown.pengajar-dropdown'), '');
    addDeletePengajarButton(pengajarItemClone);
    pengajarContainer.appendChild(pengajarItemClone);
});

function addDeletePengajarButton(pengajarItem){
    const deleteButton = document.createElement('button');
    deleteButton.setAttribute('type', 'button');
    deleteButton.setAttribute('class', 'delete-pengajar font-medium text-red-600 bg-white border size-10 rounded-full transition hover:bg-red-600 hover:text-white hover:border-red-600');
    deleteButton.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
    pengajarItem.appendChild(deleteButton);
}