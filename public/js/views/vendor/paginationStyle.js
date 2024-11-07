const paginationActive = document.querySelector('.pagination-active');

const prevSibling = paginationActive.previousElementSibling;
if(prevSibling){
    prevSibling.classList.replace('hidden', 'inline-flex');

    const prev2Sibling = prevSibling.previousElementSibling;
    if(prev2Sibling){
        prev2Sibling.classList.replace('hidden', 'inline-flex');
    }
}

const nextSibling = paginationActive.nextElementSibling;
if(nextSibling){
    nextSibling.classList.replace('hidden', 'inline-flex');

    const next2Sibling = nextSibling.nextElementSibling;
    if(next2Sibling){
        next2Sibling.classList.replace('hidden', 'inline-flex');
    }
}

const paginationFirst = document.querySelector('.pagination-first');
paginationFirst.classList.replace('hidden', 'inline-flex');

const paginationLast = document.querySelector('.pagination-last');
paginationLast.classList.replace('hidden', 'inline-flex');

if(Number(paginationFirst.textContent) + 3 < Number(paginationActive.children[0].textContent)){
    paginationFirst.insertAdjacentElement('afterend', tripleDot());
}

if(Number(paginationLast.textContent) - 3 > Number(paginationActive.children[0].textContent)){
    paginationLast.insertAdjacentElement('beforebegin', tripleDot());
}

function tripleDot(){
    const tripleDot = document.createElement('span');
    tripleDot.classList.add('inline-flex', 'items-center', 'pt-4', 'pb-2', 'px-2', 'font-medium', 'text-gray-600', 'bg-white', 'border-t-2', 'border-transparent', 'cursor-default');
    tripleDot.textContent = '...';
    return tripleDot;
}