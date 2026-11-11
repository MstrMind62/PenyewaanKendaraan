@extends('layouts.app')

@section('title', 'Buat Pemesanan')

@section('content')
@php
    $tanggalDipilihAwal = old('tanggal_sewa', []);

    if (!is_array($tanggalDipilihAwal)) {
        $tanggalDipilihAwal = [];
    }

    $armadaBisaDipesan =
        $armada->status_ketersediaan === 'tersedia'
        && (int) ($armada->stok ?? 1) > 0;
@endphp

<div class="card booking-card" style="max-width: 820px; margin: auto;">

    <a href="{{ route('armada.index') }}">← Kembali ke armada</a>

    <h1 style="margin-top: 14px;">
        Pesan {{ $armada->nama_kendaraan }}
    </h1>

    <p class="price">
        Rp{{ number_format($armada->harga_sewa, 0, ',', '.') }}
        <small>/ hari</small>
    </p>

    <p class="muted">
        Stok kendaraan:
        <strong>{{ $armada->stok ?? 1 }} unit</strong>.
        Setiap tanggal yang dipilih menggunakan satu unit stok.
    </p>

    @if(!$armadaBisaDipesan)
        <div class="booking-alert">
            Armada ini sedang tidak tersedia untuk dipesan.
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('booking.store', $armada) }}"
        id="booking"
    >
        @csrf

        <div class="field">
            <label for="durasi">Berapa hari ingin menyewa?</label>

            <input
                type="number"
                name="durasi"
                id="durasi"
                min="1"
                max="31"
                value="{{ old('durasi', max(1, count($tanggalDipilihAwal))) }}"
                required
            >

            <small class="muted">
                Masukkan jumlah hari, lalu pilih tanggal sebanyak jumlah tersebut.
                Tanggal tidak harus berurutan.
            </small>
        </div>

        <div class="field">

            <div class="calendar-heading">
                <div>
                    <label>Pilih tanggal sewa</label>

                    <small class="muted">
                        Tanggal hanya dapat dipilih setelah hari ini
                        sampai akhir bulan ini.
                    </small>
                </div>

                <span class="calendar-month" id="calendar-month"></span>
            </div>

            <div class="calendar-legend">
                <span><i class="legend-dot available"></i> Tersedia</span>
                <span><i class="legend-dot limited"></i> Stok terbatas</span>
                <span><i class="legend-dot full"></i> Penuh</span>
                <span><i class="legend-dot chosen"></i> Dipilih</span>
            </div>

            <div class="calendar-weekdays">
                @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $hari)
                    <span>{{ $hari }}</span>
                @endforeach
            </div>

            <div
                class="calendar-days"
                id="calendar-days"
                aria-label="Kalender tanggal sewa"
            ></div>

            <div class="selected-dates-box">
                <div class="selected-dates-title">
                    <span>Tanggal yang dipilih</span>
                    <strong id="selected-count">0</strong>
                </div>

                <div id="selected-dates" class="selected-date-list">
                    <span class="muted">Belum ada tanggal dipilih.</span>
                </div>
            </div>

            <div
                id="calendar-message"
                class="calendar-message"
                aria-live="polite"
            ></div>

            <div id="selected-inputs"></div>

            @error('tanggal_sewa')
                <div class="booking-error">{{ $message }}</div>
            @enderror

            @error('tanggal_sewa.*')
                <div class="booking-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="layanan">Layanan</label>

            <select name="layanan" id="layanan">
                <option
                    value="ambil"
                    @selected(old('layanan', 'ambil') === 'ambil')
                >
                    Ambil sendiri di lokasi
                </option>

                <option
                    value="diantar"
                    @selected(old('layanan') === 'diantar')
                >
                    Diantar ke alamat
                </option>
            </select>
        </div>

        <div class="field" id="alamat">
            <label>Alamat pengantaran</label>

            <textarea name="alamat_antar" rows="2">{{ old('alamat_antar') }}</textarea>
        </div>

        <div class="field">
            <label for="metode_pembayaran">Metode pembayaran</label>

            <select
                name="metode_pembayaran"
                id="metode_pembayaran"
                required
            >
                @foreach(['Transfer Bank', 'E-Wallet', 'QRIS'] as $metode)
                    <option
                        value="{{ $metode }}"
                        @selected(old('metode_pembayaran', 'Transfer Bank') === $metode)
                    >
                        {{ $metode }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="card booking-total" style="margin: 16px 0;">
            <span class="muted">Estimasi total</span>

            <div class="price" id="total">
                Rp{{ number_format($armada->harga_sewa, 0, ',', '.') }}
            </div>

            <small class="muted">
                Harga dihitung berdasarkan jumlah tanggal yang dipilih.
                Pembayaran pada versi ini masih berupa simulasi.
            </small>
        </div>

        <button
            type="submit"
            id="submit-booking"
            {{ !$armadaBisaDipesan ? 'disabled' : '' }}
        >
            Konfirmasi Pemesanan
        </button>
    </form>
</div>

<style>
    .booking-card {
        color: var(--text, inherit);
    }

    .calendar-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
    }

    .calendar-heading label {
        display: block;
        margin-bottom: 5px;
    }

    .calendar-month {
        font-weight: 700;
        white-space: nowrap;
    }

    .calendar-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin: 12px 0;
        font-size: 12px;
        color: var(--muted, #94a3b8);
    }

    .calendar-legend span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .legend-dot {
        width: 9px;
        height: 9px;
        display: inline-block;
        border-radius: 50%;
        background: #16a34a;
    }

    .legend-dot.limited {
        background: #e6a23c;
    }

    .legend-dot.full {
        background: #dc5555;
    }

    .legend-dot.chosen {
        background: #3b82f6;
    }

    .calendar-weekdays,
    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 7px;
    }

    .calendar-weekdays {
        margin-bottom: 7px;
        text-align: center;
        color: var(--muted, #94a3b8);
        font-size: 12px;
        font-weight: 700;
    }

    .calendar-days button,
    .calendar-empty {
        min-width: 0;
        min-height: 66px;
        border-radius: 10px;
    }

    .calendar-days button {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        border: 1px solid var(--border, #334155);
        background: var(--surface, rgba(148,163,184,.06));
        color: inherit;
        cursor: pointer;
        padding: 6px 2px;
    }

    .calendar-days button .day-number {
        font-size: 15px;
        font-weight: 700;
    }

    .calendar-days button .day-stock {
        font-size: 10px;
        color: var(--muted, #94a3b8);
    }

    .calendar-days button.available {
        border-color: rgba(22,163,74,.45);
    }

    .calendar-days button.limited {
        border-color: rgba(230,162,60,.65);
    }

    .calendar-days button.full,
    .calendar-days button:disabled {
        opacity: .38;
        cursor: not-allowed;
        background: rgba(127,127,127,.08);
    }

    .calendar-days button.selected {
        color: #fff;
        background: #2563eb;
        border-color: #2563eb;
        opacity: 1;
    }

    .calendar-days button.selected .day-stock {
        color: #dbeafe;
    }

    .calendar-days button:focus-visible {
        outline: 2px solid #60a5fa;
        outline-offset: 2px;
    }

    .selected-dates-box {
        margin-top: 14px;
        padding: 12px;
        border: 1px solid var(--border, #334155);
        border-radius: 10px;
    }

    .selected-dates-title {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 13px;
    }

    .selected-date-list {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }

    .selected-date-chip {
        border-radius: 20px;
        background: rgba(37,99,235,.15);
        color: #60a5fa;
        padding: 6px 10px;
        font-size: 12px;
    }

    .calendar-message {
        min-height: 20px;
        margin-top: 7px;
        color: #e6a23c;
        font-size: 12px;
    }

    .booking-error,
    .booking-alert {
        padding: 10px 12px;
        border-radius: 9px;
        color: #fecaca;
        background: rgba(220,85,85,.12);
        margin-top: 8px;
        font-size: 13px;
    }

    .booking-total {
        background: rgba(100,116,139,.10);
    }

    #submit-booking:disabled {
        opacity: .45;
        cursor: not-allowed;
    }

    @media(max-width:520px) {
        .calendar-days {
            gap: 4px;
        }

        .calendar-days button,
        .calendar-empty {
            min-height: 55px;
            border-radius: 7px;
        }

        .calendar-days button .day-stock {
            font-size: 9px;
        }

        .calendar-legend {
            gap: 8px;
        }
    }
</style>

<script>
(() => {
    const harga = {{ (float) $armada->harga_sewa }};
    const stokTotal = {{ (int) ($armada->stok ?? 1) }};
    const armadaAktif = @json($armadaBisaDipesan);
    const jumlahTerpakai = @json($jumlahTerpakai);
    const tanggalMinimal = @json($tanggalMinimal);
    const tanggalMaksimal = @json($tanggalMaksimal);
    const tanggalAwal = @json(array_values($tanggalDipilihAwal));

    const durasi = document.getElementById('durasi');
    const calendar = document.getElementById('calendar-days');
    const selectedDatesBox = document.getElementById('selected-dates');
    const selectedCount = document.getElementById('selected-count');
    const selectedInputs = document.getElementById('selected-inputs');
    const message = document.getElementById('calendar-message');
    const total = document.getElementById('total');
    const layanan = document.getElementById('layanan');
    const alamat = document.getElementById('alamat');
    const submit = document.getElementById('submit-booking');

    const selected = new Set(tanggalAwal);

    const [year, month, day] = tanggalMinimal.split('-').map(Number);
    const monthIndex = month - 1;

    const [maxYear, maxMonth] = tanggalMaksimal
        .split('-')
        .map(Number);

    document.getElementById('calendar-month').textContent =
        new Intl.DateTimeFormat('id-ID', {
            month: 'long',
            year: 'numeric'
        }).format(new Date(maxYear, maxMonth - 1, 1));

    function formatTanggal(value) {
        const [y, m, d] = value.split('-').map(Number);

        return new Intl.DateTimeFormat('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        }).format(new Date(y, m - 1, d));
    }

    function tanggalString(dayNumber) {
        return `${maxYear}-${String(maxMonth).padStart(2, '0')}-${String(dayNumber).padStart(2, '0')}`;
    }

    function sisaStok(tanggal) {
        return Math.max(
            0,
            stokTotal - Number(jumlahTerpakai[tanggal] || 0)
        );
    }

    function render() {
        calendar.innerHTML = '';

        const firstWeekday =
            (new Date(maxYear, maxMonth - 1, 1).getDay() + 6) % 7;

        const totalHari =
            new Date(maxYear, maxMonth, 0).getDate();

        // Mengisi ruang kosong sebelum tanggal 1.
        for (let i = 0; i < firstWeekday; i++) {
            const empty = document.createElement('span');
            empty.className = 'calendar-empty';
            calendar.appendChild(empty);
        }

        // Membuat tombol tanggal.
        for (let dayNumber = 1; dayNumber <= totalHari; dayNumber++) {
            const tanggal = tanggalString(dayNumber);
            const sisa = sisaStok(tanggal);

            const bolehPilih =
                armadaAktif &&
                tanggal >= tanggalMinimal &&
                tanggal <= tanggalMaksimal &&
                sisa > 0;

            const button = document.createElement('button');
            button.type = 'button';

            button.className =
                sisa === 0
                    ? 'full'
                    : (sisa < stokTotal ? 'limited' : 'available');

            if (selected.has(tanggal)) {
                button.classList.add('selected');
            }

            button.disabled = !bolehPilih && !selected.has(tanggal);

            button.setAttribute(
                'aria-label',
                `${formatTanggal(tanggal)}, sisa ${sisa} unit`
            );

            const number = document.createElement('span');
            number.className = 'day-number';
            number.textContent = dayNumber;

            const stock = document.createElement('span');
            stock.className = 'day-stock';
            stock.textContent = sisa === 0 ? 'Penuh' : `${sisa} unit`;

            button.append(number, stock);

            button.addEventListener('click', () => {
                message.textContent = '';

                if (selected.has(tanggal)) {
                    selected.delete(tanggal);
                } else {
                    const jumlahHari = Math.max(
                        1,
                        Number(durasi.value) || 1
                    );

                    if (selected.size >= jumlahHari) {
                        message.textContent =
                            `Jumlah tanggal sudah mencapai durasi ${jumlahHari} hari. Hapus salah satu tanggal jika ingin mengganti.`;

                        return;
                    }

                    selected.add(tanggal);
                }

                render();
            });

            calendar.appendChild(button);
        }

        const daftarTerpilih = [...selected].sort();

        const jumlahHari = Math.max(
            1,
            Number(durasi.value) || 1
        );

        selectedCount.textContent =
            `${daftarTerpilih.length} / ${jumlahHari}`;

        selectedDatesBox.innerHTML = '';
        selectedInputs.innerHTML = '';

        if (daftarTerpilih.length === 0) {
            const empty = document.createElement('span');
            empty.className = 'muted';
            empty.textContent = 'Belum ada tanggal dipilih.';
            selectedDatesBox.appendChild(empty);
        }

        daftarTerpilih.forEach(tanggal => {
            const chip = document.createElement('span');
            chip.className = 'selected-date-chip';
            chip.textContent = formatTanggal(tanggal);

            selectedDatesBox.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'tanggal_sewa[]';
            input.value = tanggal;

            selectedInputs.appendChild(input);
        });

        total.textContent = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(harga * daftarTerpilih.length);

        submit.disabled =
            !armadaAktif ||
            daftarTerpilih.length !== jumlahHari;
    }

    // Jika durasi berubah, jumlah tanggal pilihan disesuaikan.
    durasi.addEventListener('input', () => {
        let jumlah = Math.max(
            1,
            Math.min(31, Number(durasi.value) || 1)
        );

        durasi.value = jumlah;

        const daftar = [...selected].sort();

        while (selected.size > jumlah) {
            selected.delete(daftar.pop());
        }

        message.textContent = '';
        render();
    });

    // Menampilkan alamat hanya jika layanan diantar.
    layanan.addEventListener('change', () => {
        alamat.style.display =
            layanan.value === 'diantar' ? 'grid' : 'none';
    });

    // Validasi sebelum form dikirim.
    document.getElementById('booking').addEventListener('submit', event => {
        if (selected.size !== Number(durasi.value)) {
            event.preventDefault();

            message.textContent =
                `Pilih tepat ${durasi.value} tanggal sebelum melanjutkan.`;
        }
    });

    alamat.style.display =
        layanan.value === 'diantar' ? 'grid' : 'none';

    render();
})();
</script>
@endsection