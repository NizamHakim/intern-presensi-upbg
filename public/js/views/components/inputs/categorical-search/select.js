document.addEventListener("click", function (e) {
  if (e.target.closest(".categorical-search-button")) {
      e.stopPropagation();
      const categoricalSearch = e.target.closest(".categorical-search");
      openCategoricalSearch(categoricalSearch);
  }
});

document.addEventListener('focusin', function(e){
  if(e.target.closest(".categorical-search-input")){
      const categoricalSearch = e.target.closest(".categorical-search");
      categoricalSearch.classList.add("focused");
  }
})

document.addEventListener('focusout', function(e){
  if(e.target.closest(".categorical-search-input")){
      const categoricalSearch = e.target.closest(".categorical-search");
      categoricalSearch.classList.remove("focused");
  }
})

function openCategoricalSearch(categoricalSearch){
  const categoricalSearchButton = categoricalSearch.querySelector(".categorical-search-button");
  function handleCategoricalSearchClose(e) {
      e.stopPropagation();
      closeCategoricalSearch(categoricalSearch, closeCallback);
  }
  categoricalSearchButton.addEventListener("click", handleCategoricalSearchClose);

  const categoricalSearchOptionsContainer = categoricalSearch.querySelector(".categorical-search-options-container");
  categoricalSearchOptionsContainer.classList.remove("hidden");
  setTimeout(() => {
      categoricalSearch.classList.add("open");
  }, 1);

  function handleOptionClick(e) {
    if (e.target.closest(".categorical-search-option")) {
        e.stopPropagation();
        const option = e.target.closest(".categorical-search-option");
        changeCategoricalSearch(categoricalSearch, option);
        closeCategoricalSearch(categoricalSearch, closeCallback);
    }
  }
  categoricalSearchOptionsContainer.addEventListener("click", handleOptionClick);

  function handleClickOutside(e) {
      if (!categoricalSearchButton.contains(e.target)) {
          closeCategoricalSearch(categoricalSearch, closeCallback);
      }
  }
  document.addEventListener("click", handleClickOutside);

  function closeCallback(){
      categoricalSearchButton.removeEventListener("click", handleCategoricalSearchClose);
      document.removeEventListener("click", handleClickOutside);
  }
}

function closeCategoricalSearch(categoricalSearch, callback){
  categoricalSearch.classList.remove("open");
  const categoricalSearchOptionsContainer = categoricalSearch.querySelector(".categorical-search-options-container");
  categoricalSearchOptionsContainer.addEventListener("transitionend", handleTransitionEnd);

  function handleTransitionEnd(e) {
      if (e.propertyName === "opacity") {
          categoricalSearchOptionsContainer.classList.add("hidden");
          categoricalSearchOptionsContainer.removeEventListener("transitionend", handleTransitionEnd);
          callback();
      }
  }
}

function changeCategoricalSearch(categoricalSearch, option){
  const categoricalSearchText = categoricalSearch.querySelector(".categorical-search-text");
  const categoricalSearchInput = categoricalSearch.querySelector(".categorical-search-input");
  const categoricalSearchOptions = categoricalSearch.querySelectorAll(".categorical-search-option");

  categoricalSearchText.textContent = option.textContent;
  categoricalSearchInput.name = option.dataset.name;
  categoricalSearchInput.placeholder = option.dataset.placeholder;

  categoricalSearchOptions.forEach((opt) => {
      if (opt === option) {
          opt.classList.add("selected");
      } else {
          opt.classList.remove("selected");
      }
  });

  const event = new Event("change", { bubbles: true });
  categoricalSearch.dispatchEvent(event);
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
