<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] ?? 'Oficina' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #e63946; }
        body { font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #1a1a2e !important; }
        .navbar-brand, .nav-link { color: #fff !important; }
        .nav-link:hover { color: var(--primary) !important; }
        #hero { position: relative; background: #1a1a2e; color: #fff; min-height: 500px; display: flex; align-items: center; }
        #hero .carousel { width: 100%; }
        #hero .carousel-item img { width: 100%; height: 500px; object-fit: cover; opacity: 0.5; }
        #hero .hero-text { position: absolute; z-index: 10; text-align: center; width: 100%; }
        #hero h1 { font-size: 3rem; font-weight: 800; }
        #hero p { font-size: 1.3rem; }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: #c1121f; border-color: #c1121f; }
        .section-title { font-weight: 700; position: relative; display: inline-block; margin-bottom: 2rem; }
        .section-title::after { content: ''; display: block; width: 60px; height: 4px; background: var(--primary); margin-top: 8px; }
        .service-card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,.08); transition: transform .2s; }
        .service-card:hover { transform: translateY(-5px); }
        .service-icon { font-size: 2.5rem; }
        #about { background: #f8f9fa; }
        #contact { background: #1a1a2e; color: #fff; }
        #contact a { color: var(--primary); text-decoration: none; }
        footer { background: #111; color: #aaa; padding: 1rem 0; text-align: center; font-size: .9rem; }
        .whatsapp-float { position: fixed; bottom: 30px; right: 30px; z-index: 999; }
        .whatsapp-float a { background: #25d366; color: #fff; border-radius: 50px; padding: 12px 20px; font-size: 1.1rem; text-decoration: none; box-shadow: 0 4px 15px rgba(0,0,0,.3); display: flex; align-items: center; gap: 8px; }
        .contact-link { display: flex; flex-direction: column; align-items: center; gap: 8px; color: #fff; text-decoration: none; padding: 20px 28px; border-radius: 12px; background: rgba(255,255,255,.07); transition: background .2s; min-width: 100px; }
        .contact-link:hover { background: rgba(255,255,255,.15); color: #fff; }
        .contact-link span { font-size: .9rem; font-weight: 500; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="#">
            @if(!empty($settings['logo']))
            <img src="{{ Storage::url($settings['logo']) }}" height="40" style="object-fit:contain;max-width:160px">
            @endif
            {{ $settings['site_name'] ?? 'Oficina' }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon" style="filter:invert(1)"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#hero">Início</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Serviços</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Sobre</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contato</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero / Banners -->
<section id="hero">
    @if($banners->count())
    <div id="carouselBanners" class="carousel slide w-100" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($banners as $i => $banner)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}">
                @if($banner->title)
                <div class="carousel-caption">
                    <h2 class="fw-bold">{{ $banner->title }}</h2>
                    <p>{{ $banner->subtitle }}</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @if($banners->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselBanners" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselBanners" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
        @endif
    </div>
    @endif
    <div class="hero-text px-3">
        <h1>{{ $settings['hero_title'] ?? '' }}</h1>
        <p>{{ $settings['hero_subtitle'] ?? '' }}</p>
    </div>
</section>

<!-- Serviços -->
<section id="services" class="py-5">
    <div class="container">
        <h2 class="section-title">Nossos Serviços</h2>
        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-md-3 col-sm-6">
                <div class="card service-card p-4 h-100 text-center">
                    <div class="service-icon mb-3">{{ $service->icon }}</div>
                    <h5 class="fw-bold">{{ $service->title }}</h5>
                    <p class="text-muted mb-0">{{ $service->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Sobre -->
<section id="about" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="section-title">Sobre Nós</h2>
                <p class="lead">{{ $settings['about_text'] ?? '' }}</p>
                @if(!empty($settings['address']))
                <p>📍 {{ $settings['address'] }}</p>
                @endif
                @if(!empty($settings['phone']))
                <p>📞 {{ $settings['phone'] }}</p>
                @endif
            </div>
            <div class="col-md-6 text-center">
                <span style="font-size:8rem">🔧</span>
            </div>
        </div>
    </div>
</section>

<!-- Contato -->
<section id="contact" class="py-5">
    <div class="container text-center">
        <h2 class="section-title" style="color:#fff">Fale Conosco</h2>
        <div class="d-flex justify-content-center gap-4 flex-wrap mt-4">
            @if(!empty($settings['whatsapp']))
            <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" class="contact-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#25d366" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                <span>WhatsApp</span>
            </a>
            @endif
            @if(!empty($settings['facebook']))
            <a href="{{ $settings['facebook'] }}" target="_blank" class="contact-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#1877f2" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                <span>Facebook</span>
            </a>
            @endif
            @if(!empty($settings['instagram']))
            <a href="{{ $settings['instagram'] }}" target="_blank" class="contact-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#e1306c" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                <span>Instagram</span>
            </a>
            @endif
        </div>
        @if(!empty($settings['address']))
        <p class="mt-4 text-white-50">📍 {{ $settings['address'] }}</p>
        @endif
    </div>
</section>

<footer>
    <p class="mb-0">© {{ date('Y') }} {{ $settings['site_name'] ?? 'Oficina' }}. Todos os direitos reservados.</p>
</footer>

@if(!empty($settings['whatsapp']))
<div class="whatsapp-float">
    <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank">💬 WhatsApp</a>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
