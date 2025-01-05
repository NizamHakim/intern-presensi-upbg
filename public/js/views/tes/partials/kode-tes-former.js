const kodeTesSection = document.getElementById('kode-tes-section');

const kodeFormers = kodeTesSection.querySelectorAll('.kode-former');
kodeFormers.forEach(former => {
  if(former.querySelector('input[type="number"]')){
      former.addEventListener('input', updateKodeTes);
  }else{
      former.addEventListener('change', updateKodeTes);
  }
});

function updateKodeTes(){
    const kodeTes = document.querySelector('[name="kode-tes"]');

    const kodeTipe = extractDropdownText(kodeTesSection.querySelector('.tipe-dropdown'));
    const nomorTes = kodeTesSection.querySelector('[name="nomor-tes"]').value;
    const tanggal = new Date(kodeTesSection.querySelector('[name="tanggal"]').value)
    const bulanMulai = monthParse(tanggal.getMonth());
    const tahunMulai = tanggal.getFullYear();

    let array = [`${kodeTipe}`, `${nomorTes}`, `${bulanMulai}`, `${tahunMulai}`];
    array = array.filter(item => item !== '' && item !== null && item !== 'NaN' && item !== 'undefined' && item !== '.');
    kodeTes.value = array.join('/');
}

function extractDropdownText(dropdown){
    const text = dropdown.querySelector('.dropdown-text').textContent;
    return (text.match(/\(([^)]+)\)/)) ? text.match(/\(([^)]+)\)/)[1] : '';
}

function monthParse(num){
    const roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
    return roman[num];
}
