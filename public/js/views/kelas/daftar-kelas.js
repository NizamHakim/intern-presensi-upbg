const filterKelasSection = document.getElementById('filter-kelas');

const openFilterMobile = filterKelasSection.querySelector('.open-filter-mobile');
openFilterMobile.addEventListener('click', function(){
    const filterContainer = filterKelasSection.querySelector('.filter-container');
    filterContainer.classList.add('open');

    const closeFilterMobile = filterContainer.querySelector('.close-filter');
    function handleFilterClose(){
        filterContainer.classList.remove('open');
        closeFilterMobile.removeEventListener('click', handleFilterClose);
    }
    closeFilterMobile.addEventListener('click', handleFilterClose);
});

const openFilter = filterKelasSection.querySelector('.open-filter');
openFilter.addEventListener('click', function(){
    const filterCloseSubmit = filterKelasSection.querySelector('.filter-close-submit');
    const filterContainer = filterKelasSection.querySelector('.filter-container');

    if(openFilter.classList.contains('open')){
        filterContainer.classList.remove('sm:overflow-visible');
        filterContainer.classList.remove('open');
        openFilter.classList.remove('open');
        filterCloseSubmit.classList.remove('sm:hidden');
    }else{
        filterCloseSubmit.classList.add('sm:hidden');
        openFilter.classList.add('open');
        filterContainer.classList.add('open');
        function addOverflow(){
            filterContainer.classList.add('sm:overflow-visible');
            filterContainer.removeEventListener('transitionend', addOverflow);
        }
        filterContainer.addEventListener('transitionend', addOverflow)
    }
});

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
        }else if(field.classList.contains('input-number')){
            field.value = '';
        }
    });
});

const filterForm = document.querySelector('.filter-form');
filterForm.addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(filterForm);
    const data = Object.fromEntries(formData.entries());
    const url = new URL(e.target.action);
    for(const key in data){
        if(data[key] !== ''){
            url.searchParams.set(key, data[key]);
        }
    }
    window.location.href = url.toString();
});