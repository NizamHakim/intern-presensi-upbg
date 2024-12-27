const filterKelasSection = document.getElementById('filter-kelas');
const openFilter = filterKelasSection.querySelector('.open-filter');

openFilter.addEventListener('click', handleFilterOpen);
function handleFilterOpen(){
    const submitOutFilter = filterKelasSection.querySelector('.submit-out-filter');
    const filterContainer = filterKelasSection.querySelector('.filter-container');
    const closeFilter = filterKelasSection.querySelector('.close-filter');

    submitOutFilter.classList.add('hidden');
    openFilter.classList.add('open');
    filterContainer.classList.add('open');
    function addOverflow(){
        filterContainer.classList.add('sm:overflow-visible');
        filterContainer.removeEventListener('transitionend', addOverflow);
    }
    filterContainer.addEventListener('transitionend', addOverflow)

    openFilter.removeEventListener('click', handleFilterOpen);
    openFilter.addEventListener('click', handleFilterClose);
    closeFilter.addEventListener('click', handleFilterClose);
}

function handleFilterClose(){
    const submitOutFilter = filterKelasSection.querySelector('.submit-out-filter');
    const filterContainer = filterKelasSection.querySelector('.filter-container');
    const closeFilter = filterKelasSection.querySelector('.close-filter');

    filterContainer.classList.remove('sm:overflow-visible');
    filterContainer.classList.remove('open');
    openFilter.classList.remove('open');
    submitOutFilter.classList.remove('hidden');

    openFilter.removeEventListener('click', handleFilterClose);
    closeFilter.removeEventListener('click', handleFilterClose);
    openFilter.addEventListener('click', handleFilterOpen);
}

const kodeKelasInputs = filterKelasSection.querySelectorAll('[name="kode"]');
kodeKelasInputs.forEach(input => {
    input.addEventListener('input', function(){
        kodeKelasInputs.forEach(other => {
            if(other !== input){
                other.value = input.value;
            }
        })
    });
});

const resetFilter = filterKelasSection.querySelector('.reset-filter');
resetFilter.addEventListener('click', function(){
    const filterFields = filterKelasSection.querySelectorAll('.filter-field');
    filterFields.forEach(field => {
        if(field.classList.contains('input-dropdown')){
            changeDropdownValue(field, '');
        }else if(field.classList.contains('input-date')){
            changeDateValue(field, '');
        }else if(field.type == 'number'){
            field.value = '';
        }
    });
});

const filterForm = document.querySelector('.filter-form');
filterForm.addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    const url = new URL(e.target.action);
    for(const key in data){
        if(data[key] !== ''){
            url.searchParams.set(key, data[key]);
        }
    }
    window.location.href = url.toString();
});