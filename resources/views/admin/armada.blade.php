@extends('layouts.app')

@section('title', 'Kelola Armada')
@section('page-heading', 'Kelola Armada')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Kelola Armada</h1>
            <p>Tambahkan dan pantau kendaraan yang tersedia untuk disewakan.</p>
        </div>
        <span class="badge">{{ $armadas->count() }} kendaraan</span>
    </div>

    <div class="panel">
        <h2>Tambah Armada</h2>

        <form method="POST" action="{{ route('admin.armada.store') }}">
            @csrf

            <div class="grid">
                <div class="field">
                    <label for="nama_kendaraan">Nama kendaraan</label>
                    <input
                        id="nama_kendaraan"
                        name="nama_kendaraan"
                        value="{{ old('nama_kendaraan') }}"
                        required
                        maxlength="120"
                    >
                </div>

                <div class="field">
                    <label for="tipe">Tipe kendaraan</label>
                    <select id="tipe" name="tipe" required>
                        @foreach (['Mobil', 'Motor', 'Bus', 'HiAce', 'Lainnya'] as $tipe)
                            <option value="{{ $tipe }}" @selected(old('tipe') === $tipe)>
                                {{ $tipe }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="harga_sewa">Harga sewa per hari (Rp)</label>
                    <input
                        id="harga_sewa"
                        type="number"
                        name="harga_sewa"
                        min="0"
                        step="1000"
                        value="{{ old('harga_sewa') }}"
                        required
                    >
                </div>

                <div class="field">
                    <label for="transmisi">Transmisi</label>
                    <input
                        id="transmisi"
                        name="transmisi"
                        value="{{ old('transmisi') }}"
                        placeholder="Manual / Automatic"
                    >
                </div>

                <div class="field">
                    <label for="plat_nomor">Plat nomor</label>
                    <input
                        id="plat_nomor"
                        name="plat_nomor"
                        value="{{ old('plat_nomor') }}"
                    >
                </div>

                <div class="field">
                    <label for="status_ketersediaan">Status</label>
                    <select id="status_ketersediaan" name="status_ketersediaan" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="disewa">Disewa</option>
                        <option value="perawatan">Perawatan</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn" type="submit">＋ Tambah Armada</button>
            </div>
        </form>
    </div>

    <div class="page-heading">
        <div>
            <h1 style="font-size: 20px">Daftar Kendaraan</h1>
            <p>Data armada yang tersimpan dalam sistem.</p>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama kendaraan</th>
                    <th>Tipe</th>
                    <th>Harga/hari</th>
                    <th>Plat nomor</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($armadas as $a)
                    <tr>
                        <td>
                            <strong>{{ $a->nama_kendaraan }}</strong>
                            <div class="muted" style="font-size: 11px; margin-top: 4px">
                                ID #{{ $a->id_armada }}
                            </div>
                        </td>
                        <td>{{ $a->tipe }}</td>
                        <td>Rp{{ number_format($a->harga_sewa, 0, ',', '.') }}</td>
                        <td>{{ $a->plat_nomor ?: '—' }}</td>
                        <td>
                            <span class="badge">
                                {{ ucfirst($a->status_ketersediaan) }}
                            </span>
                        </td>
                        <td>
                            <form
                                method="POST"
                                action="{{ route('admin.armada.delete', $a) }}"
                                onsubmit="return confirm('Hapus armada ini?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button class="btn-danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                Belum ada data armada. Gunakan form di atas untuk menambahkan kendaraan.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
