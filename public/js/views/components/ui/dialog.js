function openDialog(dialog){
  dialog.classList.replace('hidden', 'block');
  setTimeout(() => {
    dialog.classList.add('open');
  }, 1);

  function handleClickOutside(e){
    if(!dialog.contains(e.target)){
      closeDialog(dialog, closeCallback);
    }
  }
  document.addEventListener('click', handleClickOutside);

  function closeCallback(){
    document.removeEventListener('click', handleClickOutside);
  }

  return closeCallback;
}

function closeDialog(dialog, callback){
  dialog.classList.remove('open');
  dialog.addEventListener('transitionend', transitionEnd);
  function transitionEnd(e){
    if(e.propertyName == 'opacity'){
      dialog.classList.replace('block', 'hidden');
      dialog.removeEventListener('transitionend', transitionEnd);
      callback();
    }
  }
}