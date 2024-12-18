function createLoadingAnimation(message, color = 'blue') {
    const colors = {
        'green': {
            'fill': 'fill-green-600',
            'text': 'text-green-600',
        },
        'blue': {
            'fill': 'fill-upbg',
            'text': 'text-upbg',
        },
        'red': {
            'fill': 'fill-red-600',
            'text': 'text-red-600',
        }
    }

    return `
        <svg aria-hidden="true" class="size-4 inline text-gray-200 animate-spin dark:text-gray-600 ${colors[color]['fill']}" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
        <span class="${colors[color]['text']} font-medium ml-2">${message || 'Loading...'}</span>
    `;
}

function createErrorText(message) {
    const errorSpan = document.createElement('p');
    errorSpan.setAttribute('class', 'error');
    errorSpan.textContent = message;
    return errorSpan;
}

function clearErrors(element) {
    element.querySelectorAll('.error').forEach(error => error.remove());
}

function fetchRequest(route, method, data = {}){
    return fetch(route, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    });
}

async function handleError(response, container){
    if(response.status === 422){
        const errors = await response.json();
        for(const key in errors){
            if(key.includes('.')){
                const arrKey = key.split('.');
                const inputs = container.querySelectorAll(`[name="${arrKey[0]}"]`);
                const inputGroup = inputs[arrKey[1]].closest('.input-group');
                const error = createErrorText(errors[key][0]);
                inputGroup.appendChild(error);
                continue;
            }
            const input = container.querySelector(`[name="${key}"]`);
            const inputGroup = input.closest('.input-group');
            const error = createErrorText(errors[key][0]);
            inputGroup.appendChild(error);
        }
    }else{
        const error = await response.json();
        createToast('error', (error) ? error.error : 'Terjadi kesalahan');
    }
}

function playFetchingAnimation(element, style, message){
    const colors = {
        'green': 'border-green-600',
        'blue': 'border-upbg',
        'red': 'border-red-600',
    };

    element.classList.add('hidden');

    const loading = document.createElement('button');
    loading.setAttribute('class', 'button-loading button-style ' + colors[style]);
    loading.setAttribute('disabled', 'true');
    loading.innerHTML = createLoadingAnimation(message, style);
    element.insertAdjacentElement('afterend', loading);
}

function stopFetchingAnimation(element){
    const loading = element.nextElementSibling;
    loading.remove();

    element.classList.remove('hidden');
}

function parseFile(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.addEventListener('load', function (e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const sheet = workbook.Sheets[workbook.SheetNames[0]];
                const json = XLSX.utils.sheet_to_json(sheet);
                verifyFileHeader(Object.keys(json[0]));
                resolve(json);
            } catch (error) {
                reject(error);
            }
        });
        reader.addEventListener('error', (error) => reject(error));
        reader.readAsArrayBuffer(file);
    });
}

function verifyFileHeader(header){
    if(!header.includes('NIK/NRP')){
        throw new Error('File harus memiliki header "NIK/NRP"');
    }else if(!header.includes('Nama')){
        throw new Error('File harus memiliki header "Nama"');
    }else if(!header.includes('Dept./Occupation')){
        throw new Error('File harus memiliki header "Dept./Occupation"');
    }
}