const filterTesSection = document.getElementById('filter-tes');
const openFilter = filterTesSection.querySelector('.open-filter');

openFilter.addEventListener('click', handleFilterOpen);
function handleFilterOpen(){
    const submitOutFilter = filterTesSection.querySelector('.submit-out-filter');
    const filterContainer = filterTesSection.querySelector('.filter-container');
    const closeFilter = filterTesSection.querySelector('.close-filter');

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
    const submitOutFilter = filterTesSection.querySelector('.submit-out-filter');
    const filterContainer = filterTesSection.querySelector('.filter-container');
    const closeFilter = filterTesSection.querySelector('.close-filter');

    filterContainer.classList.remove('sm:overflow-visible');
    filterContainer.classList.remove('open');
    openFilter.classList.remove('open');
    submitOutFilter.classList.remove('hidden');

    openFilter.removeEventListener('click', handleFilterClose);
    closeFilter.removeEventListener('click', handleFilterClose);
    openFilter.addEventListener('click', handleFilterOpen);
}

const kodeTesInputs = filterTesSection.querySelectorAll('[name="kode"]');
kodeTesInputs.forEach(input => {
    input.addEventListener('input', function(){
        kodeTesInputs.forEach(other => {
            if(other !== input){
                other.value = input.value;
            }
        })
    });
});

const resetFilter = filterTesSection.querySelector('.reset-filter');
resetFilter.addEventListener('click', function(){
    const filterFields = filterTesSection.querySelectorAll('.filter-field');
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