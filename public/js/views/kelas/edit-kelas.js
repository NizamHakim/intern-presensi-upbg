const editForm = document.querySelector('.edit-form');
editForm.addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(editForm);
    const data = Object.fromEntries(formData);
    console.log(data);
});

const kodeKelas = editForm.querySelector('.kode-kelas');
const kodeFormers = editForm.querySelectorAll('.kode-former');
kodeFormers.forEach(former => {
    const input = former.querySelector('input');
    if(input.type == 'number'){
        input.addEventListener('input', function(){
            console.log(input.value);
        });
    }else{
        input.addEventListener('change', function(){
            console.log(input.value);
        });
    }
});

const pengajarContainer = editForm.querySelector('.pengajar-container');
pengajarContainer.addEventListener('click', function(e){
    if(e.target.closest('.delete-pengajar')){
        e.stopPropagation();
        const dropdownPengajar = e.target.closest('.dropdown-pengajar');
        dropdownPengajar.remove();
    }
});

const tambahPengajar = editForm.querySelector('.tambah-pengajar');
tambahPengajar.addEventListener('click', function(){
    const dropdownPengajar = document.querySelector('.dropdown-pengajar');
    const dropdownPengajarClone = dropdownPengajar.cloneNode(true);
    addDeletePengajarButton(dropdownPengajarClone);
    pengajarContainer.appendChild(dropdownPengajarClone);
});

function addDeletePengajarButton(dropdownPengajar){
    const deleteButton = document.createElement('button');
    deleteButton.setAttribute('type', 'button');
    deleteButton.setAttribute('class', 'delete-pengajar font-medium text-red-600 bg-white border size-10 rounded-full transition hover:bg-red-600 hover:text-white hover:border-red-600');
    deleteButton.innerHTML = '<i class="fa-regular fa-trash-can"></i>';
    dropdownPengajar.appendChild(deleteButton);
}