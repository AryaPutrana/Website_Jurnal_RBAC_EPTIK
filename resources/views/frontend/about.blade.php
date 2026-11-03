
@extends('layouts.public')

@section('title', 'Tentang')

@section('content')

<style>
    /* ========================================
       ABOUT PAGE
    ======================================== */

    .about-page {
        width: 100%;
        overflow-x: hidden;
    }

    .about-header {
        background: #f8f9fa;
        padding: 50px 0;
    }

    .about-header h1 {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 12px;
    }

    .about-header p {
        margin-bottom: 0;
        font-size: 1.05rem;
    }

    .about-container {
        max-width: 1050px;
        width: 100%;
        margin: 0 auto;
    }

    /* Card Utama */
    .about-page .card {
        height: auto;
        min-height: 0;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .about-page .card-body {
        padding: 28px;
    }

    .about-page .card h3,
    .about-page .card h4 {
        font-weight: 600;
    }

    /* Paragraf */
    .about-description {
        color: #444;
        text-align: justify;
        line-height: 1.9;
        font-size: 1rem;
        margin-bottom: 18px;
    }

    .about-description:last-child {
        margin-bottom: 0;
    }

    /* Visi dan Misi */
    .about-subtitle {
        color: #495057;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .about-mission-list {
        padding-left: 22px;
        line-height: 2;
        margin-bottom: 0;
    }

    .about-mission-list li {
        padding-left: 5px;
        margin-bottom: 5px;
    }

    /* Fokus Publikasi */
    .focus-card {
        height: 100% !important;
        min-height: 150px !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .focus-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .focus-card .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 24px 18px;
        text-align: center;
    }

    .focus-card h6 {
        font-weight: 600;
        margin-top: 15px;
        margin-bottom: 8px;
    }

    .focus-card p {
        margin-bottom: 0;
        line-height: 1.6;
    }

    /* Kontak Pengelola */
    .contact-card .card-header {
        background-color: var(--primary-color);
        padding: 16px 24px;
        border-bottom: none;
    }

    .contact-card .card-header h5 {
        font-weight: 600;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        height: 100%;
        padding: 12px 0;
    }

    .contact-item i {
        color: var(--primary-color);
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .contact-item strong {
        display: inline-block;
        margin-bottom: 5px;
    }

    .contact-item a {
        text-decoration: none;
    }

    .contact-item a:hover {
        text-decoration: underline;
    }

    .contact-item p {
        margin-bottom: 0;
        line-height: 1.8;
        color: #555;
    }

    /* CTA */
    .about-cta {
        padding: 15px 0 30px;
    }

    .about-cta h4 {
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .about-header {
            padding: 35px 15px;
        }

        .about-header h1 {
            font-size: 1.6rem;
        }

        .about-header p {
            font-size: 0.95rem;
        }

        .about-page .card-body {
            padding: 20px;
        }

        .focus-card {
            min-height: 140px !important;
        }

        .contact-card .card-header {
            padding: 15px 20px;
        }
    }

    @media (max-width: 576px) {
        .about-header h1 {
            font-size: 1.4rem;
        }

        .about-description {
            font-size: 0.95rem;
        }

        .about-page .card-body {
            padding: 18px;
        }

        .about-cta h4 {
            font-size: 1.15rem;
        }
    }
</style>

<div class="about-page">

    <!-- ========================================
         PAGE HEADER
    ======================================== -->
    <section class="about-header">
        <div class="container text-center">

            <h1>
                <i class="bi bi-info-circle"></i>
                Tentang Jurnal Ilmiah
            </h1>

            <p class="lead text-muted">
                Platform Publikasi Artikel Penelitian Berkualitas
            </p>

        </div>
    </section>


    <!-- ========================================
         ABOUT CONTENT
    ======================================== -->
    <section class="container my-5 about-container">

        <div class="row justify-content-center">
            <div class="col-12">

                <!-- INTRODUCTION -->
                <div class="card card-article mb-4">
                    <div class="card-body">

                        <h3 class="text-primary mb-4">
                            <i class="bi bi-journal-check"></i>
                            Tentang Kami
                        </h3>

                        <p class="about-description">
                            <strong>Jurnal Ilmiah</strong> adalah platform publikasi
                            artikel penelitian yang menyediakan wadah bagi peneliti,
                            dosen, dan mahasiswa untuk mempublikasikan hasil penelitian
                            mereka secara digital. Website ini dirancang untuk
                            memudahkan pembaca dalam menemukan dan membaca artikel
                            penelitian tanpa harus mencari dokumen secara manual.
                        </p>

                        <p class="about-description">
                            Sistem dikembangkan dengan konsep sederhana, memiliki
                            tampilan yang responsif, serta menyediakan fitur
                            pengelolaan artikel yang dapat dilakukan oleh administrator.
                            Website ini juga dapat digunakan sebagai media publikasi
                            hasil penelitian mahasiswa, khususnya artikel mengenai
                            teknologi informasi, keamanan sistem, dan etika profesi.
                        </p>

                    </div>
                </div>


                <!-- VISION & MISSION -->
                <div class="card card-article mb-4">
                    <div class="card-body">

                        <h4 class="text-primary mb-4">
                            <i class="bi bi-bullseye"></i>
                            Visi & Misi
                        </h4>

                        <!-- Visi -->
                        <h5 class="about-subtitle">
                            Visi
                        </h5>

                        <p class="about-description">
                            Menjadi platform publikasi artikel ilmiah terpercaya
                            yang mendukung perkembangan ilmu pengetahuan dan teknologi,
                            khususnya di bidang Teknologi Informasi.
                        </p>

                        <!-- Misi -->
                        <h5 class="about-subtitle mt-4">
                            Misi
                        </h5>

                        <ul class="about-mission-list">
                            <li>
                                Menyediakan tempat publikasi artikel ilmiah secara
                                online yang mudah diakses.
                            </li>

                            <li>
                                Memudahkan pembaca dalam mencari dan membaca
                                artikel penelitian berkualitas.
                            </li>

                            <li>
                                Menyediakan fitur unduh artikel dalam format PDF
                                untuk kemudahan dokumentasi.
                            </li>

                            <li>
                                Memudahkan administrator dalam mengelola dan
                                memoderasi artikel yang dipublikasikan.
                            </li>

                            <li>
                                Menampilkan informasi penulis dan identitas
                                publikasi secara transparan.
                            </li>
                        </ul>

                    </div>
                </div>


                <!-- FOCUS AREAS -->
                <div class="card card-article mb-4">
                    <div class="card-body">

                        <h4 class="text-primary mb-4">
                            <i class="bi bi-bookmark-star"></i>
                            Fokus Publikasi
                        </h4>

                        <p class="about-description">
                            Jurnal Ilmiah berfokus pada publikasi artikel penelitian
                            dalam bidang-bidang berikut:
                        </p>

                        <div class="row g-3 mt-2">

                            <!-- Teknologi Informasi -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card focus-card border-primary">
                                    <div class="card-body">

                                        <i class="bi bi-cpu text-primary"
                                           style="font-size: 2.5rem;"></i>

                                        <h6 class="text-primary">
                                            Teknologi Informasi
                                        </h6>

                                        <p class="small text-muted">
                                            Sistem komputer, perkembangan teknologi digital
                                        </p>

                                    </div>
                                </div>
                            </div>


                            <!-- Keamanan Sistem -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card focus-card border-primary">
                                    <div class="card-body">

                                        <i class="bi bi-shield-lock text-primary"
                                           style="font-size: 2.5rem;"></i>

                                        <h6 class="text-primary">
                                            Keamanan Sistem
                                        </h6>

                                        <p class="small text-muted">
                                            Cybersecurity, keamanan jaringan, proteksi data
                                        </p>

                                    </div>
                                </div>
                            </div>


                            <!-- Etika Profesi -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card focus-card border-primary">
                                    <div class="card-body">

                                        <i class="bi bi-people text-primary"
                                           style="font-size: 2.5rem;"></i>

                                        <h6 class="text-primary">
                                            Etika Profesi
                                        </h6>

                                        <p class="small text-muted">
                                            Tanggung jawab profesional, kode etik IT
                                        </p>

                                    </div>
                                </div>
                            </div>


                            <!-- Rekayasa Perangkat Lunak -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card focus-card border-primary">
                                    <div class="card-body">

                                        <i class="bi bi-code-slash text-primary"
                                           style="font-size: 2.5rem;"></i>

                                        <h6 class="text-primary">
                                            Rekayasa Perangkat Lunak
                                        </h6>

                                        <p class="small text-muted">
                                            Pengembangan software, metodologi, best practices
                                        </p>

                                    </div>
                                </div>
                            </div>


                            <!-- Basis Data -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card focus-card border-primary">
                                    <div class="card-body">

                                        <i class="bi bi-database text-primary"
                                           style="font-size: 2.5rem;"></i>

                                        <h6 class="text-primary">
                                            Basis Data
                                        </h6>

                                        <p class="small text-muted">
                                            Database management, optimasi query
                                        </p>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


                <!-- CONTACT INFORMATION -->
                <div class="card card-article contact-card border-primary mb-4">

                    <div class="card-header text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-envelope"></i>
                            Kontak Pengelola
                        </h5>
                    </div>

                    <div class="card-body">

                        <p class="about-description">
                            Untuk informasi lebih lanjut, pertanyaan, atau pengiriman
                            artikel, silakan hubungi kami melalui:
                        </p>

                        <div class="row g-3 mt-3">

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="contact-item">

                                    <i class="bi bi-envelope-fill"></i>

                                    <div>
                                        <strong>Email</strong>

                                        <p>
                                            <a href="mailto:info@jurnal.com">
                                                info@jurnal.com
                                            </a>
                                            <br>

                                            <a href="mailto:editor@jurnal.com">
                                                editor@jurnal.com
                                            </a>
                                        </p>
                                    </div>

                                </div>
                            </div>


                            <!-- Telepon -->
                            <div class="col-md-6">
                                <div class="contact-item">

                                    <i class="bi bi-telephone-fill"></i>

                                    <div>
                                        <strong>Telepon</strong>

                                        <p>
                                            (021) 1234-5678
                                            <br>
                                            (021) 8765-4321
                                        </p>
                                    </div>

                                </div>
                            </div>


                            <!-- Alamat -->
                            <div class="col-md-6">
                                <div class="contact-item">

                                    <i class="bi bi-geo-alt-fill"></i>

                                    <div>
                                        <strong>Alamat</strong>

                                        <p>
                                            Jl. Pendidikan No. 123
                                            <br>
                                            Jakarta Pusat, DKI Jakarta
                                            <br>
                                            Indonesia 10110
                                        </p>
                                    </div>

                                </div>
                            </div>


                            <!-- Jam Operasional -->
                            <div class="col-md-6">
                                <div class="contact-item">

                                    <i class="bi bi-clock-fill"></i>

                                    <div>
                                        <strong>Jam Operasional</strong>

                                        <p>
                                            Senin - Jumat: 08:00 - 17:00 WIB
                                            <br>
                                            Sabtu: 08:00 - 13:00 WIB
                                            <br>
                                            Minggu: Tutup
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>


                <!-- CALL TO ACTION -->
                <div class="text-center about-cta mt-5">

                    <h4 class="mb-4">
                        Tertarik Membaca Artikel Kami?
                    </h4>

                    <a href="{{ route('articles.index') }}"
                       class="btn btn-primary-custom btn-lg px-5">

                        <i class="bi bi-book"></i>
                        Lihat Semua Artikel

                    </a>

                </div>

            </div>
        </div>

    </section>

</div>

@endsection
