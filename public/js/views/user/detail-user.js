const checkboxInputs = document.querySelectorAll('[type="checkbox"]');
checkboxInputs.forEach(checkbox => {
    checkbox.addEventListener('change', async (e) => {
        const checked = e.target.checked;
        const roleId = e.target.value;
        const userId = document.querySelector('[data-user-id]').getAttribute('data-user-id');
        try {
            const response = await fetchRoleUpdate(userId, roleId, checked);
            if(response.ok){
                const json = await response.json();
                console.log(json);
                createToast('success', json.message);
            }else{
                createToast('error', 'Terjadi kesalahan. Silahkan coba lagi.');
            }
        } catch (error) {
            createToast('error', 'Terjadi kesalahan. Silahkan coba lagi.');
        }
    })
})

function fetchRoleUpdate(userId, roleId, checked){
    return fetch(`/user/${userId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            'role': roleId,
            'checked': checked
        })
    })
}