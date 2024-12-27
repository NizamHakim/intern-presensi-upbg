document.addEventListener("click", function (e) {
    if (e.target.closest(".dropdown-button")) {
        e.stopPropagation();
        const dropdown = e.target.closest(".input-dropdown");
        openDropdown(dropdown);
    }
});

function openDropdown(dropdown) {
    const dropdownButton = dropdown.querySelector(".dropdown-button");
    function handleDropdownClose(e) {
        e.stopPropagation();
        closeDropdown(dropdown, closeCallback);
    }
    dropdownButton.addEventListener("click", handleDropdownClose);

    const dropdownOptionsContainer = dropdown.querySelector(".dropdown-options-container");
    dropdownOptionsContainer.classList.remove("hidden");
    setTimeout(() => {
        dropdown.classList.add("open");
    }, 1);

    function handleOptionClick(e) {
        if (e.target.closest(".dropdown-option")) {
            e.stopPropagation();
            const option = e.target.closest(".dropdown-option");
            changeDropdownValue(dropdown, option.dataset.value);
            closeDropdown(dropdown, closeCallback);
        }
    }
    dropdownOptionsContainer.addEventListener("click", handleOptionClick);

    function handleClickOutside(e) {
        if (!dropdown.contains(e.target)) {
            closeDropdown(dropdown, closeCallback);
        }
    }
    document.addEventListener("click", handleClickOutside);

    const dropdownSearch = dropdown.querySelector(".dropdown-search");
    const dropdownOptions = dropdown.querySelectorAll(".dropdown-option");
    function handleSearch(e) {
        const searchValue = this.value.toLowerCase();
        dropdownOptions.forEach((option) => {
            if (option.textContent.toLowerCase().includes(searchValue)) {
                option.classList.remove("hidden");
            } else {
                option.classList.add("hidden");
            }
        });
    }
    dropdownSearch.addEventListener("input", handleSearch);

    function closeCallback() {
        dropdownButton.removeEventListener("click", handleDropdownClose);
        dropdownOptionsContainer.removeEventListener("click", handleOptionClick);
        document.removeEventListener("click", handleClickOutside);
        dropdownSearch.removeEventListener("input", handleSearch);
        dropdownSearch.value = "";
        dropdownOptions.forEach((option) => {
            option.classList.remove("hidden");
        });
    }
}

function closeDropdown(dropdown, callback) {
    dropdown.classList.remove("open");
    const dropdownOptionsContainer = dropdown.querySelector(".dropdown-options-container");
    dropdownOptionsContainer.addEventListener("transitionend", handleTransitionEnd);

    function handleTransitionEnd(e) {
        if (e.propertyName === "opacity") {
            dropdownOptionsContainer.classList.add("hidden");
            dropdownOptionsContainer.removeEventListener("transitionend", handleTransitionEnd);
            callback();
        }
    }
}

function resetDropdownValue(dropdown) {
    changeDropdownValue(dropdown, dropdown.dataset.defaultValue);
}

function changeDropdownValue(dropdown, value) {
    const dropdownButton = dropdown.querySelector(".dropdown-button");
    const span = dropdownButton.querySelector(".dropdown-text");
    const hiddenInput = dropdown.querySelector('input[type="hidden"]');
    const dropdownOptions = dropdown.querySelectorAll(".dropdown-option");

    dropdownOptions.forEach((option) => {
        if (option.dataset.value == value) {
            span.textContent = option.textContent;
            hiddenInput.value = option.dataset.value;
            option.classList.add("selected");
            if (value == "") {
                dropdown.classList.add("is-null");
            } else {
                dropdown.classList.remove("is-null");
            }
        } else {
            option.classList.remove("selected");
        }
    });

    const event = new Event("change", { bubbles: true });
    dropdown.dispatchEvent(event);
}
