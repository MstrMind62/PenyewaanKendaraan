@extends('layouts.app')

@section('title', 'Kelola Sopir')

@section('content')
    <h1>Kelola Sopir</h1>

    <div class="card" style="margin: 18px 0">
        <h2>Tambah Sopir</h2>

        <form method="post" action="{{ route('admin.sopir.store') }}">
            @csrf

            <div class="grid">
                <div class="field">
                    <label>Nama</label>
                    <input name="nama" required>
                </div>

                <div class="field">
                    <label>Nomor HP</label>
                    <input name="no_hp" required>
                </div>

                <div class="field">
                    <label>Alamat</label>
                    <input name="alamat">
                </div>

                <div class="field">
                    <label>Status</label>
                    <select name="status">
                        <option>tersedia</option>
                        <option>bertugas</option>
                        <option>nonaktif</option>
                    </select>
                </div>
            </div>

            <button>Tambah Sopir</button>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sopirs as $s)
                    <tr>
                        <td>{{ $s->nama }}</td>
                        <td>{{ $s->no_hp }}</td>
                        <td>{{ $s->alamat }}</td>
                        <td>{{ $s->status }}</td>
                        <td>
                            <form method="post" action="{{ route('admin.sopir.delete', $s) }}" onsubmit="return confirm('Hapus sopir ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada data sopir.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
