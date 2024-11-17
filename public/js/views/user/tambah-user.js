const form = document.getElementById('form-tambah');

form.addEventListener('submit', async function(e){
    e.preventDefault();
    form.querySelectorAll('.error').forEach(error => error.remove());
    playFetchingAnimation(form);

    const formData = new FormData(form);
    const url = form.getAttribute('action');
    
    const response = await fetchValidate(url, formData);
    stopFetchingAnimation(form);

    if(response.ok){
        const json = await response.json();
        window.location.replace(json.redirect);
    }else{
        if(response.status === 422){
            const errors = await response.json();
            console.log(errors);
            for(const key in errors){
                const input = form.querySelector(`[name="${key}"]`);
                const errorSpan = createErrorSpan(errors[key][0]);
                input.parentNode.appendChild(errorSpan);
            }
        }else{
            createToast('error', 'Terjadi kesalahan. Silahkan coba lagi.');
        }
    }
});

function fetchValidate(url, formData){
    return fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: formData,
    })
}

function playFetchingAnimation(form){
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.classList.add('hidden');

    const loading = document.createElement('button');
    loading.setAttribute('class', 'button-loading flex flex-row items-center justify-center mt-2 font-semibold px-3 py-2 border border-green-600 bg-white rounded-md cursor-progress');
    loading.setAttribute('disabled', 'true');
    loading.innerHTML = createLoadingAnimation('Validating...', 'green');
    submitButton.insertAdjacentElement('afterend', loading);
}

function stopFetchingAnimation(form){
    const loading = form.querySelector('.button-loading');
    loading.remove();
    
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.classList.remove('hidden');
}