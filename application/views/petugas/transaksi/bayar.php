<link rel="stylesheet" href="<?= base_url('assets/css/pages/bayar_parkir.css') ?>">

<div class="bayar-card" data-waktu-masuk="<?= $transaksi->waktu_masuk ?>" data-tarif-per-jam="<?= $tarif_per_jam ?? 0 ?>">
    <div class="bayar-header">
        <div class="nomor"><?= $transaksi->nomor_karcis ?? $transaksi->id_parkir ?? '-' ?></div>
        <div class="jenis"><?= $transaksi->jenis_kendaraan ?? '-' ?> &bull; <?= $transaksi->nama_area ?? '-' ?></div>
    </div>
    <div class="bayar-info">
        <div class="bayar-info-col">
            <span>MASUK</span>
            <span style="font-weight:600; font-size:1.1em;"><?= date('H:i', strtotime($transaksi->waktu_masuk)) ?></span>
            <span style="font-size:0.97em; color:#888;">Durasi</span>
            <span id="durasiJam" style="font-weight:600; color:#1976d2; font-size:1.05em;"><?= $durasi_jam ?? '-' ?> jam</span>
        </div>
        <div class="bayar-info-col" style="text-align:right;">
            <span>KELUAR</span>
            <span style="font-weight:600; font-size:1.1em;"><?= $transaksi->waktu_keluar ? date('H:i', strtotime($transaksi->waktu_keluar)) : '-' ?></span>
            <span style="font-size:0.97em; color:#888;">Tarif</span>
            <span id="totalTarifDisplay" style="font-weight:600; color:#1976d2; font-size:1.05em;">Rp <?= number_format($biaya_total ?? 0,0,',','.') ?></span>
        </div>
    </div>
    <div class="bayar-total">
        <div>TOTAL PEMBAYARAN</div>
        <div class="nominal" id="totalNominal">Rp <?= number_format($biaya_total ?? 0,0,',','.') ?></div>
    </div>
    <form id="formBayar" method="post" action="<?= base_url('index.php/petugas/transaksi/proses_bayar') ?>">
        <input type="hidden" name="id_parkir" value="<?= $transaksi->id_parkir ?>">
        <input type="hidden" id="biayaTotalInput" name="biaya_total" value="<?= $biaya_total ?? 0 ?>">
        <div class="bayar-metode" style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e0e0e0;">
            <div class="bayar-metode-label" style="font-size: 0.95rem; color: #666; font-weight: 600; margin-bottom: 0.8rem;">PILIH METODE PEMBAYARAN</div>
            <div class="bayar-metode-btns">
                <button type="button" class="bayar-metode-btn cash active" id="btnCash" style="width: 100%; padding: 1rem 1.2rem; background: #e3f2fd; color: #1976d2; border: 2px solid #1976d2; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                    CASH
                </button>
            </div>
        </div>
        <div id="bayarUang" class="bayar-uang">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <span style="font-size: 2.5rem;">💵</span>
                <div style="flex: 1;">
                    <div class="bayar-uang-label">UANG DITERIMA</div>
                    <input type="number" min="0" class="bayar-uang-input" name="uang_diberikan" id="uangDiterima" placeholder="Masukkan nominal..." autocomplete="off">
                </div>
            </div>
            <div class="bayar-kembalian" style="text-align: center; background: #f0f8ff; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.3rem;">KEMBALIAN</div>
                <span id="kembalianNominal" style="font-size: 1.8rem; font-weight: 700; color: #1976d2;">Rp 0</span>
            </div>
        </div>
        <div class="bayar-actions" style="display: flex; gap: 1rem; padding-top: 0.5rem; border-top: 1px solid #e0e0e0;">
            <a href="<?= base_url('index.php/petugas/transaksi') ?>" class="btn btn-back" style="flex: 1; padding: 0.8rem; text-align: center; background: #f5f5f5; color: #222; border: 1px solid #ddd; border-radius: 6px; text-decoration: none; font-weight: 600; cursor: pointer;">Kembali</a>
            <button type="submit" class="btn btn-pay" id="btnBayar" disabled style="flex: 1; padding: 0.8rem; background: #1976d2; color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 1rem;">Bayar</button>
        </div>
    </form>
</div>
<script>
const btnCash = document.getElementById('btnCash');
const bayarUang = document.getElementById('bayarUang');
const uangDiterima = document.getElementById('uangDiterima');
const kembalianNominal = document.getElementById('kembalianNominal');
const btnBayar = document.getElementById('btnBayar');
const biayaTotalInput = document.getElementById('biayaTotalInput');
const totalNominalEl = document.getElementById('totalNominal');
const durasiJamEl = document.getElementById('durasiJam');
const bayarCard = document.querySelector('.bayar-card');
let metode = 'cash';
btnCash.onclick = function() {
    metode = 'cash';
    btnCash.classList.add('active');
    bayarUang.style.display = '';
    btnBayar.disabled = true;
    uangDiterima.value = '';
    kembalianNominal.textContent = 'Rp 0';
};
// Function to compute current total based on waktu_masuk and tarif per jam
function computeAndUpdateTotal() {
    const waktuMasuk = new Date(bayarCard.dataset.waktuMasuk.replace(' ', 'T'));
    const now = new Date();
    let diffMs = now - waktuMasuk;
    let hours = Math.ceil(diffMs / 3600000);
    if (hours < 1) hours = 1;
    const tarif = parseInt(bayarCard.dataset.tarifPerJam) || 0;
    const total = hours * tarif;
    // update UI
    durasiJamEl.textContent = hours + ' jam';
    totalNominalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    biayaTotalInput.value = total;
    return total;
}

// Always recalculate based on current time
computeAndUpdateTotal();
setInterval(computeAndUpdateTotal, 1000); // every 1s for live update

uangDiterima.addEventListener('input', function() {
    const total = parseInt(biayaTotalInput.value) || 0;
    let uang = parseInt(uangDiterima.value) || 0;
    let kembalian = uang - total;
    kembalianNominal.textContent = 'Rp ' + (kembalian >= 0 ? kembalian.toLocaleString('id-ID') : 0);
    btnBayar.disabled = uang < total;
});
document.getElementById('formBayar').onsubmit = function(e) {
    if (metode === 'cash') {
        const currentTotal = parseInt(biayaTotalInput.value) || 0;
        if ((parseInt(uangDiterima.value) || 0) < currentTotal) {
            alert('Uang diterima kurang dari total pembayaran!');
            return false;
        }
    }
    let metodeInput = document.createElement('input');
    metodeInput.type = 'hidden';
    metodeInput.name = 'metode';
    metodeInput.value = metode;
    this.appendChild(metodeInput);

    // Hapus redirect JS, biarkan controller yang mengarahkan ke halaman struk
};
btnCash.click();
</script>
