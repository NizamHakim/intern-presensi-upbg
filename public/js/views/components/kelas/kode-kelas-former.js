const kodeKelasSection = document.getElementById('kode-kelas-section');

const kodeFormers = kodeKelasSection.querySelectorAll('.kode-former');
kodeFormers.forEach(former => {
    if(former.querySelector('.input-number')){
        former.addEventListener('input', updateKodeKelas);
    }else{
        former.addEventListener('change', updateKodeKelas);
    }
});

function updateKodeKelas(){
    const kodeKelas = document.querySelector('[name="kode-kelas"]');

    const kodeProgram = extractDropdownText(kodeKelasSection.querySelector('.program-dropdown'));
    const kodeTipe = extractDropdownText(kodeKelasSection.querySelector('.tipe-dropdown'));
    const nomorKelas = kodeKelasSection.querySelector('[name="nomor-kelas"]').value;
    const kodeLevel = extractDropdownText(kodeKelasSection.querySelector('.level-dropdown'));
    const banyakPertemuan = kodeKelasSection.querySelector('[name="banyak-pertemuan"]').value;
    const tanggalMulai = new Date(kodeKelasSection.querySelector('[name="tanggal-mulai"]').value)
    const bulanMulai = monthParse(tanggalMulai.getMonth());
    const tahunMulai = tanggalMulai.getFullYear();

    let array = [`${kodeProgram}`, `${kodeTipe}.${nomorKelas}`, `${kodeLevel}`, `${banyakPertemuan}`, `${bulanMulai}`, `${tahunMulai}`];
    array = array.filter(item => item !== '' && item !== null && item !== 'NaN' && item !== 'undefined' && item !== '.');
    kodeKelas.value = array.join('/');
}

function extractDropdownText(dropdown){
    const text = dropdown.querySelector('.dropdown-text').textContent;
    return (text.match(/\(([^)]+)\)/)) ? text.match(/\(([^)]+)\)/)[1] : '';
}

function monthParse(num){
    const roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
    return roman[num];
}
