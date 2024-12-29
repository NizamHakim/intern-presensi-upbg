const toggleProfileMenu = document.querySelector('.toggle-profile-menu');
const profileMenu = document.querySelector('.profile-menu');

document.addEventListener('click', (e) => {
  if(e.target.closest('.toggle-profile-menu')){
    openProfileMenu();
  }
});

function openProfileMenu(){
  function handleToggleClose(e){
    e.stopPropagation();
    closeProfileMenu(closeCallback);
  }
  toggleProfileMenu.addEventListener('click', handleToggleClose);

  function handleClickOutside(e){
    if(!profileMenu.contains(e.target)){
      closeProfileMenu(closeCallback);
    }
  }
  document.addEventListener('click', handleClickOutside);

  profileMenu.classList.replace('hidden', 'flex');
  setTimeout(() => {
    profileMenu.classList.add('open');
  }, 1);

  function closeCallback(){
    toggleProfileMenu.removeEventListener('click', handleToggleClose);
    document.removeEventListener('click', handleClickOutside);
  }
}

function closeProfileMenu(closeCallback){
  profileMenu.classList.remove('open');
  profileMenu.addEventListener('transitionend', transitionEnd);

  function transitionEnd(e){
    if(e.propertyName === 'transform'){
      profileMenu.classList.replace('flex', 'hidden');
      profileMenu.removeEventListener('transitionend', transitionEnd);
      closeCallback();
    }
  }
}


const switchRoleToggle = document.querySelector('.switch-role-toggle');
const switchRoleDropdown = document.querySelector('.switch-role-dropdown');

switchRoleToggle.addEventListener('click', () => {
  if(switchRoleDropdown.classList.contains('open')){
    closeRoleDropdown();
  }else{
    openRoleDropdown();
  }
});

function openRoleDropdown(){
  switchRoleDropdown.classList.replace('hidden', 'flex');
    setTimeout(() => {
      switchRoleToggle.classList.add('open');
      switchRoleDropdown.classList.add('open');
    }, 1);
}

function closeRoleDropdown(){
  switchRoleToggle.classList.remove('open');
  switchRoleDropdown.classList.remove('open');
  switchRoleDropdown.addEventListener('transitionend', transitionEnd);

  function transitionEnd(){
    switchRoleDropdown.classList.replace('flex', 'hidden');
    switchRoleDropdown.removeEventListener('transitionend', transitionEnd);
  }
}