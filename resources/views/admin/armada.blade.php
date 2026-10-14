
@extends('layouts.app')

@section('title', 'Kelola Armada')

@section('content')
    <h1>Kelola Armada</h1>

    {{-- Form tambah armada --}}
    <div class="card" style="margin: 18px 0;">
        <h2>Tambah Armada</h2>

        <form method="POST" action="{{ route('admin.armada.store') }}">
            @csrf

            <div class="grid">
                <div class="field">
                    <label for="nama_kendaraan">Nama kendaraan</label>
                    <input
                        type="text"
                        id="nama_kendaraan"
                        name="nama_kendaraan"
                        required
                    >
                </div>

                <div class="field">
                    <label for="tipe">Tipe</label>
                    <select id="tipe" name="tipe" required>
                        <option value="Mobil">Mobil</option>
                        <option value="Motor">Motor</option>
                        <option value="Bus">Bus</option>
                        <option value="HiAce">HiAce</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="field">
                    <label for="harga_sewa">Harga sewa per hari (Rp)</label>
                    <input
                        type="number"
                        id="harga_sewa"
                        name="harga_sewa"
                        min="0"
                        step="1000"
                        required
                    >
                </div>

                <div class="field">
                    <label for="transmisi">Transmisi</label>
                    <input
                        type="text"
                        id="transmisi"
                        name="transmisi"
                        placeholder="Manual / Automatic"
                    >
                </div>

                <div class="field">
                    <label for="plat_nomor">Plat nomor</label>
                    <input
                        type="text"
                        id="plat_nomor"
                        name="plat_nomor"
                    >
                </div>

                <div class="field">
                    <label for="status_ketersediaan">Status</label>
                    <select
                        id="status_ketersediaan"
                        name="status_ketersediaan"
                        required
                    >
                        <option value="tersedia">Tersedia</option>
                        <option value="disewa">Disewa</option>
                        <option value="perawatan">Perawatan</option>
                    </select>
                </div>
            </div>

            <button type="submit">Tambah Armada</button>
        </form>
    </div>

    {{-- Tabel daftar armada --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Harga/hari</th>
                    <th>Plat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($armadas as $a)
                    <tr>
                        <td>{{ $a->nama_kendaraan }}</td>
                        <td>{{ $a->tipe }}</td>
                        <td>
                            Rp{{ number_format($a->harga_sewa, 0, ',', '.') }}
                        </td>
                        <td>{{ $a->plat_nomor ?: '-' }}</td>
                        <td>{{ ucfirst($a->status_ketersediaan) }}</td>
                        <td>
                            <form
                                method="POST"
                                action="{{ route('admin.armada.delete', $a) }}"
                                onsubmit="return confirm('Hapus armada ini?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada data armada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
