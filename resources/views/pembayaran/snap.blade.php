@extends('layouts.app')

@section('title', 'Pembayaran Pesanan #' . $p->id_pemesanan)

@section('content')
<div style="max-width: 520px; margin: 40px auto; padding: 24px; background: #111820; border: 1px solid #26323e; border-radius: 16px; color: #f1f5f9;">
    <h2 style="margin-top: 0;">Pembayaran Pesanan #{{ $p->id_pemesanan }}</h2>
    <p>Kendaraan: <strong>{{ $p->armada->nama_kendaraan ?? '-' }}</strong></p>
    <p>Durasi: <strong>{{ $p->durasi }} hari</strong></p>
    <p>Total Bayar: <strong>Rp{{ number_format($p->total_biaya, 0, ',', '.') }}</strong></p>

    <button id="pay-button" style="width: 100%; padding: 12px; margin-top: 16px; background: #42dcc3; color: #06251f; font-weight: 700; border: none; border-radius: 10px; cursor: pointer;">
        Bayar Sekarang dengan Midtrans
    </button>

    <div style="margin-top: 12px; text-align: center;">
        <a href="{{ route('customer.orders') }}" style="color: #94a3b8; font-size: 13px;">Kembali ke Pesanan Saya</a>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    const payButton = document.getElementById('pay-button');

    function openSnap() {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                window.location.href = "{{ route('customer.orders') }}";
            },
            onPending: function (result) {
                window.location.href = "{{ route('customer.orders') }}";
            },
            onError: function (result) {
                alert('Pembayaran gagal diproses. Silakan coba lagi.');
            },
            onClose: function () {
                console.log('Popup pembayaran ditutup.');
            }
        });
    }

    payButton.addEventListener('click', openSnap);
    window.addEventListener('load', openSnap);
</script>
@endsection