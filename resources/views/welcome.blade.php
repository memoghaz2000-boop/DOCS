<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ app()->getLocale() == 'ar' ? 'نظام إدوس | تطوير المنتجات الفوارة' : 'EDOCS | Effervescent Optimization System' }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --secondary: #6366f1;
            --bg-dark: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', 'Cairo', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            overflow-x: hidden;
            background-image: 
                radial-gradient(at 0% 0%, rgba(14, 165, 233, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            padding: 2rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            z-index: 100;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(to right, #0ea5e9, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.05em;
        }

        .main-hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 8rem 5% 4rem;
            text-align: center;
        }

        .badge {
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid rgba(14, 165, 233, 0.2);
            padding: 0.5rem 1.2rem;
            border-radius: 100px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s ease-out;
        }

        h1 {
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            max-width: 1000px;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        h1 span {
            color: var(--primary);
        }

        .description {
            font-size: 1.25rem;
            color: var(--text-dim);
            max-width: 700px;
            margin-bottom: 3rem;
            line-height: 1.6;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .cta-group {
            display: flex;
            gap: 1.5rem;
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        .btn {
            padding: 1.2rem 2.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 10px 30px -10px rgba(14, 165, 233, 0.5);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px -12px rgba(14, 165, 233, 0.6);
        }

        .btn-outline {
            border: 1px solid rgba(148, 163, 184, 0.3);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background: rgba(148, 163, 184, 0.1);
            transform: translateY(-3px);
        }

        .lang-switch {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .lang-link {
            color: var(--text-dim);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .lang-link:hover, .lang-link.active {
            color: var(--primary);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 4rem 5%;
            width: 100%;
            max-width: 1200px;
            animation: fadeInUp 1s ease-out 0.8s both;
        }

        .feature-card {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2.5rem;
            border-radius: 20px;
            backdrop-filter: blur(5px);
            transition: transform 0.3s ease, border-color 0.3s ease;
            text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: rgba(14, 165, 233, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--primary);
            {{ app()->getLocale() == 'ar' ? 'margin-left: auto; margin-right: 0;' : '' }}
        }

        .feature-card h3 {
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: var(--text-dim);
            line-height: 1.5;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            z-index: -1;
            filter: blur(80px);
        }
        .c1 { width: 400px; height: 400px; background: rgba(14, 165, 233, 0.1); top: -100px; left: -100px; }
        .c2 { width: 500px; height: 500px; background: rgba(99, 102, 241, 0.1); bottom: -100px; right: -100px; }

        @media (max-width: 768px) {
            .navbar { padding: 1.5rem 5%; }
            .main-hero { padding-top: 6rem; }
            .cta-group { flex-direction: column; width: 100%; }
            .btn { justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="circle c1"></div>
    <div class="circle c2"></div>

    <nav class="navbar">
        <div class="logo">EDOCS</div>
        <div class="lang-switch" style="margin-inline-start: auto; margin-inline-end: 2rem;">
            <a href="{{ route('lang.switch', 'en') }}" class="lang-link {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
            <span style="color: var(--text-dim)">|</span>
            <a href="{{ route('lang.switch', 'ar') }}" class="lang-link {{ app()->getLocale() == 'ar' ? 'active' : '' }}">عربي</a>
        </div>
        <div class="nav-links">
            <a href="{{ url('/admin') }}" class="btn btn-outline" style="padding: 0.8rem 1.5rem; font-size: 0.9rem;">
                {{ __('messages.dashboard') }}
            </a>
        </div>
    </nav>

    <main class="main-hero">
        <div class="badge">
            {{ app()->getLocale() == 'ar' ? 'إدارة المنتجات العلمية v1.0' : 'Scientific Product Management v1.0' }}
        </div>
        <h1>
            @if(app()->getLocale() == 'ar')
                ارتقِ بعملية تطوير المنتجات <span>الفوارة</span>
            @else
                Elevating <span>Effervescent</span> Product Development
            @endif
        </h1>
        <p class="description">
            @if(app()->getLocale() == 'ar')
                إطار عمل الجيل القادم لتحسين تركيبات الأدوية، ومراقبة الاستقرار، وإدارة العمليات التجريبية الصيدلانية بدقة.
            @else
                The next-generation framework for optimizing drug formulas, monitoring stability, and managing pharmaceutical experimental operations with precision.
            @endif
        </p>
        
        <div class="cta-group">
            <a href="/admin" class="btn btn-primary">
                {{ app()->getLocale() == 'ar' ? 'استكشاف مركز المشروع' : 'Explore Project Central' }}
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="{{ app()->getLocale() == 'ar' ? 'transform: rotate(180deg)' : '' }}">
                    <path d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>

        <div class="features-grid" id="features">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <h3>{{ app()->getLocale() == 'ar' ? 'محرك التركيبات' : 'Formulation Engine' }}</h3>
                <p>
                    {{ app()->getLocale() == 'ar' ? 'حساب ورسم خرائط نسب الفوران ومكونات المادة الفعالة بدقة لنتائج مستقرة.' : 'Advanced calculation and mapping of effervescence ratios and API components for stable results.' }}
                </p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2"></path></svg>
                </div>
                <h3>{{ app()->getLocale() == 'ar' ? 'تتبع الاستقرار' : 'Stability Tracking' }}</h3>
                <p>
                    {{ app()->getLocale() == 'ar' ? 'مراقبة شاملة للرطوبة، الرقم الهيدروجيني (pH)، واتجاهات التفكك عبر فترات زمنية محددة.' : 'Comprehensive monitoring of humidity, pH, and decay trends over defined timepoints.' }}
                </p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3>{{ app()->getLocale() == 'ar' ? 'المخاطر والامتثال' : 'Risk & Compliance' }}</h3>
                <p>
                    {{ app()->getLocale() == 'ar' ? 'حسابات متكاملة لرقم أولوية المخاطر (RPN) وتخطيط التخفيف من أوضاع الفشل.' : 'Integrated Risk Priority Number (RPN) calculations and failure mode mitigation planning.' }}
                </p>
            </div>
        </div>
    </main>

    <footer style="padding: 4rem 5%; text-align: center; border-top: 1px solid rgba(148, 163, 184, 0.1); color: var(--text-dim); font-size: 0.9rem;">
        &copy; {{ date('Y') }} EDOCS - {{ app()->getLocale() == 'ar' ? 'نظام تطوير المنتجات الفوارة. جميع الحقوق محفوظة.' : 'Effervescent Product Development System. All rights reserved.' }}
    </footer>
</body>
</html>
