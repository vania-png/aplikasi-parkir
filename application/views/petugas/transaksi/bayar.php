<link rel="stylesheet" href="<?= base_url('assets/css/pages/bayar_parkir.css') ?>">

</style>
<div class="bayar-card">
    <div class="bayar-header">
        <div class="nomor"><?= $transaksi->nomor_karcis ?? $transaksi->id_parkir ?? '-' ?></div>
        <div class="jenis"><?= $transaksi->jenis_kendaraan ?? '-' ?> &bull; <?= $transaksi->nama_area ?? '-' ?></div>
    </div>
    <div class="bayar-info">
        <div class="bayar-info-col">
            <span>MASUK</span>
            <span style="font-weight:600; font-size:1.1em;"><?= date('H:i', strtotime($transaksi->waktu_masuk)) ?></span>
            <span style="font-size:0.97em; color:#888;">Durasi</span>
            <span style="font-weight:600; color:#1976d2; font-size:1.05em;"><?= $durasi_jam ?? '-' ?> jam</span>
        </div>
        <div class="bayar-info-col" style="text-align:right;">
            <span>KELUAR</span>
            <span style="font-weight:600; font-size:1.1em;"><?= $transaksi->waktu_keluar ? date('H:i', strtotime($transaksi->waktu_keluar)) : '-' ?></span>
            <span style="font-size:0.97em; color:#888;">Tarif</span>
            <span style="font-weight:600; color:#1976d2; font-size:1.05em;">Rp <?= number_format($biaya_total ?? 0,0,',','.') ?></span>
        </div>
    </div>
    <div class="bayar-total">
        <div>TOTAL PEMBAYARAN</div>
        <div class="nominal">Rp <?= number_format($biaya_total ?? 0,0,',','.') ?></div>
    </div>
    <form id="formBayar" method="post" action="<?= base_url('index.php/petugas/transaksi/proses_bayar') ?>">
        <input type="hidden" name="id_parkir" value="<?= $transaksi->id_parkir ?>">
        <input type="hidden" name="biaya_total" value="<?= $biaya_total ?? 0 ?>">
        <div class="bayar-metode">
            <div class="bayar-metode-label">PILIH METODE PEMBAYARAN</div>
            <div class="bayar-metode-btns">
                <button type="button" class="bayar-metode-btn cash active" id="btnCash"><span>💵</span> CASH</button>
            </div>
        </div>
        <div id="bayarUang" class="bayar-uang">
            <div class="bayar-uang-label">UANG DITERIMA</div>
            <input type="number" min="0" class="bayar-uang-input" name="uang_diberikan" id="uangDiterima" placeholder="Masukkan nominal..." autocomplete="off">
            <div class="bayar-kembalian">KEMBALIAN<br><span id="kembalianNominal">Rp 0</span></div>
        </div>
        <div class="bayar-actions">
            <a href="<?= base_url('index.php/petugas/transaksi') ?>" class="btn btn-back">&larr; Kembali</a>
            <button type="submit" class="btn btn-pay" id="btnBayar" disabled>Bayar</button>
        </div>
    </form>
</div>
<script>
const btnCash = document.getElementById('btnCash');
const bayarUang = document.getElementById('bayarUang');
const uangDiterima = document.getElementById('uangDiterima');
const kembalianNominal = document.getElementById('kembalianNominal');
const btnBayar = document.getElementById('btnBayar');
let metode = 'cash';
btnCash.onclick = function() {
    metode = 'cash';
    btnCash.classList.add('active');
    bayarUang.style.display = '';
    btnBayar.disabled = true;
    uangDiterima.value = '';
    kembalianNominal.textContent = 'Rp 0';
};

uangDiterima.addEventListener('input', function() {
    const total = <?= $biaya_total ?? 0 ?>;
    let uang = parseInt(uangDiterima.value) || 0;
    let kembalian = uang - total;
    kembalianNominal.textContent = 'Rp ' + (kembalian >= 0 ? kembalian.toLocaleString('id-ID') : 0);
    btnBayar.disabled = uang < total;
});
document.getElementById('formBayar').onsubmit = function(e) {
    if (metode === 'cash') {
        if ((parseInt(uangDiterima.value) || 0) < <?= $biaya_total ?? 0 ?>) {
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
