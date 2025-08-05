@extends('layouts.app')

@section('content')
<style>
    .hero-section {
        background: url('/images/kota-malang-bg.jpg') no-repeat center center;
        background-size: cover;
        position: relative;
        padding: 100px 20px 60px;
    }

    .hero-overlay {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 16px;
        padding: 40px 30px;
        max-width: 700px;
        margin: 0 auto;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #005EB8;
    }

    .hero-paragraph {
        font-size: 1rem;
        margin-top: 15px;
        color: #333;
        line-height: 1.6;
    }

    .singa-img {
        position: absolute;
        bottom: -30px;
        right: 40px;
        width: 130px;
        z-index: 2;
    }

    .pattern-section {
        background: url('/images/motif-batik.png') repeat;
        padding: 80px 20px;
    }

    .blue-box {
        background-color: #005EB8;
        border-radius: 20px;
        padding: 50px;
        max-width: 900px;
        margin: 0 auto;
        color: white;
    }

    .footer-section {
        background-color: #005EB8;
        color: white;
        padding: 40px 20px;
    }

    .footer-section a {
        color: white;
        text-decoration: none;
        transition: 0.2s;
    }

    .footer-section a:hover {
        text-decoration: underline;
    }

    .footer-icons i {
        margin-right: 10px;
        font-size: 20px;
    }
</style>

<div class="hero-section text-center position-relative">
    <div class="hero-overlay">
        <h1 class="hero-title">Selamat Datang<br>di Bapenda Kota Malang</h1>
        <p class="hero-paragraph mt-3">
            Badan Pendapatan Daerah (Bapenda) Kota Malang bertugas membantu Wali Kota dalam merumuskan dan melaksanakan
            kebijakan di bidang pendapatan daerah, terutama pengelolaan pajak dan retribusi, guna meningkatkan
            penerimaan asli daerah.
        </p>
    </div>
    <img src="/images/singa.png" alt="Singa Arema" class="singa-img">
</div>

<div class="pattern-section text-center">
    <div class="blue-box">
        <h4 class="mb-3 fw-bold">Website Kuisioner Pelayanan Publik</h4>
        <p>Silakan melanjutkan untuk mengisi data diri dan kuisioner sesuai pengalaman Anda.</p>
    </div>
</div>

<div class="footer-section">
    <div class="row text-center text-md-start">
        <div class="col-md-4 mb-3">
            <h5>LFT</h5>
            <p>+1 (0639) 547-12-97</p>
            <p>support@lft-agency</p>
        </div>
        <div class="col-md-4 mb-3">
            <h5>Quick Links</h5>
            <ul class="list-unstyled">
                <li><a href="#">Product</a></li>
                <li><a href="#">Information</a></li>
                <li><a href="#">Company</a></li>
                <li><a href="#">Lft Media</a></li>
            </ul>
        </div>
        <div class="col-md-4 mb-3">
            <h5>Subscribe</h5>
            <form class="d-flex">
                <input type="email" class="form-control me-2" placeholder="Get product updates">
                <button class="btn btn-light">→</button>
            </form>
            <div class="footer-icons mt-3">
                <i class="bi bi-facebook"></i>
                <i class="bi bi-instagram"></i>
                <i class="bi bi-twitter"></i>
            </div>
        </div>
    </div>
    <hr class="border-light">
    <div class="text-center small">© 2025 Lft Media. All rights reserved.</div>
</div>
@endsection
