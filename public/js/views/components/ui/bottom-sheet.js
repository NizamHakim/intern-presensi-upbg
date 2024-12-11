function openBottomSheet(bottomSheet){
    const bottomSheetContent = bottomSheet.querySelector('.bottom-sheet-content');
    const body = document.querySelector('body');
    const form = bottomSheetContent.querySelector('.bottom-sheet-form');
    console.log(form);

    bottomSheet.classList.replace('hidden', 'flex');
    setTimeout(() => {
        bottomSheet.classList.replace('opacity-0', 'opacity-100');
        bottomSheetContent.classList.replace('translate-y-full', 'translate-y-0');
        body.classList.remove('overflow-y-scroll');
        body.classList.add('overflow-y-hidden', 'pr-[10px]');
    }, 100);

    function handleClickOutside(e){
        e.stopPropagation();
        const dimensions = bottomSheetContent.getBoundingClientRect();
        if(e.clientY < dimensions.top){
            closeBottomSheet(bottomSheet, closeCallback);
        }
    }
    document.addEventListener('click', handleClickOutside);

    function closeCallback(){
        document.removeEventListener('click', handleClickOutside);
    }
}

function closeBottomSheet(bottomSheet, callback){
    const bottomSheetContent = bottomSheet.querySelector('.bottom-sheet-content');
    const body = document.querySelector('body');

    bottomSheetContent.classList.replace('translate-y-0', 'translate-y-full');
    bottomSheet.classList.replace('opacity-100', 'opacity-0');

    bottomSheet.addEventListener('transitionend', handleTransitionEnd);

    function handleTransitionEnd(e){
        if(e.propertyName === 'opacity'){
            bottomSheet.classList.replace('flex', 'hidden');
            body.classList.remove('overflow-y-hidden', 'pr-[10px]');
            body.classList.add('overflow-y-scroll');
            bottomSheet.removeEventListener('transitionend', handleTransitionEnd);
        }
    }

    callback();
}