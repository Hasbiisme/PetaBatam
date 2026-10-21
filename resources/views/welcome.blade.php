<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tourism Map Batam</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    {{-- PERUBAHAN: Library eksternal untuk jarak sudah tidak diperlukan dan dihapus --}}
    {{-- <script src="https://unpkg.com/leaflet-polylinedistance@1.1.0/dist/leaflet.polylinedistance.js"></script> --}}

    <style>
        /* CSS Anda tidak ada perubahan */
        html, body { height: 100%; margin: 0; font-family: 'Inter', sans-serif; }
        header { height: 4.5rem; z-index: 2000; }
        .sidebar-left {
            position: absolute; top: 4.5rem; left: 0; bottom: 0; width: 24rem;
            background-color: #f9fafb; box-shadow: 2px 0 12px rgba(0,0,0,0.1);
            border-right: 1px solid #e5e7eb; padding: 1rem; overflow-y: auto;
            z-index: 1000; display: flex; flex-direction: column;
            border-top-right-radius: 1rem; border-bottom-right-radius: 1rem;
        }
        .sidebar-left h3 {
            font-size: 1.125rem; font-weight: 700; color: #4f46e5;
            margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #c7d2fe;
        }
        #deskripsi-container { flex-grow: 1; overflow-y: auto; padding-right: 0.25rem; }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #f3f4f6; border-radius: 3px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background-color: #6366f1; border-radius: 3px; }
        #deskripsi img {
            width: 100%; height: auto; object-fit: cover; border-radius: 0.75rem;
            margin-bottom: 0.75rem; box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        #deskripsi h4 {
            font-size: 1.125rem; font-weight: 600; color: #4f46e5;
            margin-bottom: 0.5rem; border-bottom: 2px solid #c7d2fe; padding-bottom: 0.25rem;
        }
        #deskripsi p { margin-bottom: 0.5rem; line-height: 1.5; }
        #deskripsi .badge {
            display: inline-block; font-size: 0.75rem; padding: 0.25rem 0.5rem;
            border-radius: 0.5rem; margin-right: 0.25rem; margin-bottom: 0.25rem;
        }
        #deskripsi .badge-category { background-color: #e0e7ff; color: #3730a3; }
        #deskripsi .badge-subcategory { background-color: #dbeafe; color: #1e40af; }

        .category-container {
            position: fixed; top: 6.5rem; right: 1.5rem; z-index: 2000;
            background-color: white; border-radius: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            padding: 0.5rem 0.1rem; display: flex; gap: 0.25rem;
            flex-wrap: wrap; /* <- TAMBAHAN BARU (Penting!) */
            justify-content: center;
        }
        .category-btn-wrapper { position: relative; }
        .category-btn {
            display: flex; align-items: center; justify-content: center;
            gap: 0.25rem; padding: 0.5rem 1rem; border-radius: 9999px;
            background-color: #e5e7eb; color: #4b5563; font-size: 0.875rem;
            font-weight: 500; cursor: pointer; transition: all 0.2s;
        }
        .category-btn:hover, .category-btn.active { background-color: #6366f1; color: white; }
        .category-btn svg { width: 1rem; height: 1rem; }
        .subcategory-dropdown {
            position: absolute; top: 100%; left: 50%; transform: translateX(-50%);
            margin-top: 0.5rem; background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem; z-index: 2000; min-width: 180px;
            display: none; padding: 0.5rem 0;
        }
        .subcategory-dropdown.show { display: block; }
        .subcategory-item {
            display: block; padding: 0.5rem 1rem; font-size: 0.875rem;
            color: #4b5563; cursor: pointer; position: relative;
        }
        .subcategory-item:hover { background-color: #f3f4f6; }
        
        .place-dropdown {
            position: absolute;
            left: 100%; top: 0; display: none; background-color: white;
            border-radius: 0.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            width: 250px; max-height: 300px; overflow-y: auto; z-index: 2010;
        }
        
        .subcategory-item.open-left > .place-dropdown {
            left: auto;
            right: 100%;
        }

        .subcategory-item:hover > .place-dropdown { display: block; }
        .place-item {
            display: flex; align-items: center; padding: 0.5rem;
            cursor: pointer; border-bottom: 1px solid #f3f4f6;
        }

        .route-mode-btn {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px; /* pill shape */
        font-size: 0.875rem; /* text-sm */
        font-weight: 500;
        cursor: pointer;
        background-color: #e5e7eb; /* gray-200 */
        color: #4b5563; /* gray-600 */
        transition: all 0.2s;
        border: 1px solid #d1d5db; /* gray-300 */
        }
        .route-mode-btn:hover {
            background-color: #d1d5db; /* gray-300 */
        }
        /* Style untuk tombol yang aktif */
        .route-mode-btn.active {
            background-color: #6366f1; /* indigo-600 */
            color: white;
            border-color: #4f46e5; /* indigo-700 */
        }

        /* welcome.blade.php -> <style> */

        /* ▼▼▼ TAMBAHKAN BLOK CSS BARU INI ▼▼▼ */
        .category-title {
            width: 100%; /* Memaksa teks mengambil 1 baris penuh */
            text-align: center;
            font-size: 1.125rem; /* 18px */
            font-weight: 600; /* Semi-bold */
            color: #4f46e5; /* Menyesuaikan dengan warna tema (indigo) */
            margin-bottom: 0.5rem; /* Jarak ke tombol di bawahnya */
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e0e7ff; /* Garis pemisah tipis */
        }
        /* ▲▲▲ BATAS AKHIR PENAMBAHAN ▲▲▲ */
        .place-item:last-child { border-bottom: none; }
        .place-item:hover { background-color: #f3f4f6; }
        .place-item img {
            width: 60px; height: 40px; object-fit: cover;
            border-radius: 0.25rem; margin-right: 0.75rem;
        }
        .place-item-name {
            font-size: 0.875rem; color: #374151; font-weight: 500;
        }

        #map { position: absolute; top: 4.5rem; left: 24rem; right: 0; bottom: 0; z-index: 0; }
        footer { background-color: #1e293b; color: #e2e8f0; text-align: center; padding: 1rem; }
        
        .poi-card-wrapper .leaflet-marker-icon { background: transparent; border: none; }
        .poi-card {
            width: 120px; height: 90px; background: white; border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3); overflow: hidden;
            display: flex; flex-direction: column;
        }
        .poi-card-image { width: 100%; height: 60px; object-fit: cover; }
        .poi-card-name {
            font-size: 11px; font-weight: bold; color: #333; text-align: center; padding: 4px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
            /* =========================================
            RESPONSIVE DESIGN (MOBILE)
            ========================================= */

            /* Hanya berlaku untuk layar dengan lebar max 768px (Tablet & HP) */
            @media (max-width: 768px) {
                
                /* 1. Header: Kecilkan ukuran teks */
                header h1 {
                    font-size: 1.25rem; /* Lebih kecil */
                }
                header {
                    height: 3.5rem; /* Sedikit lebih pendek */
                    padding: 0 1rem;
                }

                /* 2. Tombol Kategori: Pindah ke Atas Tengah & Bisa Scroll Samping */
                .category-container {
                    top: 4rem; /* Tepat di bawah header */
                    left: 0; 
                    right: 0;
                    width: 100%;
                    border-radius: 0;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    padding: 0.5rem;
                    
                    /* Agar bisa di-scroll ke samping (swipe) */
                    display: flex;
                    flex-wrap: nowrap; /* Jangan turun ke bawah */
                    justify-content: flex-start; /* Mulai dari kiri */
                    overflow-x: auto; /* Aktifkan scroll horizontal */
                    -webkit-overflow-scrolling: touch; /* Smooth scroll di iOS */
                    gap: 0.5rem;
                }

                /* Sembunyikan judul "Select Your Destination" di HP agar hemat tempat */
                .category-title {
                    display: none; 
                }

                /* Pastikan tombol tidak mengecil */
                .category-btn-wrapper {
                    flex: 0 0 auto; /* Jangan menyusut */
                }

                /* 3. Sidebar (Deskripsi): Ubah jadi "Bottom Sheet" (Muncul dari Bawah) */
                .sidebar-left {
                    width: 100%; /* Lebar penuh */
                    height: 40vh; /* Tinggi 40% dari layar */
                    top: auto; /* Hapus posisi atas */
                    bottom: 0; /* Tempel di bawah */
                    left: 0;
                    border-right: none;
                    border-top: 2px solid #e5e7eb;
                    border-radius: 1.5rem 1.5rem 0 0; /* Lengkungan di sudut atas */
                    box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
                    z-index: 3000; /* Pastikan di atas peta */
                    transition: height 0.3s ease-in-out;
                }
                
                /* 4. Peta: Full Screen di Belakang */
                #map {
                    left: 0; /* Hapus jarak kiri 24rem */
                    top: 3.5rem; /* Sesuaikan dengan tinggi header baru */
                    bottom: 0;
                    width: 100%;
                }

                /* 5. Dropdown Menu: Sesuaikan agar tidak kepotong */
                .subcategory-dropdown {
                    position: fixed; /* Ubah jadi fixed agar relatif ke layar */
                    top: 8rem; /* Jarak dari atas */
                    left: 50%;
                    transform: translateX(-50%);
                    width: 90%; /* Lebar 90% layar */
                    max-height: 50vh;
                    overflow-y: auto;
                }

                /* 6. Routing Control (Kotak petunjuk arah bawaan Leaflet) */
                .leaflet-routing-container {
                    display: none !important; /* Sembunyikan instruksi teks step-by-step di HP karena menuhin layar */
                }
            }

        /* =========================================
           TRIP PLANNER PANEL
           ========================================= */

        /* Floating toggle button */
        #trip-planner-toggle {
            position: fixed;
            bottom: 2rem;
            right: 1.5rem;
            z-index: 3000;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            border-radius: 9999px;
            padding: 0.85rem 1.4rem;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(99,102,241,0.45);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        #trip-planner-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(99,102,241,0.55);
        }

        /* Panel backdrop */
        #trip-panel-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.35);
            z-index: 3999;
        }
        #trip-panel-backdrop.open { display: block; }

        /* Slide-in panel */
        #trip-planner-panel {
            position: fixed;
            top: 0;
            right: -26rem;
            width: 24rem;
            height: 100vh;
            background: #ffffff;
            z-index: 4000;
            box-shadow: -6px 0 32px rgba(0,0,0,0.18);
            display: flex;
            flex-direction: column;
            transition: right 0.35s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
        }
        #trip-planner-panel.open { right: 0; }

        /* Panel header */
        .tp-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }
        .tp-header h2 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.01em;
        }
        .tp-header p {
            font-size: 0.75rem;
            opacity: 0.85;
            margin: 0.2rem 0 0;
        }
        #tp-close-btn {
            background: rgba(255,255,255,0.15);
            border: none;
            color: white;
            border-radius: 50%;
            width: 2rem;
            height: 2rem;
            cursor: pointer;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            flex-shrink: 0;
        }
        #tp-close-btn:hover { background: rgba(255,255,255,0.3); }

        /* Form section */
        .tp-form {
            padding: 1.25rem 1.5rem;
            flex-shrink: 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .tp-field { margin-bottom: 1rem; }
        .tp-field label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.35rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .tp-field select,
        .tp-field input[type="number"] {
            width: 100%;
            padding: 0.55rem 0.75rem;
            border: 1.5px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #374151;
            background: #f9fafb;
            transition: border-color 0.2s;
            appearance: none;
        }
        .tp-field select:focus,
        .tp-field input[type="number"]:focus {
            outline: none;
            border-color: #6366f1;
            background: white;
        }
        .tp-checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }
        .tp-checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #4b5563;
            cursor: pointer;
        }
        .tp-checkbox-label input[type="checkbox"] {
            accent-color: #6366f1;
            width: 1rem;
            height: 1rem;
            cursor: pointer;
        }
        #tp-generate-btn {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            border-radius: 0.6rem;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: opacity 0.2s, transform 0.15s;
            margin-top: 0.25rem;
        }
        #tp-generate-btn:hover:not(:disabled) {
            opacity: 0.92;
            transform: translateY(-1px);
        }
        #tp-generate-btn:disabled { opacity: 0.6; cursor: not-allowed; }

        /* Spinner */
        .tp-spinner {
            width: 1.1rem; height: 1.1rem;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: white;
            border-radius: 50%;
            animation: tp-spin 0.7s linear infinite;
            display: none;
        }
        @keyframes tp-spin { to { transform: rotate(360deg); } }

        /* Results area */
        #tp-results {
            flex: 1;
            overflow-y: auto;
            padding: 1.25rem 1.5rem;
        }
        #tp-results::-webkit-scrollbar { width: 5px; }
        #tp-results::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 3px; }

        /* Error / info messages */
        .tp-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            text-align: center;
        }
        .tp-message.info {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #1d4ed8;
        }

        /* Summary bar */
        .tp-summary {
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            border-radius: 0.6rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .tp-summary-stat { text-align: center; }
        .tp-summary-stat .stat-val {
            font-size: 1.2rem;
            font-weight: 800;
            color: #4f46e5;
            line-height: 1;
        }
        .tp-summary-stat .stat-lbl {
            font-size: 0.7rem;
            color: #6366f1;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        /* Show on map button */
        #tp-show-route-btn {
            width: 100%;
            padding: 0.65rem;
            background: white;
            color: #4f46e5;
            border: 2px solid #6366f1;
            border-radius: 0.6rem;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-bottom: 1rem;
            transition: background 0.2s, color 0.2s;
        }
        #tp-show-route-btn:hover {
            background: #6366f1;
            color: white;
        }

        /* Timeline cards */
        .tp-timeline { position: relative; }
        .tp-timeline::before {
            content: '';
            position: absolute;
            left: 1.1rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #6366f1, #c7d2fe);
            border-radius: 1px;
        }
        .tp-stop {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            position: relative;
        }
        .tp-stop-dot {
            flex-shrink: 0;
            width: 2.2rem;
            height: 2.2rem;
            border-radius: 50%;
            background: white;
            border: 3px solid #6366f1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 800;
            color: #4f46e5;
            z-index: 1;
            box-shadow: 0 2px 6px rgba(99,102,241,0.25);
        }
        .tp-stop-dot.culinary { border-color: #f59e0b; color: #d97706; }
        .tp-stop-dot.accommodation { border-color: #10b981; color: #047857; }

        .tp-stop-card {
            flex: 1;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.6rem;
            overflow: hidden;
            transition: box-shadow 0.2s;
            cursor: pointer;
        }
        .tp-stop-card:hover { box-shadow: 0 4px 12px rgba(99,102,241,0.15); }
        .tp-stop-card-img {
            width: 100%;
            height: 80px;
            object-fit: cover;
        }
        .tp-stop-card-body { padding: 0.6rem 0.75rem; }
        .tp-stop-time {
            font-size: 0.72rem;
            font-weight: 700;
            color: #6366f1;
            letter-spacing: 0.03em;
        }
        .tp-stop-name {
            font-size: 0.875rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0.15rem 0;
            line-height: 1.3;
        }
        .tp-stop-meta {
            font-size: 0.72rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            flex-wrap: wrap;
        }
        .tp-badge {
            padding: 0.1rem 0.4rem;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 600;
        }
        .tp-badge-attraction { background: #e0e7ff; color: #3730a3; }
        .tp-badge-culinary   { background: #fef3c7; color: #92400e; }
        .tp-badge-accommodation { background: #d1fae5; color: #065f46; }

        @media (max-width: 768px) {
            #trip-planner-panel { width: 100%; right: -100%; }
            #trip-planner-toggle { bottom: 1rem; right: 1rem; padding: 0.7rem 1rem; font-size: 0.8rem; }
        }


        /* =========================================================
           MOBILE FIX: category/subcategory tidak lagi perlu scroll kanan
           ========================================================= */
        @media (max-width: 768px) {
            .category-container {
                top: 3.5rem;
                left: 0;
                right: 0;
                width: 100%;
                border-radius: 0 0 1rem 1rem;
                padding: 0.45rem 0.55rem;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                gap: 0.35rem;
                overflow: visible;
                box-shadow: 0 8px 20px rgba(15, 23, 42, 0.14);
            }

            .category-btn-wrapper {
                position: static;
                flex: 0 0 auto;
            }

            .category-btn {
                padding: 0.42rem 0.72rem;
                font-size: 0.75rem;
                line-height: 1;
                white-space: nowrap;
            }

            .subcategory-dropdown {
                position: fixed;
                top: 7.35rem;
                left: 0.75rem;
                right: 0.75rem;
                width: auto;
                min-width: 0;
                max-height: 42vh;
                overflow-y: auto;
                transform: none;
                margin-top: 0;
                padding: 0.45rem;
                border-radius: 1rem;
                box-shadow: 0 14px 35px rgba(15, 23, 42, 0.24);
                z-index: 3600;
            }

            .subcategory-item {
                border-radius: 0.75rem;
                padding: 0.75rem 0.85rem;
                font-weight: 700;
                color: #374151;
                border-bottom: 1px solid #eef2ff;
            }

            .subcategory-item::after {
                content: 'Lihat tempat';
                float: right;
                font-size: 0.68rem;
                font-weight: 700;
                color: #6366f1;
                background: #eef2ff;
                border-radius: 9999px;
                padding: 0.18rem 0.45rem;
            }

            .subcategory-item.mobile-open,
            .subcategory-item:hover {
                background: #f8faff;
            }

            .subcategory-item.open-left > .place-dropdown,
            .place-dropdown {
                position: static;
                left: auto;
                right: auto;
                top: auto;
                width: 100%;
                max-height: 13.5rem;
                overflow-y: auto;
                margin-top: 0.65rem;
                border: 1px solid #e0e7ff;
                border-radius: 0.85rem;
                box-shadow: none;
                background: #ffffff;
                display: none;
            }

            .subcategory-item:hover > .place-dropdown,
            .subcategory-item.mobile-open > .place-dropdown {
                display: block;
            }

            .place-item {
                padding: 0.6rem;
            }

            .place-item img {
                width: 54px;
                height: 38px;
            }
        }

    </style>
</head>
<body class="h-full">

<header class="bg-gradient-to-r from-gray-900 via-indigo-900 to-blue-900 shadow-md fixed w-full flex items-center justify-center">
  <div class="max-w-7xl mx-auto px-6 py-5">
    <h1 class="text-3xl md:text-4xl font-bold text-white tracking-wide drop-shadow-lg">Tourism Map Batam</h1>
  </div>
</header>
<div class="category-container">
    <div class="category-title">Select Your Destination</div>
    <div class="category-btn-wrapper"><button id="all-btn" class="category-btn active"><span>All</span></button></div>
    <div class="category-btn-wrapper">
        <button id="accommodation-btn" class="category-btn">Accommodation <svg class="h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></button>
        <div id="accommodation-dropdown" class="subcategory-dropdown"></div>
    </div>
    <div class="category-btn-wrapper">
        <button id="food-beverages-btn" class="category-btn">Food & Beverages <svg class="h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></button>
        <div id="food-beverages-dropdown" class="subcategory-dropdown"></div>
    </div>
    <div class="category-btn-wrapper">
        <button id="attraction-btn" class="category-btn">Attraction <svg class="h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></button>
        <div id="attraction-dropdown" class="subcategory-dropdown"></div>
    </div>
    <div class="category-btn-wrapper">
        <button id="public-information-btn" class="category-btn">Public Information <svg class="h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></button>
        <div id="public-information-dropdown" class="subcategory-dropdown"></div>
    </div>
</div>
<div class="sidebar-left flex flex-col">
  <h3 class="text-center w-full mb-4 text-indigo-700 font-bold text-lg border-b-2 border-indigo-200 pb-2">📍 Location Description</h3>
    <div id="deskripsi-container" class="scrollbar-thin flex-grow overflow-y-auto">
        <div id="deskripsi" class="text-gray-700 text-sm p-4">
            <h4 class="text-indigo-600 font-bold text-lg mb-2">Welcome to Batam! 👋</h4>
            <p class="mb-3 leading-relaxed">
                Explore the vibrant city through our interactive map. Discover the best accommodations, delicious food, and exciting attractions.
            </p>
            <div class="bg-indigo-50 p-3 rounded-lg border border-indigo-100 text-xs text-indigo-800">
                <strong>How to use:</strong><br>
                Click any marker on the map or use the filters above to view details and get directions.
            </div>
            </div>
    </div>
</div>

<div id="map"></div>


{{-- ── TRIP PLANNER TOGGLE BUTTON ── --}}
<button id="trip-planner-toggle" onclick="openTripPlanner()" aria-label="Open Trip Planner">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12l9-9 9 9"/><path d="M9 21V12h6v9"/></svg>
    Plan My Trip
</button>

{{-- ── BACKDROP ── --}}
<div id="trip-panel-backdrop" onclick="closeTripPlanner()"></div>

{{-- ── TRIP PLANNER SLIDE PANEL ── --}}
<div id="trip-planner-panel" role="dialog" aria-label="Trip Planner">

    {{-- Header --}}
    <div class="tp-header">
        <div>
            <h2>🗺️ Trip Planner</h2>
            <p>Build your Batam itinerary in seconds</p>
        </div>
        <button id="tp-close-btn" onclick="closeTripPlanner()" aria-label="Close">&times;</button>
    </div>

    {{-- Form --}}
    <div class="tp-form">

        <div class="tp-field">
            <label for="tp-categories">Interests</label>
            <div class="tp-checkbox-group" id="tp-category-checkboxes">
                <label class="tp-checkbox-label">
                    <input type="checkbox" name="tp_category" value="Attraction" checked id="cb-attraction"> Attraction
                </label>
                <label class="tp-checkbox-label">
                    <input type="checkbox" name="tp_category" value="Food & Beverages" id="cb-culinary"> Food &amp; Beverages
                </label>
                <label class="tp-checkbox-label">
                    <input type="checkbox" name="tp_category" value="Accommodation" id="cb-accommodation"> Accommodation
                </label>
            </div>
        </div>

        <div class="tp-field">
            <label for="tp-duration">Trip Duration</label>
            <select id="tp-duration">
                <option value="3">Half Day (~3 hours)</option>
                <option value="5" selected>Standard Day (~5 hours)</option>
                <option value="8">Full Day (~8 hours)</option>
                <option value="10">Extended Day (~10 hours)</option>
            </select>
        </div>

        <div class="tp-field">
            <label>Starting Point</label>
            <div class="tp-checkbox-group">
                <label class="tp-checkbox-label">
                    <input type="radio" name="tp_start" value="default" checked id="rb-default"> Default location (Batam Centre)
                </label>
                <label class="tp-checkbox-label">
                    <input type="radio" name="tp_start" value="gps" id="rb-gps"> Use my GPS location
                </label>
            </div>
        </div>

        <button id="tp-generate-btn" onclick="generateTrip()">
            <span id="tp-btn-text">✨ Generate Itinerary</span>
            <div class="tp-spinner" id="tp-spinner"></div>
        </button>
    </div>

    {{-- Results --}}
    <div id="tp-results">
        <p class="tp-message info">Select your preferences above and tap <strong>Generate Itinerary</strong> to build your Batam trip plan.</p>
    </div>
</div>

<footer><p class="text-sm">&copy; <span id="year"></span> <span class="font-semibold">Tourism Map Batam</span>. All rights reserved.</p></footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // =======================================================
    // PENGATURAN AWAL & VARIABEL GLOBAL
    // =======================================================
    
    const userLat = 1.1534; 
    const userLng = 103.9975;

    const defaultDescriptionHTML = `
        <h4 class="text-indigo-600 font-bold text-lg mb-2">Welcome to Batam! 👋</h4>
        <p class="mb-3 leading-relaxed">
            Peta Digital Wisata Pulau Batam
            Alat bantu interaktif dan modern yang dirancang untuk memudahkan wisatawan menjelajahi destinasi-destinasi menarik di Batam.
        </p>
        <div class="bg-indigo-50 p-3 rounded-lg border border-indigo-100 text-xs text-indigo-800">
            <strong>Fungsi Utama:</strong><br>
            Memberikan panduan lokasi, rute, dan informasi penting mengenai berbagai tempat wisata.<br>
            <br>
            <strong>Isi Konten:</strong><br>
            Mencakup destinasi populer (seperti Jembatan Barelang, Pantai Nongsa, Vihara Duta Maitreya), pusat perbelanjaan (mal dan kawasan free trade zone), kuliner khas, akomodasi (hotel/resor), serta fasilitas umum (bandara, pelabuhan, rumah sakit).<br>
            <br>
            <strong>Keuntungan:</strong><br>
            Memungkinkan perencanaan perjalanan yang efisien, mudah diakses melalui perangkat seluler, dan menyediakan informasi yang lebih dinamis serta up-to-date dibandingkan peta konvensional. 
        </div>
        <p class="mb-3 leading-relaxed">
        <br>
            Secara keseluruhan, peta ini adalah solusi praktis bagi turis domestik maupun internasional untuk mengoptimalkan pengalaman liburan mereka diBatam.
        </p>
    `;
    
    window.currentDestination = null;
    
    // ▼▼▼ TAMBAHAN BARU (1 baris) ▼▼▼
    // Ini adalah "cap" untuk melacak request rute mana yang paling baru
    let routeRequestID = 0; 
    // ▲▲▲ BATAS TAMBAHAN ▲▲▲
    
    const MIN_ZOOM_FOR_MARKERS = 10;

    
    document.getElementById("year").innerText = new Date().getFullYear();

    const map = L.map('map').setView([1.1301, 104.0483], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const placesData = @json($places);
    const smallDestinationsData = @json($smallDestinations ?? []);
    
    const markerGroup = L.layerGroup(); 
    const markerRefs = {};
    // Saat Trip Planner berhasil menampilkan itinerary, marker destinasi umum disembunyikan
    // agar peta fokus pada rute perjalanan. Marker akan muncul lagi saat user memilih kategori.
    let destinationMarkersHiddenForTrip = false;

    let tripItinerary = [];       // current generated itinerary
    let tripRoutingControl = null; // separate routing control for trip route

    function clearTripRoute() {
        if (tripRoutingControl) {
            map.removeControl(tripRoutingControl);
            tripRoutingControl = null;
        }
    }

    const poiLayerGroup = L.layerGroup().addTo(map);

    const groupedPlaces = placesData.reduce((acc, place) => {
        const category = place.category ? place.category.trim() : 'Uncategorized';
        const subcategory = place.subcategory ? place.subcategory.trim() : 'General';
        if (!acc[category]) acc[category] = {};
        if (!acc[category][subcategory]) acc[category][subcategory] = [];
        acc[category][subcategory].push(place);
        return acc;
    }, {});

    console.log("[DEBUG] Total placesData fetched:", placesData.length);
    console.log("[DEBUG] Total smallDestinationsData fetched:", smallDestinationsData.length);
    console.log("[DEBUG] Grouped Categories:", Object.keys(groupedPlaces));

    // =======================================================
    // FUNGSI-FUNGSI UTAMA PETA
    // =======================================================

    function showMarkers(category = null, subcategory = null) {
        // User kembali memilih kategori/subkategori, jadi tampilkan lagi marker destinasi umum
        // dan bersihkan rute Trip Planner agar mode browsing peta kembali normal.
        destinationMarkersHiddenForTrip = false;
        markerGroup.clearLayers(); 
        removeRoute();
        clearTripRoute(); 
        clearDeskripsi(); 
        
        let placesToShow = category ? placesData.filter(p => p.category && p.category.trim() === category.trim()) : placesData;
        if (subcategory) placesToShow = placesToShow.filter(p => p.subcategory && p.subcategory.trim() === subcategory.trim());
        
        placesToShow.forEach(p => {
            if (p.latitude && p.longitude) {
                const marker = L.marker([p.latitude, p.longitude]); 
                marker.on('click', () => renderDeskripsi(p));
                markerRefs[p.id] = marker;
                markerGroup.addLayer(marker); 
            }
        });
        console.log(`[DEBUG] showMarkers called (Cat: ${category}, Sub: ${subcategory}). Rendered ${placesToShow.length} markers.`);
        updateMarkersVisibility(); 
    }
    
    function updateMarkersVisibility() {
        // Jika itinerary Trip Planner sedang aktif, marker destinasi umum sengaja disembunyikan
        // supaya peta tidak terlalu ramai. Marker akan muncul lagi melalui showMarkers().
        if (destinationMarkersHiddenForTrip) {
            if (map.hasLayer(markerGroup)) {
                map.removeLayer(markerGroup);
            }
            return;
        }

        if (!map.hasLayer(markerGroup)) {
            map.addLayer(markerGroup); 
        }
    }

    function renderDeskripsi(p) {
        // PERBAIKAN PATH GAMBAR: Tambahkan /images/ (atau /storage/ jika Anda pakai itu)
        const imgHtml = p.image ? `<img src="${escapeHtml(p.image)}" alt="${escapeHtml(p.name)}">` : '';
        const addressHtml = p.address ? `<p><strong>匠 Address:</strong> ${escapeHtml(p.address)}</p>` : '';
        
        window.currentDestination = { lat: p.latitude, lng: p.longitude, id: p.id };
        
        document.getElementById('deskripsi').innerHTML = `
            ${imgHtml}
            <h4>${escapeHtml(p.name)}</h4>
            <p>${escapeHtml(p.description)}</p>
            <div>${addressHtml}</div>
            <div id="route-info-container" class="mt-4 p-3 bg-gray-100 rounded-lg shadow-inner">
                <h5 class="font-bold text-indigo-700 mb-2">Route Information</h5>
                <div class="flex gap-2 mb-3">
                    <button onclick="calculateRoute('driving')" class="route-mode-btn active" data-mode="driving">🚗 Mengemudi</button>
                    <button onclick="calculateRoute('walking')" class="route-mode-btn" data-mode="walking">🚶 Jalan Kaki</button>
                </div>
                <div id="route-details">
                    <p class="text-gray-500 italic">Calculating route...</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-1 mt-2">
                <span class="badge badge-category">唐 ${escapeHtml(p.category)}</span>
                <span class="badge badge-subcategory">翌ｸ${escapeHtml(p.subcategory)}</span>
            </div>
        `;
        
        calculateRoute('driving');
    }

    /**
     * Fungsi BARU untuk menghitung & menggambar rute
     */
    function calculateRoute(mode = 'driving') {
            if (!window.currentDestination) return;

            // ▼▼▼ INI "CAP" PENTINGNYA ▼▼▼
            // Dapatkan "cap" ID unik untuk request ini
            const thisRequestID = ++routeRequestID;
            // ▲▲▲ BATAS ▲▲▲

            // Set tombol aktif
            document.querySelectorAll('.route-mode-btn').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.mode === mode);
            });

            // Tampilkan status loading
            const routeDetailsDiv = document.getElementById('route-details');
            if(routeDetailsDiv) {
                routeDetailsDiv.innerHTML = '<p class="text-gray-500 italic">Calculating route...</p>';
            }

            // Hapus rute lama
            if (window.routingControl) {
                map.removeControl(window.routingControl);
            }
            
            const { lat, lng, id } = window.currentDestination;

            // Buat rute baru dengan mode yang benar
            window.routingControl = L.Routing.control({
                waypoints: [ L.latLng(userLat, userLng), L.latLng(lat, lng) ],
                router: L.Routing.osrmv1({
                    serviceUrl: 'https://router.project-osrm.org/route/v1',
                    profile: mode // mode bisa 'driving' atau 'walking'
                }),
                show: false, createMarker: () => null, position: 'topleft', 
                routeWhileDragging: false,
                lineOptions: { styles: [{ color: '#6366f1', opacity: 1, weight: 6 }] },
                fitSelectedRoutes: true
            }).addTo(map);

            // Event listener saat rute DITEMUKAN
            window.routingControl.on('routesfound', function(e) {
                
                // ▼▼▼ INI "PENJAGA" PENTINGNYA ▼▼▼
                // Cek apakah ini request yang paling baru?
                // Jika tidak, abaikan data ini (karena ini data "zombie" yang telat)
                if (routeRequestID !== thisRequestID) {
                    return; // Berhenti, jangan proses data lama
                }
                // ▲▲▲ BATAS ▲▲▲

                // Redupkan marker lain
                Object.keys(markerRefs).forEach(placeId => {
                    const marker = markerRefs[placeId];
                    marker.setOpacity(placeId == id ? 1 : 0.3);
                });
                
                const routes = e.routes;
                if (routes.length > 0) {
                    const route = routes[0];
                    const summary = route.summary; 

                    const totalDistance = summary.totalDistance; // meter
                    const totalTime = summary.totalTime;       // detik

                    // Format data
                    const distanceKm = (totalDistance / 1000).toFixed(2);
                    const timeHours = Math.floor(totalTime / 3600);
                    const timeMinutes = Math.floor((totalTime % 3600) / 60);
                    
                    let durationString = '';
                    if (timeHours > 0) {
                        durationString += `${timeHours} jam `;
                    }
                    durationString += `${timeMinutes > 0 ? timeMinutes : (timeHours === 0 ? '< 1' : '0')} menit`; 

                    // Tampilkan data
                    const routeDetailsDiv = document.getElementById('route-details');
                    if (routeDetailsDiv) {
                        const icon = mode === 'driving' ? '🚗' : '🚶';
                        routeDetailsDiv.innerHTML = `
                            <p><strong>${icon} Jarak:</strong> ${distanceKm} km</p>
                            <p><strong>⏱️ Waktu Tempuh:</strong> ${durationString}</p>
                        `;
                    }
                    
                    // Tampilkan POI
                    const routeLine = L.polyline(route.coordinates);
                    showPoisAlongRoute(routeLine);
                }
            });

            // Event listener jika rute GAGAL
            window.routingControl.on('routingerror', function(e) {
                // Kita juga tambahkan "penjaga" di sini
                if (routeRequestID !== thisRequestID) {
                    return;
                }
                const routeDetailsDiv = document.getElementById('route-details');
                if (routeDetailsDiv) {
                    routeDetailsDiv.innerHTML = '<p class="text-red-500 font-medium">Error: Rute untuk mode ini tidak ditemukan.</p>';
                }
            });
        }
    /**
     * Menghapus rute dari peta
     */
    function removeRoute() {
        if (window.routingControl) {
            map.removeControl(window.routingControl);
            window.routingControl = null; 
        }
        poiLayerGroup.clearLayers();
        Object.values(markerRefs).forEach(marker => marker.setOpacity(1));
    }

    /**
     * Mengosongkan sidebar deskripsi
     */
    function clearDeskripsi(){
        document.getElementById('deskripsi').innerHTML = defaultDescriptionHTML;
        window.currentDestination = null; 
    }

    // =======================================================
    // FUNGSI-FUNGSI POI (SMALL DESTINATIONS)
    // =======================================================

    function getDistanceToSegment(p, p1, p2) {
        const latLngP = map.project(p);
        const latLngP1 = map.project(p1);
        const latLngP2 = map.project(p2);
        const x = latLngP1.x;
        const y = latLngP1.y;
        const dx = latLngP2.x - x;
        const dy = latLngP2.y - y;

        if (dx !== 0 || dy !== 0) {
            const t = ((latLngP.x - x) * dx + (latLngP.y - y) * dy) / (dx * dx + dy * dy);
            if (t > 1) {
                p1 = p2;
            } else if (t > 0) {
                p1 = L.point(x + dx * t, y + dy * t);
                p1 = map.unproject(p1);
            }
        }
        return p.distanceTo(p1);
    }
    
    function showPoisAlongRoute(routeLine) {
        poiLayerGroup.clearLayers();
        const threshold = 500; 
        const routePoints = routeLine.getLatLngs();

        smallDestinationsData.forEach(poi => {
            const poiLatLng = L.latLng(poi.latitude, poi.longitude);
            let isClose = false;

            for (let i = 0; i < routePoints.length - 1; i++) {
                const start = routePoints[i];
                const end = routePoints[i + 1];
                const distance = getDistanceToSegment(poiLatLng, start, end);
                
                if (distance < threshold) {
                    isClose = true;
                    break; 
                }
            }
            
            if (isClose) {
                // PERBAIKAN PATH GAMBAR: Konsisten dengan renderDeskripsi
                const imageUrl = poi.image ? escapeHtml(poi.image) : 'https://via.placeholder.com/120x60.png?text=IMG';
                const cardHtml = `<div class="poi-card"><img src="${imageUrl}" class="poi-card-image" alt="${escapeHtml(poi.name)}"><div class="poi-card-name">${escapeHtml(poi.name)}</div></div>`;
                const poiIcon = L.divIcon({
                    html: cardHtml, className: 'poi-card-wrapper',
                    iconSize: [120, 90], iconAnchor: [60, 45]
                });
                L.marker(poiLatLng, { icon: poiIcon }).addTo(poiLayerGroup);
            }
        });
    }
    
    // =======================================================
    // FUNGSI-FUNGSI PEMBANTU (HELPERS)
    // =======================================================

    function escapeHtml(text){
        if(!text) return '';
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }
    
    function capitalize(text) {
        if (!text) return '';
        return text.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
    }

    // =======================================================
    // SETUP NAVIGASI & DROPDOWN
    // =======================================================
    
    function setupNavigation() {
        document.getElementById('all-btn').addEventListener('click', () => {
            setActiveButton(document.getElementById('all-btn'));
            showMarkers();
        });

        function setActiveButton(button) {
            document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
        }

        function setupDropdown(button, category, dropdownId) {
            const dropdownContainer = document.getElementById(dropdownId);
            const categoryData = groupedPlaces[category];
            if (categoryData) {
                dropdownContainer.innerHTML = '';
                Object.keys(categoryData).forEach(subcategory => {
                    const subcategoryItem = document.createElement('div');
                    subcategoryItem.className = 'subcategory-item';
                    subcategoryItem.textContent = capitalize(subcategory);
                    if (category === 'Attraction' || category === 'Public Information') {
                        subcategoryItem.classList.add('open-left');
                    }
                    const placesDropdown = document.createElement('div');
                    placesDropdown.className = 'place-dropdown';
                    const places = categoryData[subcategory];
                    places.forEach(place => {
                        const placeItem = document.createElement('div');
                        placeItem.className = 'place-item';
                        // PERBAIKAN PATH GAMBAR: Tambahkan /images/
                        const imageUrl = place.image || 'https://via.placeholder.com/60x40.png?text=No+Image';
                        placeItem.innerHTML = `<img src="${imageUrl}" alt="${escapeHtml(place.name)}"><span class="place-item-name">${escapeHtml(place.name)}</span>`;
                        placeItem.addEventListener('click', (e) => {
                            e.stopPropagation(); 
                            if (markerRefs[place.id]) {
                                map.flyTo([place.latitude, place.longitude], 16);
                                renderDeskripsi(place);
                                document.querySelectorAll('.subcategory-dropdown').forEach(d => d.classList.remove('show'));
                            }
                        });
                        placesDropdown.appendChild(placeItem);
                    });
                    subcategoryItem.appendChild(placesDropdown);

                    // Mobile UX: klik subcategory untuk membuka daftar tempat di bawahnya,
                    // bukan dropdown ke samping. Sekaligus filter marker sesuai subcategory.
                    subcategoryItem.addEventListener('click', (e) => {
                        if (window.innerWidth <= 768) {
                            e.stopPropagation();
                            const wasOpen = subcategoryItem.classList.contains('mobile-open');
                            dropdownContainer.querySelectorAll('.subcategory-item').forEach(item => item.classList.remove('mobile-open'));
                            if (!wasOpen) subcategoryItem.classList.add('mobile-open');
                        }
                        showMarkers(category, subcategory);
                    });

                    dropdownContainer.appendChild(subcategoryItem);
                });
            }

            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const isCurrentlyShown = dropdownContainer.classList.contains('show');
                document.querySelectorAll('.subcategory-dropdown').forEach(d => d.classList.remove('show'));
                document.querySelectorAll('.subcategory-item.mobile-open').forEach(item => item.classList.remove('mobile-open'));
                if (!isCurrentlyShown) dropdownContainer.classList.add('show');
                setActiveButton(button);
                showMarkers(category);
            });
        }
        
        setupDropdown(document.getElementById('accommodation-btn'), 'Accommodation', 'accommodation-dropdown');
        setupDropdown(document.getElementById('food-beverages-btn'), 'Food & Beverages', 'food-beverages-dropdown');
        setupDropdown(document.getElementById('attraction-btn'), 'Attraction', 'attraction-dropdown');
        setupDropdown(document.getElementById('public-information-btn'), 'Public Information', 'public-information-dropdown');
        
        document.addEventListener('click', (event) => {
            if (!event.target.closest('.category-btn-wrapper')) {
                document.querySelectorAll('.subcategory-dropdown').forEach(dropdown => dropdown.classList.remove('show'));
                document.querySelectorAll('.subcategory-item.mobile-open').forEach(item => item.classList.remove('mobile-open'));
            }
        });
    }

    // =======================================================
    // INISIALISASI SAAT HALAMAN DILOAD
    // =======================================================
    
    setupNavigation();
    showMarkers(); 
    
    map.on('zoomend', updateMarkersVisibility);
    updateMarkersVisibility();
    
    window.addEventListener('resize', function() {
        setTimeout(function(){ map.invalidateSize(); }, 300);
    });
    // "Ekspos" fungsi ini ke global agar onclick HTML bisa melihatnya
    window.calculateRoute = calculateRoute;

    // =======================================================
    // TRIP PLANNER — STATE & HELPERS
    // =======================================================

    // Open / close panel
    function openTripPlanner() {
        document.getElementById('trip-planner-panel').classList.add('open');
        document.getElementById('trip-panel-backdrop').classList.add('open');
    }
    function closeTripPlanner() {
        document.getElementById('trip-planner-panel').classList.remove('open');
        document.getElementById('trip-panel-backdrop').classList.remove('open');
    }
    window.openTripPlanner  = openTripPlanner;
    window.closeTripPlanner = closeTripPlanner;

    // =======================================================
    // TRIP PLANNER — GENERATE ITINERARY
    // =======================================================

    function generateTrip() {
        // 1. Collect selected categories
        const categoryChecks = document.querySelectorAll('input[name="tp_category"]:checked');
        const categories = Array.from(categoryChecks).map(cb => cb.value);
        if (categories.length === 0) {
            setTripResults('<p class="tp-message">Please select at least one interest category.</p>');
            return;
        }

        // 2. Duration
        const duration = parseInt(document.getElementById('tp-duration').value, 10);

        // 3. Start point
        const useGps = document.getElementById('rb-gps').checked;

        const doFetch = (startLat, startLng) => {
            setLoadingState(true);
            
            // Simpan start location yang digunakan untuk route rendering
            window._usedStartLat = startLat;
            window._usedStartLng = startLng;

            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

            fetch('/generate-trip', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    categories:    categories,
                    trip_duration: duration,
                    start_lat:     startLat,
                    start_lng:     startLng,
                }),
            })
            .then(res => {
                if (!res.ok) throw new Error('Server error: ' + res.status);
                return res.json();
            })
            .then(data => {
                setLoadingState(false);
                if (!data.success || !data.itinerary || data.itinerary.length === 0) {
                    setTripResults(`<p class="tp-message">${escapeHtml(data.message || 'No itinerary could be generated. Try different options.')}</p>`);
                    console.warn('[DEBUG] Itinerary generation failed:', data.message);
                    return;
                }
                console.log(`[DEBUG] Itinerary generated successfully with ${data.itinerary.length} stops.`);
                tripItinerary = data.itinerary;
                renderItinerary(data);
                showTripRoute(); // Render automatically as requested
            })
            .catch(err => {
                setLoadingState(false);
                setTripResults(`<p class="tp-message">Connection error. Please check your connection and try again.<br><small>${escapeHtml(err.message)}</small></p>`);
                console.error('Trip Planner error:', err);
            });
        };

        if (useGps && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                pos => {
                    doFetch(pos.coords.latitude, pos.coords.longitude);
                },
                ()  => {
                    // GPS denied — fall back to default
                    doFetch(userLat, userLng);
                },
                { timeout: 6000 }
            );
        } else {
            doFetch(userLat, userLng);
        }
    }
    window.generateTrip = generateTrip;

    // =======================================================
    // TRIP PLANNER — RENDER ITINERARY TIMELINE
    // =======================================================

    function renderItinerary(data) {
        const { itinerary, total_stops, trip_duration } = data;

        // Summary bar dibuat lebih ringkas: keterangan Start dan End dihilangkan
        // agar tampilan Plan My Trip tidak terlalu penuh di layar mobile.
        let summaryHtml = `
            <div class="tp-summary">
                <div class="tp-summary-stat">
                    <div class="stat-val">${total_stops}</div>
                    <div class="stat-lbl">Stops</div>
                </div>
                <div class="tp-summary-stat">
                    <div class="stat-val">${trip_duration}h</div>
                    <div class="stat-lbl">Duration</div>
                </div>
            </div>
        `;

        // "Show on Map" button
        let showRouteBtn = `
            <button id="tp-show-route-btn" onclick="showTripRoute()">
                🗺️ Show Route on Map
            </button>
        `;

        // Timeline
        let timelineHtml = '<div class="tp-timeline">';
        itinerary.forEach((stop, idx) => {
            const dotClass  = stop.category === 'Food & Beverages' ? 'culinary'
                            : stop.category === 'Accommodation' ? 'accommodation'
                            : '';
            const badgeClass = stop.category === 'Food & Beverages' ? 'tp-badge-culinary'
                             : stop.category === 'Accommodation' ? 'tp-badge-accommodation'
                             : 'tp-badge-attraction';

            const imgHtml = stop.image
                ? `<img src="${escapeHtml(stop.image)}" class="tp-stop-card-img" alt="${escapeHtml(stop.name)}" onerror="this.style.display='none'">`
                : '';

            const clusterLabel = stop.cluster
                ? stop.cluster.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
                : '';

            timelineHtml += `
                <div class="tp-stop" data-stop-idx="${idx}">
                    <div class="tp-stop-dot ${dotClass}">${idx + 1}</div>
                    <div class="tp-stop-card" onclick="flyToStop(${stop.latitude}, ${stop.longitude}, ${JSON.stringify(stop).replace(/</g,'\\u003c')})">
                        ${imgHtml}
                        <div class="tp-stop-card-body">
                            <div class="tp-stop-time">⏰ ${stop.start_time} – ${stop.end_time}</div>
                            <div class="tp-stop-name">${escapeHtml(stop.name)}</div>
                            <div class="tp-stop-meta">
                                <span class="tp-badge ${badgeClass}">${escapeHtml(stop.category)}</span>
                                ${clusterLabel ? `<span>📍 ${escapeHtml(clusterLabel)}</span>` : ''}
                                <span>🕐 ${stop.visit_duration} min</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        timelineHtml += '</div>';

        setTripResults(summaryHtml + showRouteBtn + timelineHtml);
    }

    // =======================================================
    // TRIP PLANNER — CLICK A STOP → FLY TO IT ON MAP
    // =======================================================

    function flyToStop(lat, lng, stopData) {
        map.flyTo([lat, lng], 16, { duration: 1.2 });
        // Also open the existing description sidebar for this place
        if (stopData && stopData.place_id) {
            const place = placesData.find(p => p.id === stopData.place_id);
            if (place) renderDeskripsi(place);
        }
    }
    window.flyToStop = flyToStop;

    // =======================================================
    // TRIP PLANNER — SHOW MULTI-STOP ROUTE ON MAP
    // =======================================================

    function showTripRoute() {
        if (!tripItinerary || tripItinerary.length === 0) return;

        // Remove previous trip route and single-place route
        clearTripRoute();
        removeRoute();

        // Sembunyikan marker destinasi umum saat itinerary/rute ditampilkan
        // agar yang terlihat hanya rute dan marker urutan perjalanan.
        destinationMarkersHiddenForTrip = true;
        if (map.hasLayer(markerGroup)) {
            map.removeLayer(markerGroup);
        }

        // Build waypoints: user start + all stops
        const startPoint = L.latLng(window._usedStartLat || userLat, window._usedStartLng || userLng);

        const waypoints = [startPoint];
        tripItinerary.forEach(stop => {
            if (stop.latitude && stop.longitude) {
                waypoints.push(L.latLng(stop.latitude, stop.longitude));
            }
        });

        if (waypoints.length < 2) {
            alert('Not enough valid coordinates to draw a route.');
            return;
        }

        tripRoutingControl = L.Routing.control({
            waypoints: waypoints,
            router: L.Routing.osrmv1({
                serviceUrl: 'https://router.project-osrm.org/route/v1',
                profile: 'driving',
            }),
            show: false,
            createMarker: (i, wp) => {
                // Custom numbered markers for each stop
                const stop   = tripItinerary[i - 1]; // i=0 is start point
                const label  = i === 0 ? '🚩' : String(i);
                const color  = i === 0 ? '#6b7280'
                             : (stop && stop.category === 'Food & Beverages') ? '#f59e0b'
                             : '#6366f1';
                const icon = L.divIcon({
                    html: `<div style="background:${color};color:white;border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;box-shadow:0 2px 8px rgba(0,0,0,0.3);border:2px solid white;">${label}</div>`,
                    className: '',
                    iconSize: [28, 28],
                    iconAnchor: [14, 14],
                });
                return L.marker(wp.latLng, { icon });
            },
            routeWhileDragging: false,
            lineOptions: {
                styles: [{ color: '#6366f1', opacity: 0.9, weight: 5, dashArray: '8,4' }],
            },
            fitSelectedRoutes: true,
        }).addTo(map);

        // We don't close the panel automatically anymore because the user might want to read the itinerary timeline first.
        // Brief feedback in the toggle button
        const toggleBtn = document.getElementById('trip-planner-toggle');
        const orig = toggleBtn.innerHTML;
        toggleBtn.innerHTML = '✅ Route on Map';
        setTimeout(() => { toggleBtn.innerHTML = orig; }, 3000);
    }
    window.showTripRoute = showTripRoute;

    // =======================================================
    // TRIP PLANNER — UI HELPERS
    // =======================================================

    function setLoadingState(isLoading) {
        const btn     = document.getElementById('tp-generate-btn');
        const spinner = document.getElementById('tp-spinner');
        const btnText = document.getElementById('tp-btn-text');
        btn.disabled  = isLoading;
        spinner.style.display = isLoading ? 'block' : 'none';
        btnText.textContent   = isLoading ? 'Generating...' : '✨ Generate Itinerary';
        if (isLoading) {
            setTripResults('<p class="tp-message info">⏳ Building your personalised itinerary...</p>');
        }
    }

    function setTripResults(html) {
        document.getElementById('tp-results').innerHTML = html;
    }

}); // <-- Akhir dari document.addEventListener
</script>

</body>
</html>