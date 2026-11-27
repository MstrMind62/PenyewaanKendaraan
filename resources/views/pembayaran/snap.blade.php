@extends('layouts.app')

@section('title', 'Pembayaran Pesanan #' . $p->id_pemesanan)

@push('styles')
<style>
    /* ==============================
       PAYMENT PAGE – Selaras dengan Home
    ============================== */

    .pay-page {
        min-height: calc(100vh - 220px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 16px 0 30px;
    }

    /* Latar halaman: cahaya oranye & pink lembut */
    .pay-page::before {
        content: "";
        position: fixed;
        inset: 0;
        z-index: -1;
        pointer-events: none;
        background:
            radial-gradient(620px 420px at 8% 4%,  rgba(242,140,40,0.13), transparent 70%),
            radial-gradient(560px 460px at 96% 38%, rgba(255,143,171,0.20), transparent 70%),
            radial-gradient(640px 460px at 20% 96%, rgba(255,143,171,0.14), transparent 70%),
            linear-gradient(180deg, #FFFAF8 0%, #F8F7FA 55%, #FFF1F5 100%);
    }

    .pay-wrap {
        width: 100%;
        max-width: 560px;
    }

    /* ---------- BACK LINK ---------- */

    .pay-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        padding: 8px 16px;
        border-radius: 30px;
        background: linear-gradient(135deg, #FFF0DF, #FFD3E0);
        color: #D97706;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: transform .2s, box-shadow .2s;
    }

    .pay-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(242,140,40,0.18);
        color: #D97706;
    }

    .pay-back:active { transform: scale(.96); }

    /* ---------- CARD ---------- */

    .pay-card {
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 18px 44px rgba(32,42,53,0.08);
        transition: border-color .3s;
        animation: card-in .5s cubic-bezier(.2,.8,.2,1) both;
    }

    .pay-card:hover { border-color: #F6C28E; }

    @keyframes card-in {
        from { opacity: 0; transform: translateY(16px) scale(.98); }
        to { opacity: 1; transform: none; }
    }

    /* Header */
    .pay-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 26px 30px 22px;
        background:
            radial-gradient(240px 140px at 100% 0%, rgba(255,143,171,0.18), transparent 70%),
            linear-gradient(160deg, #FFF8F4 0%, #FFE6EE 100%);
        border-bottom: 1px solid #F3E8E2;
    }

    .pay-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: white;
        color: #F28C28;
        font-size: 22px;
        box-shadow: 0 4px 12px rgba(32,42,53,0.07);
    }

    .pay-header h1 {
        margin: 0 0 4px;
        color: #202A35;
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.4px;
    }

    .pay-header p {
        margin: 0;
        color: #6B7280;
        font-size: 12px;
        font-weight: 600;
    }

    /* Body */
    .pay-body {
        padding: 24px 30px 28px;
    }

    .pay-details {
        display: grid;
        gap: 10px;
        margin-bottom: 20px;
    }

    .pay-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 13px 16px;
        border-radius: 12px;
        background: linear-gradient(135deg, #FAFAFA, #FFF8F5);
        border: 1px solid #F3F4F6;
        font-size: 13px;
    }

    .pay-row span { color: #6B7280; font-weight: 500; }
    .pay-row strong { color: #202A35; font-weight: 700; text-align: right; }

    /* Total Navy Box */
    .pay-total-box {
        padding: 20px 22px;
        border-radius: 16px;
        background:
            radial-gradient(240px 150px at 100% 0%, rgba(242,140,40,0.34), transparent 70%),
            linear-gradient(160deg, #2B3745 0%, #202A35 60%, #18202A 100%);
        margin-bottom: 22px;
    }

    .pay-total-box small {
        display: block;
        color: #CBD5E1;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .pay-total-amount {
        color: white;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.8px;
    }

    /* Button */
    .pay-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 15px 20px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #F7A04A 0%, #F5817A 55%, #EE6A93 100%);
        background-size: 200% 200%;
        background-position: 0% 50%;
        color: white;
        font: inherit;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(238,106,147,0.30);
        transition: background-position .5s ease, transform .15s, box-shadow .2s;
        position: relative;
        overflow: hidden;
    }

    .pay-btn:hover {
        background-position: 100% 50%;
        box-shadow: 0 12px 26px rgba(238,106,147,0.40);
        transform: translateY(-2px);
    }

    .pay-btn:active { transform: scale(.97); }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.45);
        transform: scale(0);
        pointer-events: none;
        animation: ripple .6s ease-out forwards;
    }

    @keyframes ripple { to { transform: scale(4); opacity: 0; } }

    .pay-note {
        margin: 16px 0 0;
        text-align: center;
        color: #9CA3AF;
        font-size: 12px;
        line-height: 1.6;
    }

    @media(max-width: 600px) {
        .pay-header { padding: 22px 20px 18px; }
        .pay-body { padding: 20px; }
        .pay-total-amount { font-size: 24px; }
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation: none !important; transition: none !important; }
    }
</style>
@endpush

@section('content')
<div class="pay-page">
    <div class="pay-wrap">

        <a href="{{ route('customer.orders') }}" class="pay-back">
            ← Kembali ke Pesanan Saya
        </a>

        <div class="pay-card">

            <div class="pay-header">
                <div class="pay-icon">💳</div>
                <div>
                    <h1>Pembayaran Pesanan #{{ $p->id_pemesanan }}</h1>
                    <p>Kode Transaksi: {{ $orderId ?? '-' }}</p>
                </div>
            </div>

            <div class="pay-body">

                <div class="pay-details">
                    <div class="pay-row">
                        <span>Kendaraan</span>
                        <strong>{{ $p->armada->nama_kendaraan ?? '-' }}</strong>
                    </div>

                    <div class="pay-row">
                        <span>Durasi Sewa</span>
                        <strong>{{ $p->durasi }} hari</strong>
                    </div>

                    <div class="pay-row">
                        <span>Metode Pembayaran</span>
                        <strong>{{ $pembayaran->metode_pembayaran ?? '-' }}</strong>
                    </div>
                </div>

                <div class="pay-total-box">
                    <small>Total Pembayaran</small>
                    <div class="pay-total-amount">
                        Rp{{ number_format($p->total_biaya, 0, ',', '.') }}
                    </div>
                </div>

                <button id="pay-button" type="button" class="pay-btn">
                    Bayar Sekarang dengan Midtrans &nbsp; →
                </button>

                <p class="pay-note">
                    Jendela pembayaran Midtrans akan terbuka otomatis. Jika tertutup, klik tombol di atas untuk membuka kembali.
                </p>

            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
(function () {
    const payButton = document.getElementById('pay-button');
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

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

    payButton.addEventListener('click', function (e) {
        if (!reduce) {
            const rect = payButton.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const r = document.createElement('span');
            r.className = 'ripple';
            r.style.width = r.style.height = size + 'px';
            r.style.left = (e.clientX - rect.left - size / 2) + 'px';
            r.style.top = (e.clientY - rect.top - size / 2) + 'px';
            payButton.appendChild(r);
            setTimeout(() => r.remove(), 650);
        }
        openSnap();
    });

    window.addEventListener('load', openSnap);
})();
</script>
@endpush
