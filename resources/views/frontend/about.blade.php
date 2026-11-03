@extends('layouts.public')

@section('title', 'Tentang')

@section('content')
<!-- Page Header -->
<section class="bg-light py-5">
    <div class="container text-center">
        <h1 style="color: var(--primary-color); font-weight: 700;">
            <i class="bi bi-info-circle"></i> Tentang Jurnal Ilmiah
        </h1>
        <p class="lead text-muted">Platform Publikasi Artikel Penelitian Berkualitas</p>
    </div>
</section>

<!-- About Content -->
<section class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Introduction -->
            <div class="card card-article mb-4">
                <div class="card-body">
                    <h3 class="text-primary mb-4">
                        <i class="bi bi-journal-check"></i> Tentang Kami
                    </h3>
                    <p style="text-align: justify; line-height: 1.8;">
                        <strong>Jurnal Ilmiah</strong> adalah platform publikasi artikel penelitian yang menyediakan wadah 
                        bagi peneliti, dosen, dan mahasiswa untuk mempublikasikan hasil penelitian mereka secara digital. 
                        Website ini dirancang untuk memudahkan pembaca dalam menemukan dan membaca artikel penelitian 
                        tanpa harus mencari dokumen secara manual.
                    </p>
                    <p style="text-align: justify; line-height: 1.8;">
                        Sistem dikembangkan dengan konsep sederhana, memiliki tampilan yang responsif, serta menyediakan 
                        fitur pengelolaan artikel yang dapat dilakukan oleh administrator. Website ini juga dapat digunakan 
                        sebagai media publikasi hasil penelitian mahasiswa, khususnya artikel mengenai teknologi informasi, 
                        keamanan sistem, dan etika profesi.
                    </p>
                </div>
            </div>

            <!-- Vision & Mission -->
            <div class="card card-article mb-4">
                <div class="card-body">
                    <h4 class="text-primary mb-4">
                        <i class="bi bi-bullseye"></i> Visi & Misi
                    </h4>
                    
                    <h5 class="text-secondary mb-3">Visi</h5>
                    <p style="text-align: justify; line-height: 1.8;">
                        Menjadi platform publikasi artikel ilmiah terpercaya yang mendukung perkembangan ilmu pengetahuan 
                        dan teknologi, khususnya di bidang Teknologi Informasi.
                    </p>

                    <h5 class="text-secondary mb-3 mt-4">Misi</h5>
                    <ul style="line-height: 2;">
                        <li>Menyediakan tempat publikasi artikel ilmiah secara online yang mudah diakses.</li>
                        <li>Memudahkan pembaca dalam mencari dan membaca artikel penelitian berkualitas.</li>
                        <li>Menyediakan fitur unduh artikel dalam format PDF untuk kemudahan dokumentasi.</li>
                        <li>Memudahkan administrator dalam mengelola dan memoderasi artikel yang dipublikasikan.</li>
                        <li>Menampilkan informasi penulis dan identitas publikasi secara transparan.</li>
                    </ul>
                </div>
            </div>

            <!-- Focus Areas -->
            <div class="card card-article mb-4">
                <div class="card-body">
                    <h4 class="text-primary mb-4">
                        <i class="bi bi-bookmark-star"></i> Fokus Publikasi
                    </h4>
                    <p style="text-align: justify; line-height: 1.8;">
                        Jurnal Ilmiah berfokus pada publikasi artikel penelitian dalam bidang-bidang berikut:
                    </p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-cpu text-primary" style="font-size: 2.5rem;"></i>
                                    <h6 class="mt-3 text-primary">Teknologi Informasi</h6>
                                    <p class="small text-muted">Sistem komputer, perkembangan teknologi digital</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-shield-lock text-primary" style="font-size: 2.5rem;"></i>
                                    <h6 class="mt-3 text-primary">Keamanan Sistem</h6>
                                    <p class="small text-muted">Cybersecurity, keamanan jaringan, proteksi data</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-people text-primary" style="font-size: 2.5rem;"></i>
                                    <h6 class="mt-3 text-primary">Etika Profesi</h6>
                                    <p class="small text-muted">Tanggung jawab profesional, kode etik IT</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-code-slash text-primary" style="font-size: 2.5rem;"></i>
                                    <h6 class="mt-3 text-primary">Rekayasa Perangkat Lunak</h6>
                                    <p class="small text-muted">Pengembangan software, metodologi, best practices</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-database text-primary" style="font-size: 2.5rem;"></i>
                                    <h6 class="mt-3 text-primary">Basis Data</h6>
                                    <p class="small text-muted">Database management, optimasi query</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card card-article border-primary mb-4">
                <div class="card-header text-white" style="background-color: var(--primary-color);">
                    <h5 class="mb-0"><i class="bi bi-envelope"></i> Kontak Pengelola</h5>
                </div>
                <div class="card-body">
                    <p style="text-align: justify; line-height: 1.8;">
                        Untuk informasi lebih lanjut, pertanyaan, atau pengiriman artikel, silakan hubungi kami melalui:
                    </p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-envelope-fill text-primary me-3" style="font-size: 1.5rem;"></i>
                                <div>
                                    <strong>Email</strong><br>
                                    <a href="mailto:info@jurnal.com">info@jurnal.com</a><br>
                                    <a href="mailto:editor@jurnal.com">editor@jurnal.com</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-telephone-fill text-primary me-3" style="font-size: 1.5rem;"></i>
                                <div>
                                    <strong>Telepon</strong><br>
                                    (021) 1234-5678<br>
                                    (021) 8765-4321
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-geo-alt-fill text-primary me-3" style="font-size: 1.5rem;"></i>
                                <div>
                                    <strong>Alamat</strong><br>
                                    Jl. Pendidikan No. 123<br>
                                    Jakarta Pusat, DKI Jakarta<br>
                                    Indonesia 10110
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-clock-fill text-primary me-3" style="font-size: 1.5rem;"></i>
                                <div>
                                    <strong>Jam Operasional</strong><br>
                                    Senin - Jumat: 08:00 - 17:00 WIB<br>
                                    Sabtu: 08:00 - 13:00 WIB<br>
                                    Minggu: Tutup
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center mt-5">
                <h4 class="mb-4">Tertarik Membaca Artikel Kami?</h4>
                <a href="{{ route('articles.index') }}" class="btn btn-primary-custom btn-lg px-5">
                    <i class="bi bi-book"></i> Lihat Semua Artikel
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
