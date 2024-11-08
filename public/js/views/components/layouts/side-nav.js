const sidenav = document.querySelector('.sidenav');

if (sessionStorage.getItem('sidenavState') == 'open') {
    sidenav.classList.add('w-64');
}else if (sessionStorage.getItem('sidenavState') == 'closed') {
    sidenav.classList.add('w-0');
}else{
    sidenav.classList.add('w-64');
    sessionStorage.setItem('sidenavState', 'open');
}

document.addEventListener('DOMContentLoaded', () => {
    const sidenavOpen = document.querySelector('.sidenav-open');
    sidenavOpen.addEventListener('click', () => {
        if (sidenav.classList.contains('w-0')) {
            openSidenav(sidenav, sidenavOpen);
        }
    });

    const sidenavClose = document.querySelector('.sidenav-close');
    sidenavClose.addEventListener('click', () => {
        if (sidenav.classList.contains('w-64')) {
            closeSidenav(sidenav, sidenavOpen);
        }
    });
});

function openSidenav(sidenav, sidenavOpen) {
    sidenav.classList.remove('w-0');
    sidenav.classList.add('w-64');
    sidenavOpen.parentElement.classList.add('hidden');
    sessionStorage.setItem('sidenavState', 'open');
}

function closeSidenav(sidenav, sidenavOpen) {
    sidenav.classList.remove('w-64');
    sidenav.classList.add('w-0');
    sidenavOpen.parentElement.classList.remove('hidden');
    sessionStorage.setItem('sidenavState', 'closed');
}
