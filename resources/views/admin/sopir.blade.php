@extends('layouts.admin')

@section('title', 'Kelola Supir')
@section('page-heading', 'Kelola Supir')

@section('content')
    <div class="page-heading">
        <div>
            <h1>Kelola Supir</h1>
            <p>Kelola data supir dan akun yang digunakan untuk masuk ke portal Supir.</p>
        </div>
        <span class="badge">{{ $sopirs->count() }} supir</span>
    </div>

    <div class="panel">
        <h2>Tambah Supir dan Akun Login</h2>

        <form method="POST" action="{{ route('admin.sopir.store') }}">
            @csrf

            <div class="grid">
                <div class="field">
                    <label for="nama">Nama lengkap</label>
                    <input id="nama" name="nama" value="{{ old('nama') }}" required>
                </div>

                <div class="field">
                    <label for="no_hp">Nomor HP</label>
                    <input id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                </div>

                <div class="field">
                    <label for="email">Email login</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="field">
                    <label for="password">Password login (minimal 8 karakter)</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        minlength="8"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <div class="field">
                    <label for="alamat">Alamat</label>
                    <input id="alamat" name="alamat" value="{{ old('alamat') }}">
                </div>

                <div class="field">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="tersedia">Tersedia</option>
                        <option value="bertugas">Bertugas</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn" type="submit">＋ Tambah Supir</button>
            </div>
        </form>
    </div>

    <div class="page-heading">
        <div>
            <h1 style="font-size: 20px">Daftar Supir</h1>
            <p>Jangan bagikan password akun supir kepada pihak lain.</p>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sopirs as $s)
                    <tr>
                        <td>
                            <strong>{{ $s->nama }}</strong>
                            <div class="muted" style="font-size: 11px; margin-top: 4px">
                                ID #{{ $s->id_sopir }}
                            </div>
                        </td>
                        <td>{{ $s->no_hp }}</td>
                        <td>{{ $s->email ?? '—' }}</td>
                        <td>{{ $s->alamat ?: '—' }}</td>
                        <td>
                            <span class="badge">{{ ucfirst($s->status) }}</span>
                        </td>
                        <td>
                            <form
                                method="POST"
                                action="{{ route('admin.sopir.delete', $s) }}"
                                onsubmit="return confirm('Hapus supir ini?')"
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
                            <div class="empty-state">Belum ada data supir.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
