const daftarPeserta = document.getElementById('daftar-peserta');

daftarPeserta.addEventListener('change', async (e) => {
  if(e.target.matches('.dropdown-ruangan')){
    const dropdown = e.target;
    const ruangan = dropdown.querySelector('[name="ruangan"]').value;
    const pesertaItem = e.target.closest('.peserta-item');
    const pesertaId = pesertaItem.dataset.pesertaId;
    const route = pesertaItem.dataset.route;

    const response = await fetchRequest(route, 'PATCH', { "ruangan-id": ruangan, "peserta-id": pesertaId });
    if(response.ok){
      const data = await response.json();
      updateKapasitasCount(data.updated);
    }
  }
});

function updateKapasitasCount(updated){
  const counterKapasitas = document.getElementById('counter-kapasitas-ruangan');
  for(const i in updated){
    const counter = counterKapasitas.querySelector(`[data-ruangan="${updated[i].ruangan}"]`);
    counter.textContent = updated[i].total;
    if(updated[i].total > updated[i].kapasitas){
      counter.classList.add('text-red-600');
    }else{
      counter.classList.remove('text-red-600');
    }
  }
}