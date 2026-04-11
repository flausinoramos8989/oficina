<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] ?? 'Oficina' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #e63946;
            --dark: #111827;
            --dark2: #1f2937;
            --gray: #f3f4f6;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; margin: 0; color: #333; }

        /* TOP BAR */
        .topbar {
            background: var(--primary);
            color: #fff;
            font-size: .82rem;
            padding: 6px 0;
        }
        .topbar a { color: #fff; text-decoration: none; }
        .topbar a:hover { text-decoration: underline; }

        /* NAVBAR */
        .navbar {
            background: var(--dark) !important;
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,.4);
        }
        .navbar-brand img { height: 48px; object-fit: contain; max-width: 160px; }
        .navbar-brand span { color: #fff; font-weight: 900; font-size: 1.3rem; letter-spacing: 1px; }
        .nav-link {
            color: #d1d5db !important;
            font-weight: 600;
            font-size: .9rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 22px 16px !important;
            transition: color .2s, border-bottom .2s;
            border-bottom: 3px solid transparent;
        }
        .nav-link:hover, .nav-link.active {
            color: #fff !important;
            border-bottom-color: var(--primary);
        }
        .navbar-toggler { border: none; }
        .navbar-toggler-icon { filter: invert(1); }

        /* HERO */
        #hero { position: relative; overflow: hidden; }
        #hero .carousel, #hero .carousel-inner, #hero .carousel-item { height: 580px; }
        .carousel-item img {
            width: 100%; height: 100%;
            object-fit: cover;
            filter: brightness(.45);
        }
        .hero-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            text-align: center;
            padding: 0 20px;
            pointer-events: none;
        }
        .hero-overlay > div { pointer-events: all; }
        .hero-overlay h1 {
            font-size: clamp(2rem, 5vw, 3.8rem);
            font-weight: 900;
            color: #fff;
            text-shadow: 0 2px 12px rgba(0,0,0,.6);
            line-height: 1.15;
        }
        .hero-overlay p {
            font-size: clamp(1rem, 2vw, 1.3rem);
            color: #e5e7eb;
            margin-top: 1rem;
            text-shadow: 0 1px 6px rgba(0,0,0,.5);
        }
        .hero-overlay .btn-hero {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 14px 36px;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            margin-top: 1.5rem;
            transition: background .2s, transform .2s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .hero-overlay .btn-hero:hover { background: #c1121f; transform: translateY(-2px); }
        .carousel-control-prev, .carousel-control-next {
            width: 50px;
            opacity: .7;
        }
        .carousel-indicators [data-bs-target] {
            width: 10px; height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,.6);
        }
        .carousel-indicators .active { background: var(--primary); }

        /* DIFERENCIAIS */
        #diferenciais {
            background: var(--primary);
            padding: 0;
        }
        .diferencial-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 22px 24px;
            color: #fff;
            border-right: 1px solid rgba(255,255,255,.2);
        }
        .diferencial-item:last-child { border-right: none; }
        .diferencial-item i { font-size: 1.8rem; flex-shrink: 0; }
        .diferencial-item strong { display: block; font-size: .95rem; font-weight: 700; }
        .diferencial-item span { font-size: .82rem; opacity: .9; }

        /* SERVIÇOS */
        #services { padding: 70px 0; background: var(--gray); }
        .section-header { text-align: center; margin-bottom: 50px; }
        .section-header .badge-label {
            background: var(--primary);
            color: #fff;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 12px;
        }
        .section-header h2 {
            font-size: 2.2rem;
            font-weight: 900;
            color: var(--dark);
            margin: 0;
        }
        .section-header p { color: #6b7280; margin-top: 10px; font-size: .95rem; }
        .service-card {
            background: #fff;
            border-radius: 10px;
            padding: 36px 24px;
            text-align: center;
            box-shadow: 0 2px 16px rgba(0,0,0,.07);
            transition: transform .25s, box-shadow .25s;
            height: 100%;
            border-top: 4px solid transparent;
        }
        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 30px rgba(0,0,0,.12);
            border-top-color: var(--primary);
        }
        .service-icon {
            width: 70px; height: 70px;
            background: #fef2f2;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 18px;
            font-size: 1.8rem;
            color: var(--primary);
        }
        .service-card h5 { font-weight: 700; font-size: 1rem; color: var(--dark); margin-bottom: 8px; }
        .service-card p { color: #6b7280; font-size: .88rem; margin: 0; }

        /* SOBRE */
        #about { padding: 80px 0; background: #fff; }
        #about h2 { font-size: 2rem; font-weight: 900; color: var(--dark); margin-bottom: 16px; }
        #about .about-text { color: #6b7280; font-size: 1rem; line-height: 1.9; margin: 20px 0 0; }
        .about-divider { width: 50px; height: 4px; background: var(--primary); border-radius: 2px; margin: 16px auto 0; }
        .about-info { display: flex; align-items: flex-start; justify-content: center; gap: 8px; margin-top: 12px; color: #6b7280; font-size: .88rem; line-height: 1.5; }
        .about-info i { color: var(--primary); font-size: .9rem; margin-top: 3px; flex-shrink: 0; }
        .btn-about {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 12px 32px;
            font-weight: 700;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            margin-top: 28px;
            font-size: .88rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background .2s;
        }
        .btn-about:hover { background: #c1121f; color: #fff; }

        /* CONTATO */
        #contact { background: var(--dark); padding: 70px 0; }
        #contact .section-header h2 { color: #fff; }
        #contact .section-header p { color: #9ca3af; }
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            background: rgba(255,255,255,.05);
            border-radius: 10px;
            padding: 18px 16px;
            text-decoration: none;
            transition: background .2s;
        }
        .contact-item:hover { background: rgba(255,255,255,.1); }
        .contact-item .icon-wrap {
            width: 44px; height: 44px;
            border-radius: 10px;
            background: rgba(255,255,255,.07);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 1.2rem;
        }
        .contact-item .icon-wrap.wa { color: #25d366; }
        .contact-item .icon-wrap.ig { color: #e1306c; }
        .contact-item .icon-wrap.ph { color: var(--primary); }
        .contact-item .icon-wrap.ad { color: #facc15; }
        .contact-item strong { display: block; color: #f9fafb; font-size: .88rem; font-weight: 700; }
        .contact-item span { color: #9ca3af; font-size: .82rem; line-height: 1.5; display: block; margin-top: 2px; }
        @media (max-width: 576px) {
            .contact-grid { grid-template-columns: 1fr; }
        }

        /* FOOTER */
        footer {
            background: #0a0f1a;
            color: #6b7280;
            text-align: center;
            padding: 20px 0;
            font-size: .85rem;
        }
        footer strong { color: #d1d5db; }

        /* WHATSAPP FLOAT */
        .whatsapp-float {
            position: fixed;
            bottom: 28px; right: 28px;
            z-index: 9999;
        }
        .whatsapp-float a {
            background: #25d366;
            color: #fff;
            border-radius: 50px;
            padding: 13px 22px;
            font-size: .95rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 20px rgba(37,211,102,.4);
            display: flex; align-items: center; gap: 8px;
            transition: transform .2s, box-shadow .2s;
        }
        .whatsapp-float a:hover { transform: scale(1.05); box-shadow: 0 6px 24px rgba(37,211,102,.5); }

        @media (max-width: 768px) {
            #hero .carousel, #hero .carousel-inner, #hero .carousel-item { height: 380px; }
            .diferencial-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,.2); }
            .diferencial-item:last-child { border-bottom: none; }
        }
    </style>
</head>
<body>

{{-- TOP BAR --}}
@if(!empty($settings['phone']) || !empty($settings['address']))
<div class="topbar d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex gap-4">
            @if(!empty($settings['phone']))
            <span><i class="fa fa-phone me-1"></i> {{ $settings['phone'] }}</span>
            @endif
            @if(!empty($settings['address']))
            <span><i class="fa fa-map-marker-alt me-1"></i> {{ $settings['address'] }}</span>
            @endif
        </div>
        <div class="d-flex gap-3">
            @if(!empty($settings['whatsapp']))
            <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank"><i class="fab fa-whatsapp me-1"></i>WhatsApp</a>
            @endif
            @if(!empty($settings['instagram']))
            <a href="{{ $settings['instagram'] }}" target="_blank"><i class="fab fa-instagram me-1"></i>Instagram</a>
            @endif
        </div>
    </div>
</div>
@endif

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            @if(!empty($settings['logo']))
                <img src="{{ Storage::url($settings['logo']) }}" alt="Logo">
            @endif
            <span>{{ $settings['site_name'] ?? 'Oficina' }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#hero">Início</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Serviços</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Sobre</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contato</a></li>
                @if(!empty($settings['whatsapp']))
                <li class="nav-item ms-lg-3 d-flex align-items-center">
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank"
                       style="background:var(--primary);color:#fff;padding:8px 18px;border-radius:4px;font-size:.85rem;font-weight:700;text-decoration:none;text-transform:uppercase;letter-spacing:.5px">
                        <i class="fab fa-whatsapp me-1"></i> Orçamento
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section id="hero">
    @if($banners->count())
    <div id="carouselBanners" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            @foreach($banners as $i => $banner)
            <button type="button" data-bs-target="#carouselBanners" data-bs-slide-to="{{ $i }}" {{ $i === 0 ? 'class=active' : '' }}></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($banners as $i => $banner)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}">
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
    @else
    <div style="height:580px;background:linear-gradient(135deg,#111827,#1f2937);width:100%"></div>
    @endif

    <div class="hero-overlay">
        <div>
            <h1>{!! nl2br(e($settings['hero_title'] ?? 'Qualidade e Confiança\npara o seu Veículo')) !!}</h1>
            @if(!empty($settings['hero_subtitle']))
            <p>{{ $settings['hero_subtitle'] }}</p>
            @endif
            @if(!empty($settings['whatsapp']))
            <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" class="btn-hero">
                <i class="fab fa-whatsapp me-2"></i>Solicitar Orçamento
            </a>
            @endif
        </div>
    </div>
</section>

{{-- DIFERENCIAIS --}}
<section id="diferenciais">
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-md-3 col-6">
                <div class="diferencial-item">
                    <i class="fas fa-tools"></i>
                    <div><strong>Equipe Especializada</strong><span>Profissionais qualificados</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="diferencial-item">
                    <i class="fas fa-shield-alt"></i>
                    <div><strong>Garantia nos Serviços</strong><span>Trabalho com qualidade</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="diferencial-item">
                    <i class="fas fa-clock"></i>
                    <div><strong>Atendimento Rápido</strong><span>Agilidade no diagnóstico</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="diferencial-item">
                    <i class="fas fa-dollar-sign"></i>
                    <div><strong>Preço Justo</strong><span>Orçamento sem surpresas</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SERVIÇOS --}}
<section id="services">
    <div class="container">
        <div class="section-header">
            <span class="badge-label">O que fazemos</span>
            <h2>Nossos Serviços</h2>
            <p>Soluções completas para o seu veículo com qualidade e agilidade</p>
        </div>
        @if($services->count())
        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="service-card">
                    <div class="service-icon">{{ $service->icon }}</div>
                    <h5>{{ $service->title }}</h5>
                    <p>{{ $service->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- SOBRE --}}
<section id="about">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9 text-center">
                <span class="badge-label">Quem somos</span>
                <h2 class="mt-3">Sobre Nós</h2>
                <div class="about-divider"></div>
                @if(!empty($settings['about_text']))
                <p class="about-text">{{ $settings['about_text'] }}</p>
                @endif
                @if(!empty($settings['address']))
                <div class="about-info"><i class="fas fa-map-marker-alt"></i> <span>{{ $settings['address'] }}</span></div>
                @endif
                @if(!empty($settings['phone']))
                <div class="about-info"><i class="fas fa-phone"></i> <span>{{ $settings['phone'] }}</span></div>
                @endif
                @if(!empty($settings['whatsapp']))
                <div>
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" class="btn-about">
                        <i class="fab fa-whatsapp me-2"></i>Fale Conosco
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- CONTATO --}}
<section id="contact">
    <div class="container">
        <div class="section-header">
            <span class="badge-label">Atendimento</span>
            <h2>Fale Conosco</h2>
            <p>Escolha o canal de atendimento de sua preferência</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="contact-grid">
                    @if(!empty($settings['whatsapp']))
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" class="contact-item">
                        <div class="icon-wrap wa"><i class="fab fa-whatsapp"></i></div>
                        <div><strong>WhatsApp</strong><span>{{ $settings['whatsapp'] }}</span></div>
                    </a>
                    @endif
                    @if(!empty($settings['phone']))
                    <a href="tel:{{ $settings['phone'] }}" class="contact-item">
                        <div class="icon-wrap ph"><i class="fas fa-phone"></i></div>
                        <div><strong>Telefone</strong><span>{{ $settings['phone'] }}</span></div>
                    </a>
                    @endif
                    @if(!empty($settings['address']))
                    <div class="contact-item">
                        <div class="icon-wrap ad"><i class="fas fa-map-marker-alt"></i></div>
                        <div><strong>Endereço</strong><span>{{ $settings['address'] }}</span></div>
                    </div>
                    @endif
                    @if(!empty($settings['instagram']))
                    <a href="{{ $settings['instagram'] }}" target="_blank" class="contact-item">
                        <div class="icon-wrap ig"><i class="fab fa-instagram"></i></div>
                        <div><strong>Instagram</strong><span>Nos siga no Instagram</span></div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <p class="mb-0">© {{ date('Y') }} <strong>{{ $settings['site_name'] ?? 'Oficina' }}</strong>. Todos os direitos reservados.</p>
</footer>

{{-- WHATSAPP FLOAT --}}
@if(!empty($settings['whatsapp']))
<div class="whatsapp-float">
    <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank">
        <i class="fab fa-whatsapp" style="font-size:1.3rem"></i> WhatsApp
    </a>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
        });
    });
    // Active nav on scroll
    const sections = document.querySelectorAll('section[id]');
    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(s => { if (window.scrollY >= s.offsetTop - 80) current = s.id; });
        document.querySelectorAll('.nav-link').forEach(l => {
            l.classList.toggle('active', l.getAttribute('href') === '#' + current);
        });
    });
</script>
</body>
</html>
