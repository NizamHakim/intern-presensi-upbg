// const dropdowns = document.querySelectorAll('.input-dropdown');
// dropdowns.forEach(dropdown => {
//     const dropdownButton = dropdown.querySelector('.dropdown-button');

//     function handleDropdownOpen(e){
//         openDropdown(dropdown, handleDropdownOpen);
//     }
//     dropdownButton.addEventListener('click', handleDropdownOpen);
// });

document.addEventListener('click', function(e){
    if(e.target.closest('.dropdown-button')){
        e.stopPropagation();
        const dropdown = e.target.closest('.input-dropdown');
        openDropdown(dropdown);
    }
});

// function openDropdown(dropdown, handleDropdownOpen){
//     const dropdownButton = dropdown.querySelector('.dropdown-button');
//     dropdownButton.classList.add('active');
//     dropdownButton.classList.replace('outline-transparent', 'outline-upbg-light');
//     dropdownButton.querySelector('i').classList.add('rotate-180');

//     function handleDropdownClose(e){
//         e.stopPropagation();
//         closeDropdown(dropdown, closeCallback);
//     }
//     dropdownButton.removeEventListener('click', handleDropdownOpen);
//     dropdownButton.addEventListener('click', handleDropdownClose);


//     const dropdownOptionsContainer = dropdown.querySelector('.dropdown-options-container');
//     dropdownOptionsContainer.classList.remove('hidden');
//     setTimeout(() => {
//         dropdownOptionsContainer.classList.replace('opacity-0', 'opacity-100');
//     }, 1);
    

//     const dropdownOptions = dropdownOptionsContainer.querySelectorAll('.dropdown-option');
//     const dropdownHiddenInput = dropdown.querySelector('input[type="hidden"]');

//     function handleOptionClick(e){
//         e.stopPropagation();
//         dropdownOptions.forEach(option => {
//             option.classList.replace('border-upbg', 'border-transparent')
//         });
//         this.classList.replace('border-transparent', 'border-upbg');
//         dropdownButton.querySelector('span').textContent = this.textContent;
//         dropdownHiddenInput.value = this.dataset.value;
//         if(dropdownHiddenInput.value){
//             dropdownButton.querySelector('span').classList.replace('text-gray-400', 'text-gray-600');
//         }else{
//             dropdownButton.querySelector('span').classList.replace('text-gray-600', 'text-gray-400');
//         }
//         const event = new Event('change');
//         dropdownHiddenInput.dispatchEvent(event);
//         closeDropdown(dropdown, closeCallback);
//     }
//     dropdownOptions.forEach(option => { option.addEventListener('click', handleOptionClick); });


//     const dropdownContent = dropdown.querySelector('.dropdown-content');
//     function handleClickOutside(e){
//         if(!dropdownContent.contains(e.target)){
//             closeDropdown(dropdown, closeCallback);
//         }
//     }
//     document.addEventListener('click', handleClickOutside);


//     const dropdownSearch = dropdown.querySelector('.dropdown-search');
//     function handleSearch(e){
//         const searchValue = this.value.toLowerCase();
//         dropdownOptions.forEach(option => {
//             if(option.textContent.toLowerCase().includes(searchValue)){
//                 option.classList.remove('hidden');
//             } else {
//                 option.classList.add('hidden');
//             }
//         });
//     }
//     dropdownSearch.addEventListener('input', handleSearch);

//     function closeCallback(){
//         dropdownButton.removeEventListener('click', handleDropdownClose);
//         dropdownButton.addEventListener('click', handleDropdownOpen);
//         dropdownOptions.forEach(option => { option.removeEventListener('click', handleOptionClick); });
//         document.removeEventListener('click', handleClickOutside);
//         dropdownSearch.removeEventListener('input', handleSearch);
//         dropdownSearch.value = '';
//         dropdownOptions.forEach(option => {
//             option.classList.remove('hidden');
//         });
//     }
// }

