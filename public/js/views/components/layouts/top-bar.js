const sidenavOpen = document.querySelector('.sidenav-open');
if (sessionStorage.getItem('sidenavState') == 'open') {
    sidenavOpen.parentElement.classList.add('hidden');
}