
@extends('layouts.app')

@section('title', 'Kelola Armada')
@section('page-heading', 'Kelola Armada')

@section('content')

<style>
    .fleet-page {
        display: flex;
        flex-direction: column;
        gap: 26px;
        color: #f1f5f9;
    }

    .fleet-page * {
        box-sizing: border-box;
    }

    .fleet-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .fleet-heading h1 {
        font-size: 25px;
        font-weight: 750;
        margin: 0 0 7px;
        color: #f8fafc;
    }

    .fleet-heading p {
        color: #94a3b8;
        font-size: 14px;
        margin: 0;
    }

    .fleet-count {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border: 1px solid rgba(66, 220, 195, .2);
        background: rgba(66, 220, 195, .09);
        color: #4ee1c5;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 650;
        white-space: nowrap;
    }

    .fleet-panel {
        background: #111820;
        border: 1px solid #26323e;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .12);
    }

    .fleet-panel-header {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 24px;
    }

    .fleet-panel-icon {
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(66, 220, 195, .12);
        color: #4ee1c5;
        font-size: 21px;
    }

    .fleet-panel-header h2 {
        margin: 0 0 5px;
        font-size: 18px;
        color: #f8fafc;
    }

    .fleet-panel-header p {
        margin: 0;
        color: #8493a3;
        font-size: 12px;
    }

    .fleet-form-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 19px;
    }

    .fleet-field {
        display: flex;
        flex-direction: column;
        gap: 9px;
        min-width: 0;
    }

    .fleet-field label {
        color: #cbd5e1;
        font-size: 13px;
        font-weight: 600;
    }

    .fleet-field input,
    .fleet-field select {
        width: 100%;
        min-height: 44px;
        padding: 10px 13px;
        color: #f1f5f9;
        background: #0b1118;
        border: 1px solid #344252;
        border-radius: 9px;
        outline: none;
        font-size: 13px;
        transition: .2s ease;
    }

    .fleet-field input:focus,
    .fleet-field select:focus {
        border-color: #42dcc3;
        box-shadow: 0 0 0 3px rgba(66, 220, 195, .10);
    }

    .fleet-field select option {
        background: #111820;
        color: #f1f5f9;
    }

    .fleet-help {
        color: #718096;
        font-size: 11px;
        line-height: 1.5;
    }

    .fleet-form-footer {
        display: flex;
        justify-content: flex-end;
        margin-top: 23px;
        padding-top: 20px;
        border-top: 1px solid #26323e;
    }

    .fleet-btn-add,
    .fleet-btn-save,
    .fleet-btn-delete {
        border: none;
        cursor: pointer;
        font-weight: 650;
        transition: .2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        white-space: nowrap;
    }

    .fleet-btn-add {
        min-height: 44px;
        padding: 0 20px;
        border-radius: 10px;
        color: #06251f;
        background: #42dcc3;
        font-size: 13px;
    }

    .fleet-btn-add:hover,
    .fleet-btn-save:hover {
        background: #62ead3;
        transform: translateY(-1px);
    }

    .fleet-list-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .fleet-list-heading h2 {
        margin: 0 0 6px;
        font-size: 21px;
        color: #f8fafc;
    }

    .fleet-list-heading p {
        margin: 0;
        color: #8493a3;
        font-size: 13px;
    }

    .fleet-table-card {
        background: #111820;
        border: 1px solid #26323e;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .12);
    }

    .fleet-table-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 19px 22px;
        border-bottom: 1px solid #26323e;
    }

    .fleet-table-top strong {
        color: #e2e8f0;
        font-size: 14px;
    }

    .fleet-table-top span {
        color: #7f91a3;
        font-size: 12px;
    }

    .fleet-table-scroll {
        width: 100%;
        overflow-x: auto;
    }

    .fleet-table {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
        text-align: left;
    }

    .fleet-table thead {
        background: #18232e;
    }

    .fleet-table th {
        padding: 16px 17px;
        color: #8fa2b5;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .65px;
        white-space: nowrap;
        border-bottom: 1px solid #2b3946;
    }

    .fleet-table td {
        padding: 17px;
        border-bottom: 1px solid #24303b;
        color: #dbe4ed;
        font-size: 13px;
        vertical-align: middle;
    }

    .fleet-table tbody tr {
        transition: background .2s ease;
    }

    .fleet-table tbody tr:hover {
        background: rgba(66, 220, 195, .035);
    }

    .fleet-table tbody tr:last-child td {
        border-bottom: none;
    }

    .fleet-vehicle {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 145px;
    }

    .fleet-vehicle strong {
        color: #f1f5f9;
        font-size: 14px;
        font-weight: 700;
    }

    .fleet-vehicle small {
        color: #718096;
        font-size: 11px;
    }

    .fleet-type {
        display: inline-flex;
        padding: 6px 10px;
        background: #202d39;
        border: 1px solid #30404e;
        color: #b9c8d7;
        border-radius: 7px;
        font-size: 11px;
        white-space: nowrap;
    }

    .fleet-price {
        color: #4ee1c5;
        font-weight: 700;
        white-space: nowrap;
    }

    .fleet-stock {
        color: #e2e8f0;
        font-weight: 700;
        white-space: nowrap;
    }

    .fleet-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 10px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 650;
        white-space: nowrap;
    }

    .fleet-status::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .fleet-status.available {
        color: #4ee1a0;
        background: rgba(46, 204, 113, .10);
    }

    .fleet-status.rented {
        color: #f5c76b;
        background: rgba(245, 199, 107, .10);
    }

    .fleet-status.maintenance {
        color: #fb8585;
        background: rgba(251, 133, 133, .10);
    }

    .fleet-stock-form {
        display: flex;
        align-items: center;
        gap: 7px;
        min-width: 175px;
    }

    .fleet-stock-form input {
        width: 65px;
        height: 36px;
        padding: 0 9px;
        color: #f1f5f9;
        background: #0b1118;
        border: 1px solid #344252;
        border-radius: 7px;
        outline: none;
        font-size: 12px;
    }

    .fleet-stock-form input:focus {
        border-color: #42dcc3;
    }

    .fleet-btn-save {
        min-height: 36px;
        padding: 0 12px;
        color: #06251f;
        background: #42dcc3;
        border-radius: 7px;
        font-size: 11px;
    }

    .fleet-btn-delete {
        min-height: 36px;
        padding: 0 12px;
        color: #ff8c8c;
        background: rgba(239, 68, 68, .10);
        border: 1px solid rgba(239, 68, 68, .20);
        border-radius: 7px;
        font-size: 11px;
    }

    .fleet-btn-delete:hover {
        color: #fff;
        background: #dc4545;
    }

    .fleet-empty {
        padding: 55px 20px;
        text-align: center;
        color: #8292a3;
    }

    .fleet-empty-icon {
        font-size: 32px;
        margin-bottom: 12px;
    }

    .fleet-empty strong {
        display: block;
        color: #dbe4ed;
        font-size: 15px;
        margin-bottom: 6px;
    }

    .fleet-empty p {
        margin: 0;
        font-size: 12px;
    }

    @media (max-width: 900px) {
        .fleet-form-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .fleet-page {
            gap: 20px;
        }

        .fleet-heading h1 {
            font-size: 21px;
        }

        .fleet-panel {
            padding: 18px;
        }

        .fleet-form-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .fleet-form-footer {
            justify-content: stretch;
        }

        .fleet-btn-add {
            width: 100%;
        }

        .fleet-list-heading h2 {
            font-size: 19px;
        }

        .fleet-table-top {
            padding: 16px;
        }
    }
