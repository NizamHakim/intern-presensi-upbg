const openSidenav = document.querySelector('.open-sidenav');
openSidenav.addEventListener('click', (e) => {
    e.stopPropagation();
    openSidenavMobile();
});

function openSidenavMobile() {
    const sidenavBackdrop = document.querySelector('.sidenav-backdrop');
    const sidenav = document.querySelector('.sidenav');

    sidenavBackdrop.classList.replace('hidden', 'block');
    setTimeout(() => {
        sidenavBackdrop.classList.replace('opacity-0', 'opacity-100');
        sidenav.classList.replace('-translate-x-full', 'translate-x-0');
    }, 10);

    function handleClickBackdrop(e){
        e.stopPropagation();
        if(e.target.classList.contains('sidenav-backdrop')){
            closeSidenavMobile(closeCallback);
        }
    }
    sidenavBackdrop.addEventListener('click', handleClickBackdrop);
    
    function closeCallback(){
        sidenavBackdrop.removeEventListener('click', handleClickBackdrop);
    }
}

function closeSidenavMobile(callback) {
    const sidenavBackdrop = document.querySelector('.sidenav-backdrop');
    const sidenav = document.querySelector('.sidenav');

    sidenav.classList.replace('translate-x-0', '-translate-x-full');
    sidenavBackdrop.classList.replace('opacity-100', 'opacity-0');

    function handleTransitionEnd(e){
        if(e.propertyName === 'opacity'){
            sidenavBackdrop.classList.replace('block', 'hidden');
            sidenavBackdrop.removeEventListener('transitionend', handleTransitionEnd);
            callback();
        }
    }
    sidenavBackdrop.addEventListener('transitionend', handleTransitionEnd);
}