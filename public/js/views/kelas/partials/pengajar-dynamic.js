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
    pengajarItemClone.classList.remove('mr-11');

    const pengajarDropdown = pengajarItemClone.querySelector('.pengajar-dropdown');
    changeDropdownValue(pengajarDropdown, '');
    addDeletePengajarButton(pengajarItemClone);
    pengajarContainer.appendChild(pengajarItemClone);
});

function addDeletePengajarButton(pengajarItem){
    const deleteButton = document.createElement('button');
    deleteButton.setAttribute('type', 'button');
    deleteButton.setAttribute('class', 'delete-pengajar btn-rounded btn-white ml-2 text-red-600');
    deleteButton.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
    pengajarItem.appendChild(deleteButton);
}