</style>

<div class="fleet-page">

    {{-- HEADER --}}
    <div class="fleet-heading">
        <div>
            <h1>Kelola Armada</h1>
            <p>Kelola kendaraan dan pantau ketersediaan stok penyewaan.</p>
        </div>

        <div class="fleet-count">
            <span>▦</span>
            {{ $armadas->count() }} Kendaraan
        </div>
    </div>

    {{-- FORM TAMBAH ARMADA --}}
    <section class="fleet-panel">

        <div class="fleet-panel-header">
            <div class="fleet-panel-icon">＋</div>

            <div>
                <h2>Tambah Armada</h2>
                <p>Masukkan informasi kendaraan baru ke dalam sistem.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.armada.store') }}">
            @csrf

            <div class="fleet-form-grid">

                <div class="fleet-field">
                    <label>Nama kendaraan</label>
                    <input
                        type="text"
                        name="nama_kendaraan"
                        value="{{ old('nama_kendaraan') }}"
                        placeholder="Contoh: Toyota Avanza"
                        required
                        maxlength="120"
                    >
                </div>

                <div class="fleet-field">
                    <label>Tipe kendaraan</label>
                    <select name="tipe" required>
                        @foreach (['Mobil', 'Motor', 'Bus', 'HiAce', 'Lainnya'] as $tipe)
                            <option value="{{ $tipe }}"
                                @selected(old('tipe') === $tipe)>
                                {{ $tipe }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="fleet-field">
                    <label>Harga sewa per hari (Rp)</label>
                    <input
                        type="number"
                        name="harga_sewa"
                        min="0"
                        step="1000"
                        value="{{ old('harga_sewa') }}"
                        placeholder="Contoh: 350000"
                        required
                    >
                </div>

                <div class="fleet-field">
                    <label>Transmisi</label>
                    <input
                        type="text"
                        name="transmisi"
                        value="{{ old('transmisi') }}"
                        placeholder="Manual / Automatic"
                    >
                </div>

                <div class="fleet-field">
                    <label>Jumlah stok kendaraan</label>
                    <input
                        type="number"
                        name="stok"
                        min="1"
                        max="1000"
                        value="{{ old('stok', 1) }}"
                        required
                    >
                    <small class="fleet-help">
                        Jumlah unit untuk model kendaraan yang sama.
                    </small>
                </div>

                <div class="fleet-field">
                    <label>Status ketersediaan</label>
                    <select name="status_ketersediaan" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="disewa">Disewa</option>
                        <option value="perawatan">Perawatan</option>
                    </select>
                </div>

            </div>

            <div class="fleet-form-footer">
                <button class="fleet-btn-add" type="submit">
                    ＋ Tambahkan Armada
                </button>
            </div>
        </form>
    </section>

    {{-- HEADER DAFTAR --}}
    <div class="fleet-list-heading">
        <div>
            <h2>Daftar Kendaraan</h2>
            <p>Informasi seluruh armada yang tersimpan dalam sistem.</p>
        </div>
    </div>

    {{-- TABEL ARMADA --}}
    <section class="fleet-table-card">

        <div class="fleet-table-top">
            <strong>Data Armada Kendaraan</strong>
            <span>{{ $armadas->count() }} data tersimpan</span>
        </div>

        <div class="fleet-table-scroll">
            <table class="fleet-table">

                <thead>
                    <tr>
                        <th>Informasi Kendaraan</th>
                        <th>Tipe</th>
                        <th>Harga / Hari</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Kelola Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($armadas as $a)

                        @php
                            $status = strtolower($a->status_ketersediaan ?? '');

                            $statusClass = match ($status) {
                                'tersedia' => 'available',
                                'disewa' => 'rented',
                                'perawatan' => 'maintenance',
                                default => 'maintenance',
                            };
                        @endphp

                        <tr>

                            {{-- NAMA KENDARAAN --}}
                            <td>
                                <div class="fleet-vehicle">
                                    <strong>{{ $a->nama_kendaraan }}</strong>
                                    <small>ID Kendaraan #{{ $a->id_armada }}</small>
                                </div>
                            </td>

                            {{-- TIPE --}}
                            <td>
                                <span class="fleet-type">
                                    {{ $a->tipe }}
                                </span>
                            </td>

                            {{-- HARGA --}}
                            <td>
                                <span class="fleet-price">
                                    Rp{{ number_format($a->harga_sewa, 0, ',', '.') }}
                                </span>
                            </td>

                            {{-- STOK --}}
                            <td>
                                <span class="fleet-stock">
                                    {{ $a->stok ?? 1 }} unit
                                </span>
                            </td>

                            
                            {{-- STATUS --}}
                            <td>
                                <form
                                    method="POST"
                                    action="{{ route('admin.armada.status', $a) }}"
                                    style="display:flex; flex-direction:column; gap:7px; min-width:145px;"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <select
                                        name="status_ketersediaan"
                                        style="
                                            width:100%;
                                            padding:9px 10px;
                                            color:#f1f5f9;
                                            background:#0b1118;
                                            border:1px solid #344252;
                                            border-radius:7px;
                                            font-size:12px;
                                        "
                                    >
                                        <option value="tersedia"
                                            @selected($a->status_ketersediaan === 'tersedia')>
                                            Tersedia
                                        </option>

                                        <option value="Kosong"
                                            @selected($a->status_ketersediaan === 'disewa')>
                                            Disewa
                                        </option>

                                        <option value="perawatan"
                                            @selected($a->status_ketersediaan === 'perawatan')>
                                            Perawatan
                                        </option>
                                    </select>

                                    <button type="submit" class="fleet-btn-save" style="width:100%;">
                                        Simpan Status
                                    </button>
                                </form>
                            </td>


                            {{-- KELOLA STOK --}}
                            <td>
                                <form
                                    method="POST"
                                    action="{{ route('admin.armada.stock', $a) }}"
                                    class="fleet-stock-form"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <input
                                        type="number"
                                        name="stok"
                                        min="0"
                                        max="1000"
                                        value="{{ $a->stok ?? 1 }}"
                                        required
                                        aria-label="Jumlah stok {{ $a->nama_kendaraan }}"
                                    >

                                    <button class="fleet-btn-save" type="submit">
                                        Simpan
                                    </button>
                                </form>
                            </td>

                            {{-- HAPUS --}}
                            <td>
                                <form
                                    method="POST"
                                    action="{{ route('admin.armada.delete', $a) }}"
                                    onsubmit="return confirm('Apakah kamu yakin ingin menghapus {{ $a->nama_kendaraan }}?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button class="fleet-btn-delete" type="submit">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7">
                                <div class="fleet-empty">
                                    <div class="fleet-empty-icon">▦</div>
                                    <strong>Belum Ada Kendaraan</strong>
                                    <p>Tambahkan armada pertama untuk mulai mengelola kendaraan.</p>
                                </div>
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
        </div>
    </section>

</div>

@endsection
