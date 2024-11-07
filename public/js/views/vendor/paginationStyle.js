const paginationActive = document.querySelector('.pagination-active');

const prevSibling = paginationActive.previousElementSibling;
if(prevSibling){
    prevSibling.classList.replace('hidden', 'flex');

    const prev2Sibling = prevSibling.previousElementSibling;
    if(prev2Sibling){
        prev2Sibling.classList.replace('hidden', 'flex');
    }
}

const nextSibling = paginationActive.nextElementSibling;
if(nextSibling){
    nextSibling.classList.replace('hidden', 'flex');

    const next2Sibling = nextSibling.nextElementSibling;
    if(next2Sibling){
        next2Sibling.classList.replace('hidden', 'flex');
    }
}

const paginationFirst = document.querySelector('.pagination-first');
paginationFirst.classList.replace('hidden', 'flex');

const paginationLast = document.querySelector('.pagination-last');
paginationLast.classList.replace('hidden', 'flex');

if(Number(paginationFirst.textContent) + 3 < Number(paginationActive.children[0].textContent)){
    paginationFirst.insertAdjacentElement('afterend', tripleDot());
}

if(Number(paginationLast.textContent) - 3 > Number(paginationActive.children[0].textContent)){
    paginationLast.insertAdjacentElement('beforebegin', tripleDot());
}

function tripleDot(){
    const tripleDot = document.createElement('span');
    tripleDot.classList.add('flex', 'justify-center', 'items-center',  'text-center', 'p-2', 'size-10', 'rounded-sm', 'font-medium', 'text-gray-600', 'bg-white', 'cursor-default');
    tripleDot.textContent = '...';
    return tripleDot;
}