function openDropdown(dropdown){
    const dropdownButton = dropdown.querySelector('.dropdown-button');
    dropdownButton.classList.add('active');
    dropdownButton.classList.replace('outline-transparent', 'outline-upbg-light');
    dropdownButton.querySelector('i').classList.add('rotate-180');

    function handleDropdownClose(e){
        e.stopPropagation();
        closeDropdown(dropdown, closeCallback);
    }
    dropdownButton.addEventListener('click', handleDropdownClose);


    const dropdownOptionsContainer = dropdown.querySelector('.dropdown-options-container');
    dropdownOptionsContainer.classList.remove('hidden');
    setTimeout(() => {
        dropdownOptionsContainer.classList.replace('opacity-0', 'opacity-100');
    }, 1);
    

    const dropdownOptions = dropdownOptionsContainer.querySelectorAll('.dropdown-option');
    const dropdownHiddenInput = dropdown.querySelector('input[type="hidden"]');

    function handleOptionClick(e){
        e.stopPropagation();
        dropdownOptions.forEach(option => {
            option.classList.replace('border-upbg', 'border-transparent')
        });
        this.classList.replace('border-transparent', 'border-upbg');
        dropdownButton.querySelector('span').textContent = this.textContent;
        dropdownHiddenInput.value = this.dataset.value;
        if(dropdownHiddenInput.value){
            dropdownButton.querySelector('span').classList.replace('text-gray-400', 'text-gray-600');
        }else{
            dropdownButton.querySelector('span').classList.replace('text-gray-600', 'text-gray-400');
        }
        const event = new Event('change');
        dropdownHiddenInput.dispatchEvent(event);
        closeDropdown(dropdown, closeCallback);
    }
    dropdownOptions.forEach(option => { option.addEventListener('click', handleOptionClick); });


    const dropdownContent = dropdown.querySelector('.dropdown-content');
    function handleClickOutside(e){
        if(!dropdownContent.contains(e.target)){
            closeDropdown(dropdown, closeCallback);
        }
    }
    document.addEventListener('click', handleClickOutside);


    const dropdownSearch = dropdown.querySelector('.dropdown-search');
    function handleSearch(e){
        const searchValue = this.value.toLowerCase();
        dropdownOptions.forEach(option => {
            if(option.textContent.toLowerCase().includes(searchValue)){
                option.classList.remove('hidden');
            } else {
                option.classList.add('hidden');
            }
        });
    }
    dropdownSearch.addEventListener('input', handleSearch);

    function closeCallback(){
        dropdownButton.removeEventListener('click', handleDropdownClose);
        dropdownOptions.forEach(option => { option.removeEventListener('click', handleOptionClick); });
        document.removeEventListener('click', handleClickOutside);
        dropdownSearch.removeEventListener('input', handleSearch);
        dropdownSearch.value = '';
        dropdownOptions.forEach(option => {
            option.classList.remove('hidden');
        });
    }
}

function closeDropdown(dropdown, callback){
    const dropdownButton = dropdown.querySelector('.dropdown-button');
    dropdownButton.classList.remove('active');
    dropdownButton.classList.replace('outline-upbg-light', 'outline-transparent');
    dropdownButton.querySelector('i').classList.remove('rotate-180');

    const dropdownOptionsContainer = dropdown.querySelector('.dropdown-options-container');

    dropdownOptionsContainer.classList.replace('opacity-100', 'opacity-0');
    dropdownOptionsContainer.addEventListener('transitionend', () => {
        dropdownOptionsContainer.classList.add('hidden');
        callback();
    }, {once: true});
}

function resetDropdownValue(dropdown){
    const dropdownButton = dropdown.querySelector('.dropdown-button');
    const span = dropdownButton.querySelector('span');
    const hiddenInput = dropdown.querySelector('input[type="hidden"]');
    span.textContent = dropdown.dataset.defaultText;
    hiddenInput.value = dropdown.dataset.defaultValue;
    if(hiddenInput.value){
        span.classList.replace('text-gray-400', 'text-gray-600');
    }else{
        span.classList.replace('text-gray-600', 'text-gray-400');
    }

    const dropdownOptions = dropdown.querySelectorAll('.dropdown-option');
    dropdownOptions.forEach(option => {
        if(option.textContent === dropdown.dataset.defaultText){
            return
        }
        option.classList.replace('border-upbg', 'border-transparent');
    });
}