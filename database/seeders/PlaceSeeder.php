<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Place;
use Illuminate\Support\Facades\Storage;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        $places = [
            // ===============================================
            // ====== DATA AWAL (YANG SUDAH ADA) ======
            // ===============================================
            [
                'name' => 'Blue Fire Apartment',
                'address' => 'Near beach',
                'latitude' => 1.1605,
                'longitude' => 104.0372,
                'description' => 'Modern apartment with sea view, fully furnished, close to beach and public transport.',
                'category' => 'Accommodation',
                'subcategory' => 'Apartment',
                'image' => 'Blue_Fire_Apartment.jpg'
            ],
            [
                'name' => 'Golden Prawn',
                'address' => 'Golden Prawn Bengkong, Batam City',
                'latitude' => 1.1444,
                'longitude' => 104.0152,
                'description' => 'Famous seafood restaurant with an iconic golden shrimp statue.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'Golden_prawn.jpg'
            ],
            [
                'name' => 'Atlantis BC Bengkong',
                'address' => 'Komplek Gold Coast Luxury Blok A No.03, Jl. Golden City Bengkong Laut, Batam, BATAM',
                'latitude' => 1.168866,
                'longitude' => 104.048762,
                'description' => 'Tropical ambiance like Bali, delicious cuisine, exclusive swimming pool, DJ and live music, suitable for families and casual hangouts.',
                'category' => 'Attraction',
                'subcategory' => 'Nature Attraction',
                'image' => 'atlantis.jpg'
            ],
            [
                'name' => 'Excelso Tiban',
                'address' => 'Vitka, Tiban Lama 29424 Sekupang',
                'latitude' => 1.113399,
                'longitude' => 103.978919,
                'description' => 'Cafe kopi cozy di Tiban Ayu, cocok untuk bekerja, nongkrong santai & meeting santai.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Excelso.jpg'
            ],
            [
                'name' => 'Kopi Ameng Tiban',
                'address' => 'Ruko Summer Coast, Jl. Tiban V No.24, Patam Lestari, Kec. Sekupang, Kota Batam, Kepulauan Riau 29424',
                'latitude' => 1.111956,
                'longitude' => 103.978944,
                'description' => 'Cafe kopi cozy di Tiban Ayu, cocok untuk bekerja, nongkrong santai & meeting santai.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Kopi_Ameng.jpg'
            ],
            [
                'name' => 'Kelong Baba Tiban',
                'address' => 'Kompleks Green Bay Kav.Kelong TIban, Sekupang, Batam City, Riau Islands 29424',
                'latitude' => 1.133686,
                'longitude' => 103.979627,
                'description' => 'Restoran seafood terapung, memilih langsung seafood segar, pemandangan laut.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'Kelong_Baba_Tiban.jpg'
            ],
            [
                'name' => 'Teh Tarik Belakang Padang Melawa Batam',
                'address' => 'Komp KBC (King Business Centre Business Centre KBC Blok A2 No.6-7, Belian, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29464',
                'latitude' => 1.155594,
                'longitude' => 104.03873,
                'description' => 'Spesialis teh tarik Melayu, nasi kuning, cabang baru di Golden City Bengkong.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'Teh_Tarik_Belakang.jpg'
            ],
            [
                'name' => 'Masjid Agung Hamidah',
                'address' => 'Jl. Engku Putri, Tlk. Tering, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29444',
                'latitude' => 1.1264951,
                'longitude' => 104.0504505,
                'description' => 'Masjid Agung Raja Hamidah adalah ikon Kota Batam yang dikenal dengan arsitektur kubahnya yang unik berbentuk limas dan berfungsi sebagai pusat ibadah serta wisata religi.',
                'category' => 'Attraction',
                'subcategory' => 'Heritage Site',
                'image' => 'Masjid_Agung_Hamidah.jpg'
            ],
            [
                'name' => 'Nagoya Hill',
                'address' => 'Jl. Teuku Umar, Lubuk Baja Kota, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29444',
                'latitude' => 1.14488,
                'longitude' => 104.01524,
                'description' => 'Nagoya Hill adalah salah satu mal terbesar di Batam yang menjadi pusat perbelanjaan favorit bagi wisatawan lokal dan mancanegara, menawarkan berbagai produk fashion, elektronik, dan kuliner.',
                'category' => 'Attraction',
                'subcategory' => 'Mall',
                'image' => 'Nagoya_Hill.jpg'
            ],
            [
                'name' => 'Vihara Duta Maitreya',
                'address' => 'Jl. Laksamana Bintan, Sungai Panas, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29433',
                'latitude' => 1.131100,
                'longitude' => 104.048700,
                'description' => 'Vihara Duta Maitreya merupakan salah satu vihara terbesar di Asia Tenggara yang tidak hanya berfungsi sebagai tempat ibadah, tetapi juga sebagai destinasi wisata religi yang megah dan damai.',
                'category' => 'Attraction',
                'subcategory' => 'Heritage Site',
                'image' => 'Vihara_Duta_Maitreya.jpg'
            ],
            [
                'name' => 'Mega Mall Batam Center',
                'address' => 'Jl. Engku Putri, Tlk. Tering, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29461',
                'latitude' => 1.12720,
                'longitude' => 104.05190,
                'description' => 'Mega Mall Batam Center adalah mal modern yang terhubung langsung dengan Terminal Feri Internasional Batam Center, menjadikannya destinasi belanja yang strategis dan lengkap bagi para pelancong.',
                'category' => 'Attraction',
                'subcategory' => 'Mall',
                'image' => 'Mega_Mall.jpg'
            ],
            [
                'name' => 'Jembatan Barelang',
                'address' => 'Jembatan Barelang, Bulang, Kota Batam, Kepulauan Riau',
                'latitude' => 1.0500,
                'longitude' => 104.0167,
                'description' => 'Jembatan Barelang adalah ikon megah Kota Batam yang terdiri dari enam jembatan yang menghubungkan beberapa pulau, menawarkan pemandangan laut yang spektakuler dan menjadi spot foto favorit wisatawan.',
                'category' => 'Attraction',
                'subcategory' => 'Heritage Site',
                'image' => 'Jembatan_Barelang.jpg'
            ],
            [
                'name' => 'Mega Wisata Ocarina Batam',
                'address' => 'Jl. Engku Putri, Tlk. Tering, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29461',
                'latitude' => 1.138600,
                'longitude' => 104.062500,
                'description' => 'Mega Wisata Ocarina Batam adalah taman hiburan tepi laut yang menawarkan berbagai wahana permainan, spot foto unik seperti patung shio, serta area konser yang sering menggelar acara besar.',
                'category' => 'Attraction',
                'subcategory' => 'Nature Attraction',
                'image' => 'Ocarina_Batam.jpg'
            ],
            [
                'name' => 'Grand Batam Mall',
                'address' => 'Jl. Pembangunan, Batu Selicin, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29444',
                'latitude' => 1.1441,
                'longitude' => 104.0083,
                'description' => 'Grand Batam Mall merupakan salah satu pusat perbelanjaan terbaru dan termewah di Batam, yang dilengkapi dengan berbagai tenant merek internasional, bioskop modern, dan pilihan kuliner yang beragam.',
                'category' => 'Attraction',
                'subcategory' => 'Mall',
                'image' => 'Grand_Batam_Mall.jpg'
            ],
            [
                'name' => 'Taman Rusa Sekupang',
                'address' => 'Jl. RE Martadinata, Tj. Pinggir, Kec. Sekupang, Kota Batam, Kepulauan Riau 29425',
                'latitude' => 1.1097,
                'longitude' => 103.9486,
                'description' => 'Taman Rusa Sekupang adalah destinasi wisata alam keluarga yang menawarkan pengalaman berinteraksi langsung dengan rusa-rusa jinak di area hijau yang luas dan asri.',
                'category' => 'Attraction',
                'subcategory' => 'Nature Attraction',
                'image' => 'Taman_Rusa_Sekupang.jpg'
            ],
            [
                'name' => 'Pantai Nongsa',
                'address' => 'Sambau, Kecamatan Nongsa, Kota Batam, Kepulauan Riau',
                'latitude' => 1.1833,
                'longitude' => 104.0833,
                'description' => 'Pantai Nongsa terkenal dengan pasir putihnya yang lembut dan pemandangan cakrawala Singapura yang terlihat jelas, menjadikannya lokasi yang sempurna untuk bersantai dan menikmati matahari terbenam.',
                'category' => 'Attraction',
                'subcategory' => 'Nature Attraction',
                'image' => 'Pantai_Nongsa.jpg'
            ],
            [
                'name' => 'Bukit Senyum',
                'address' => 'Kp. Seraya, Batu Ampar, Batam City, Riau Islands 29454',
                'latitude' => 1.1578,
                'longitude' => 104.0152,
                'description' => 'Bukit Senyum adalah salah satu titik tertinggi di Batam yang menawarkan pemandangan panorama kota dan gemerlap lampu Singapura di malam hari, menjadikannya tempat favorit untuk bersantai.',
                'category' => 'Attraction',
                'subcategory' => 'Nature Attraction',
                'image' => 'Bukit_Senyum.jpg'
            ],
            [
                'name' => 'Welcome To Batam',
                'address' => 'Jl. Engku Putri, Tlk. Tering, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29461',
                'latitude' => 1.1275,
                'longitude' => 104.0483,
                'description' => 'Tulisan ikonik "Welcome to Batam" yang terletak di atas Bukit Clara adalah landmark kebanggaan kota yang sering menjadi latar belakang foto wajib bagi setiap pengunjung yang datang ke Batam.',
                'category' => 'Attraction',
                'subcategory' => 'Heritage Site',
                'image' => 'Welcome_To_Batam.jpg'
            ],
            [
                'name' => 'One Batam Mall',
                'address' => 'Jl. Raja H. Fisabilillah, Tlk. Tering, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29444',
                'latitude' => 1.1340,
                'longitude' => 104.0435,
                'description' => 'One Batam Mall adalah pusat perbelanjaan modern yang menawarkan pengalaman belanja lengkap dengan berbagai toko ritel, area hiburan, serta pilihan food court yang beragam untuk semua kalangan.',
                'category' => 'Attraction',
                'subcategory' => 'Mall',
                'image' => 'One_Batam_Mall.jpg'
            ],

            // =========================================================
            // ====== DATA BARU (DARI TEKS YANG ANDA BERIKAN) ======
            // =========================================================
            [
                'name' => 'Labers Coffee',
                'address' => 'Komplek Pasar Mitra Raya 2 blok A1-3, Batam',
                'latitude' => 1.106118,
                'longitude' => 104.033392,
                'description' => 'Kedai kopi yang sudah beroperasi sejak 2019 dengan dua lokasi utama.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Labers_Coffee.jpg'
            ],
            [
                'name' => 'Cafe Boemi',
                'address' => 'Jalan Sudirman Center, Batam Centre',
                'latitude' => 1.132524,
                'longitude' => 104.049155,
                'description' => 'Kafe unik dengan konsep unfinished, menawarkan suasana nyaman untuk nongkrong sekaligus ruang untuk kegiatan seperti seminar dan workshop.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'Cafe_Boemi.jpg'
            ],
            [
                'name' => 'Muso Art Cafe',
                'address' => 'Palm Spring Blok E/104, Batam Center',
                'latitude' => 1.125107,
                'longitude' => 104.030182,
                'description' => 'Museum cafe pertama di Batam dengan suasana artistik yang banyak spot foto menarik.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'Muso_Art_Cafe.jpg'
            ],
            [
                'name' => 'Kebon Coffee',
                'address' => 'Jl. Palm Spring No. 3, Taman Baloi, Batam Kota',
                'latitude' => 1.123563,
                'longitude' => 104.027796,
                'description' => 'Kafe dengan suasana minimalis yang asyik, cocok untuk nongkrong sambil menikmati kopi.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Kebon_Coffee.jpg'
            ],
            [
                'name' => 'Kopi Nako Batam',
                'address' => 'Jl. Raja Haji Fisabilillah, Sungai Panas, Batam Kota',
                'latitude' => 1.126902,
                'longitude' => 104.026301,
                'description' => 'Cabang kafe kopi populer dengan konsep modern minimalis dan tema monokrom.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Kopi_Nako_Batam.jpg'
            ],
            [
                'name' => 'Amati Coffee',
                'address' => 'Jl. Raja Haji Fisabilillah, Sungai Panas, Batam Center',
                'latitude' => 1.127486,
                'longitude' => 104.033192,
                'description' => 'Kedai kopi nyaman dengan suasana seperti di rumah, cocok untuk kumpul atau santai.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Amati_Coffee.jpg'
            ],
            [
                'name' => 'Ài Volla Cafe',
                'address' => 'Jl. Raja Haji Fisabilillah Komplek Raffless City No.1 Blok A, Batam Center',
                'latitude' => 1.132458,
                'longitude' => 104.040891,
                'description' => 'Kafe dan resto aesthetic yang menyajikan masakan Indonesia, Western, dan Chinese food.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'Ai_Volla_Cafe.jpg'
            ],
            [
                'name' => 'See Sea Harbourbay Batam',
                'address' => 'Blok 8F, The Promenade Harbourbay, Batu Ampar, Batam',
                'latitude' => 1.155602,
                'longitude' => 103.994947,
                'description' => 'Restoran seafood dengan konsep 2-in-1 sebagai tempat makan dan sea bar dengan suasana modern.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'See_Sea_Harbourbay.jpg'
            ],
            [
                'name' => 'Garden Bay',
                'address' => 'Blok 8E The Promenade, Harbour Bay Downtown, Batam',
                'latitude' => 1.155295,
                'longitude' => 103.995736,
                'description' => 'Restoran baru dengan gaya lounge seperti nuansa New York tahun 90-an di tepi laut.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'Garden_Bay.jpg'
            ],
            [
                'name' => 'Port House Resto & Bar',
                'address' => 'The Promenade Blok 8C, Harbour Bay Downtown, Jl. Duyung, Batu Ampar, Batam',
                'latitude' => 1.155214,
                'longitude' => 103.995872,
                'description' => 'Restoran dan bar dengan suasana pinggir laut yang cozy dan pemandangan sunset menawan.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'Port_House.jpg'
            ],
            [
                'name' => 'Momoo Juice Bar & Coffee',
                'address' => 'The Promenade, Block 8b Harbour Bay Downtown, Jl. Duyung, Sungai Jodoh, Batam',
                'latitude' => 1.154954,
                'longitude' => 103.996201,
                'description' => 'Kafe yang populer sebagai tempat cozy dan nyaman untuk bersantai, cocok untuk keluarga.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Momoo_Juice_Bar.jpg'
            ],
            [
                'name' => 'Common Space Coffee & Bar',
                'address' => 'Komplek Bumi Indah Blok B No.4, dekat Harbour Bay',
                'latitude' => 1.147626,
                'longitude' => 104.009852,
                'description' => 'Kafe cozy dengan kombinasi desain indoor yang homey dan area outdoor dengan konsep camping.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Common_Space.jpg'
            ],
            [
                'name' => 'Bel\'s Haus',
                'address' => 'Jl. Imam Bonjol No.1, Lubuk Baja Kota, Batam',
                'latitude' => 1.140929,
                'longitude' => 104.016210,
                'description' => 'Kafe populer dengan suasana cozy dan pilihan area indoor dan outdoor yang memiliki view cantik.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'Bels_Haus.jpg'
            ],
            [
                'name' => 'Fore Coffee',
                'address' => 'Jl. Pembangunan Blok A No. 2-4, Batu Selicin, Lubuk Baja',
                'latitude' => 1.135066,
                'longitude' => 104.008248,
                'description' => 'Kafe populer yang menawarkan berbagai minuman kopi spesial dengan harga terjangkau.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Fore_Coffee.jpg'
            ],
            [
                'name' => 'Local Cafe "Coffee & Space"',
                'address' => 'Ruko Permata Regency Blok AA no.6-8, Baloi Indah',
                'latitude' => 1.125766,
                'longitude' => 104.005989,
                'description' => 'Kafe cozy dengan menu kopi dan makanan Nusantara yang variatif dan ramah di kantong.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Local_Cafe.jpg'
            ],
            [
                'name' => 'Button Coffee Batam',
                'address' => 'Komplek Pertokoan Golden Wealth, Tiban Indah, Batam',
                'latitude' => 1.113263,
                'longitude' => 103.977818,
                'description' => 'Kafe dengan inspirasi suasana kafe di Malang serta Surabaya, dengan sentuhan unik.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Button_Coffee.jpg'
            ],
            [
                'name' => 'CBD Coffee',
                'address' => 'Komplek Ruko Batu Aji Centre Blok B No.3-10, Batam',
                'latitude' => 1.045359,
                'longitude' => 103.964454,
                'description' => 'Kafe dengan konsep Industrial Kopitiam pertama di Batam.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'CBD_Coffee.jpg'
            ],
            [
                'name' => 'Bidjeh Kopi SP Plaza Batam',
                'address' => 'Pertokoan SP Plaza Blok F1&2, Tembesi, Sagulung, Batam',
                'latitude' => 1.041678,
                'longitude' => 103.980489,
                'description' => 'Kedai kopi khas Aceh dengan harga yang sangat terjangkau.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Bidjeh_Kopi.jpg'
            ],
            [
                'name' => 'Morning Bakery',
                'address' => 'Kawasan Sungai Harapan, Kecamatan Sekupang, Batam',
                'latitude' => 1.109248,
                'longitude' => 103.958095,
                'description' => 'Sangat populer untuk mendapatkan roti dan kue segar setiap hari.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Other FB Services',
                'image' => 'Morning_Bakery.jpg'
            ],
            [
                'name' => 'Kantin Vitka',
                'address' => 'Vitka City Tiban, Tiban, Kota Batam',
                'latitude' => 1.107435,
                'longitude' => 103.978507,
                'description' => 'Area kuliner di wilayah Vitka City Tiban yang mendukung pengembangan usaha kuliner lokal dan UMKM.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'Kantin_Vitka.jpg'
            ],
            [
                'name' => 'Food Point Nagoya Hill Mall',
                'address' => 'Nagoya Hill Mall Lantai 3, Batam',
                'latitude' => 1.146194,
                'longitude' => 104.012221,
                'description' => 'Food court yang terletak di lantai 3 dekat Studio 21, menawarkan berbagai macam pilihan makanan.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'Food_Point_Nagoya.jpg'
            ],
            [
                'name' => '168 Foodcourt',
                'address' => 'Dekat Nagoya Hill Mall, Batam',
                'latitude' => 1.148540,
                'longitude' => 104.013550,
                'description' => 'Pusat kuliner populer yang menawarkan berbagai pilihan makanan khas Asia dan Indonesia.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => '168_Foodcourt.jpg'
            ],
            [
                'name' => 'Food Market Tamrin',
                'address' => 'Komplek Nagoya Thamrin City, Lubuk Baja, Kota Batam',
                'latitude' => 1.144186,
                'longitude' => 104.014773,
                'description' => 'Pusat kuliner terbesar dan terlengkap yang menawarkan lebih dari 500 jenis makanan.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'Food_Market_Tamrin.jpg'
            ],
            [
                'name' => 'Nagoya Thamrin Kopitiam',
                'address' => 'Jalan Imam Bonjol, Lubuk Baja, Kota Batam',
                'latitude' => 1.143986,
                'longitude' => 104.015063,
                'description' => 'Pusat kuliner dengan konsep kopitiam modern dan suasana yang nyaman.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Nagoya_Thamrin_Kopitiam.jpg'
            ],
            [
                'name' => 'A2 Nagoya',
                'address' => 'Kawasan Nagoya Thamrin City, Lubuk Baja',
                'latitude' => 1.134717,
                'longitude' => 104.009339,
                'description' => 'Pusat kuliner dan tempat nongkrong dengan konsep modern dan Instagramable.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'A2_Nagoya.jpg'
            ],
            [
                'name' => 'Astro Kopitiam Batam',
                'address' => 'Batu Selicin, Lubuk Baja, Batam Kota',
                'latitude' => 1.135104,
                'longitude' => 104.008619,
                'description' => 'Restoran dan pusat kuliner yang terkenal dengan hidangan mie pangsit.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'Astro_Kopitiam.jpg'
            ],
            [
                'name' => 'SNL Food Batam',
                'address' => 'Komplek ruko Permata Hijau, Batam Centre',
                'latitude' => 1.141463,
                'longitude' => 103.999139,
                'description' => 'Pusat kuliner modern dengan konsep food street dan jajan corner.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'SNL_Food.jpg'
            ],
            [
                'name' => 'Harbourbay Foodcourt',
                'address' => 'Jalan Duyung, Sei Jodoh, Batu Ampar',
                'latitude' => 1.152728,
                'longitude' => 103.998237,
                'description' => 'Pusat kuliner terkenal dengan pilihan seafood segar dan pemandangan pantai.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'Harbourbay_Foodcourt.jpg'
            ],
            [
                'name' => 'HU Foodcourt',
                'address' => 'Jl. Rosedale, Teluk Tering, Batam Kota',
                'latitude' => 1.120420,
                'longitude' => 104.035291,
                'description' => 'Foodcourt baru yang luas dan nyaman, cocok untuk nongkrong atau makan bersama keluarga.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'HU_Foodcourt.jpg'
            ],
            [
                'name' => 'Nagoya Foodcourt Batam',
                'address' => 'Simpang Lima Nagoya, Batam',
                'latitude' => 1.141974,
                'longitude' => 104.006706,
                'description' => 'Food court terbesar dan populer di jantung kota Nagoya.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'Nagoya_Foodcourt.jpg'
            ],
            [
                'name' => 'One Boulevard Foodcourt',
                'address' => 'Lantai dasar One Batam Mall',
                'latitude' => 1.129449,
                'longitude' => 104.045372,
                'description' => 'Food court semi-indoor dengan konsep kopitiam yang nyaman dan cozy.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'One_Boulevard_Foodcourt.jpg'
            ],
            [
                'name' => 'One Food Street',
                'address' => 'Lantai basement One Batam Mall',
                'latitude' => 1.130210,
                'longitude' => 104.046470,
                'description' => 'Foodcourt bertema yang menyajikan berbagai aneka makanan dan minuman tradisional nusantara.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'One_Food_Street.jpg'
            ],
            [
                'name' => '98 Foodcourt',
                'address' => 'Kawasan Batu Selicin, Lubuk Baja',
                'latitude' => 1.138049,
                'longitude' => 104.002199,
                'description' => 'Salah satu foodcourt terbesar dengan ruang terbuka yang luas dan panggung hiburan.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => '98_Foodcourt.jpg'
            ],
            [
                'name' => 'A&W Batam',
                'address' => 'Ruko Mitra Raya, Batam',
                'latitude' => 1.111627,
                'longitude' => 103.947522,
                'description' => 'Restoran cepat saji yang ikonik dengan menu khas seperti Golden Aroma Chicken dan Root Beer.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'AW_Batam.jpg'
            ],
            [
                'name' => 'Burger King',
                'address' => 'Kawasan Tanjungpantun, Jodoh, Batuampar',
                'latitude' => 1.120992,
                'longitude' => 104.049340,
                'description' => 'Restoran cepat saji yang menawarkan burger dengan daging sapi Australia 100% berkualitas.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'Burger_King.jpg'
            ],
            [
                'name' => 'Food Corner',
                'address' => 'Pusat Kota Batam',
                'latitude' => 1.135933,
                'longitude' => 104.006283,
                'description' => 'Area kuliner yang menawarkan berbagai jenis makanan dan minuman dengan harga bersahabat.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Cafetaria',
                'image' => 'Food_Corner.jpg'
            ],
            [
                'name' => 'Mako Cake & Bakery',
                'address' => 'Outlet J.CO, Batam',
                'latitude' => 1.120845,
                'longitude' => 104.048887,
                'description' => 'Boutique bakery dengan sentuhan Jepang yang menghadirkan berbagai pilihan roti, kue, dan pastry premium.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Other FB Services',
                'image' => 'Mako_Bakery.jpg'
            ],
            [
                'name' => 'KFC',
                'address' => 'Komplek Fanindo Sanctuary Garden, Batam Center',
                'latitude' => 1.120751,
                'longitude' => 104.048631,
                'description' => 'Restoran cepat saji internasional yang terkenal dengan ayam goreng renyah dan lezat.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'KFC.jpg'
            ],
            [
                'name' => 'Marugame Udon',
                'address' => 'Grand Batam Mall, Batam',
                'latitude' => 1.120540,
                'longitude' => 104.048323,
                'description' => 'Restoran khas Jepang yang menyajikan hidangan udon dan tempura otentik.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'Marugame_Udon.jpg'
            ],
            [
                'name' => 'McDonald\'s',
                'address' => 'Jalan Brigjen Katamso, Tanjung Uncang, Batuaji',
                'latitude' => 1.121130,
                'longitude' => 104.049672,
                'description' => 'Restoran cepat saji global dengan layanan 24 jam dan drive-thru.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'McDonalds.jpg'
            ],
            [
                'name' => 'Reddog',
                'address' => 'Green Land, Batam',
                'latitude' => 1.124511,
                'longitude' => 104.047324,
                'description' => 'Menghadirkan cita rasa camilan Korea otentik seperti Korean Hotdog dan Topokki.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'Reddog.jpg'
            ],
            [
                'name' => 'HokBen',
                'address' => 'Batam',
                'latitude' => 1.121161,
                'longitude' => 104.049566,
                'description' => 'Pelopor konsep "Japanese Fast Food" di Indonesia yang menggabungkan cita rasa autentik Jepang dengan selera lokal.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'HokBen.jpg'
            ],
            [
                'name' => 'Richeese Factory',
                'address' => 'Komplek King Business Center (KBC) Batam',
                'latitude' => 1.126146,
                'longitude' => 104.099680,
                'description' => 'Ayam goreng krispi khas dengan saus keju yang lezat.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Restaurant',
                'image' => 'Richeese_Factory.jpg'
            ],
            [
                'name' => 'Starbucks Fanindo',
                'address' => 'Komplek Fanindo Sanctuary Garden, Batam',
                'latitude' => 1.120867,
                'longitude' => 104.049114,
                'description' => 'Gerai kopi dengan layanan drive-thru pertama di Indonesia.',
                'category' => 'Food & Beverages',
                'subcategory' => 'Coffee Shop',
                'image' => 'Starbucks_Fanindo.jpg'
            ],
            [
                'name' => 'Rumah Sakit Awal Bros Batam',
                'address' => 'Jl. Gajah Mada No.Kav. 1, Tlk. Tering, Kec. Batam Kota, Kota Batam',
                'latitude' => 1.123461,
                'longitude' => 104.016798,
                'description' => 'Rumah sakit yang berdiri sejak 26 Juni 2003, berlokasi di pusat kota dan memiliki kapasitas 212 tempat tidur. Merupakan rumah sakit rujukan dengan layanan unggulan seperti pusat jantung, onkologi, dan UGD 24 jam. Telah terakreditasi KARS tingkat paripurna serta ISO 9001.',
                'category' => 'Public Information',
                'subcategory' => 'Hospital',
                'image' => 'RS_Awal_Bros.jpg'
            ],
            [
                'name' => 'Rumah Sakit Badan Pengusahaan Batam (RSBP Batam)',
                'address' => 'Jl. Dr. Cipto Mangunkusumo No.1, Tj. Pinggir, Kec. Sekupang, Kota Batam',
                'latitude' => 1.129472,
                'longitude' => 103.932402,
                'description' => 'Rumah sakit yang didirikan tahun 1971, awalnya poliklinik dan menjadi Tipe C pada 1983. Terletak di Sekupang dengan pemandangan laut dan Singapura, RSBP menyediakan layanan unggulan seperti pusat jantung, layanan onkologi, serta telah mendapatkan akreditasi paripurna.',
                'category' => 'Public Information',
                'subcategory' => 'Hospital',
                'image' => 'RSBP_Batam.jpg'
            ],
            [
                'name' => 'Rumah Sakit Umum Daerah Embung Fatimah',
                'address' => 'Jl. R. Suprapto, Buliang, Kec. Batu Aji, Kota Batam',
                'latitude' => 1.050054,
                'longitude' => 103.968260,
                'description' => 'Fasilitas kesehatan milik pemerintah Kota Batam, didirikan pada tahun 1986. Menjadi RSUD Tipe D pada tahun 2004 dengan kapasitas 55 tempat tidur dan berkembang menjadi Tipe C pada 2010. RSUD ini menjadi rumah sakit terkemuka dan pusat trauma center regional.',
                'category' => 'Public Information',
                'subcategory' => 'Hospital',
                'image' => 'RSUD_Embung_Fatimah.jpg'
            ],
            [
                'name' => 'Rumah Sakit HJ. Bunda Halimah',
                'address' => 'Jl. Gajah Mada, Komplek, Jl. Ruko Tiban Mas No.1-6, Tiban Indah, Kec. Sekupang, Kota Batam',
                'latitude' => 1.106497,
                'longitude' => 104.083633,
                'description' => 'Rumah sakit swasta yang didirikan pada tahun 2018. Berlokasi strategis di Tiban, hanya 15 menit dari Bandara Hang Nadim dan Terminal Feri Internasional Batam Center. Didukung oleh tenaga medis berpengalaman dan fasilitas lengkap seperti UGD, ICU, laboratorium, dan radiologi.',
                'category' => 'Public Information',
                'subcategory' => 'Hospital',
                'image' => 'RS_Bunda_Halimah.jpg'
            ],
            [
                'name' => 'Rumah Sakit Santa Elisabeth Batam',
                'address' => 'Jl. Anggrek No.1, Tlk. Tering, Kec. Batam Kota, Kota Batam',
                'latitude' => 1.107345,
                'longitude' => 104.979444,
                'description' => 'Rumah sakit swasta katolik yang diresmikan sebagai Rumah Sakit Umum Tipe C pada 17 November 2015. Didirikan oleh para Suster Fransiskanes Sambas (FSE) dan dikelola oleh PT. Harapan Abadi Kencana. Dilengkapi dengan fasilitas modern dan tenaga medis profesional.',
                'category' => 'Public Information',
                'subcategory' => 'Hospital',
                'image' => 'RS_Santa_Elisabeth.jpg'
            ],
            [
                'name' => 'Polres Barelang',
                'address' => 'Jl. Sudirman No.46, Tlk. Tering, Kec. Batam Kota, Kota Batam',
                'latitude' => 1.118813,
                'longitude' => 104.020544,
                'description' => 'Kepolisian Resor Kota yang berfungsi untuk menjaga keamanan dan ketertiban wilayah Batam. Dipimpin oleh Kapolresta dan memiliki berbagai satuan kerja (satker) seperti Satlantas, Satreskrim, dan lainnya untuk menjalankan tugas kepolisian.',
                'category' => 'Public Information',
                'subcategory' => 'Police Station',
                'image' => 'Polres_Barelang.jpg'
            ],
            [
                'name' => 'I Hotel Baloi',
                'address' => 'Komplek Baloi Kusuma Indah No.7, Batu Selicin, Kec. Lubuk Baja, Kota Batam',
                'latitude' => 1.137399,
                'longitude' => 104.008132,
                'description' => 'Hotel modern yang terletak di Kecamatan Lubuk Baja, dekat dengan pusat perbelanjaan BCS Mall. Menawarkan kamar nyaman, resepsionis 24 jam, kolam renang, pusat kebugaran, dan restoran.',
                'category' => 'Accommodation',
                'subcategory' => 'Hotel',
                'image' => 'I_Hotel_Baloi.jpg'
            ],
            [
                'name' => 'Ando Hotel',
                'address' => 'Jl. Teuku Umar, Kp. Seraya, Kec. Batu Ampar, Kota Batam',
                'latitude' => 1.149075,
                'longitude' => 104.011332,
                'description' => 'Hotel bintang 3 yang terletak di Nagoya, dekat dengan Nagoya Hill. Menyediakan kamar dengan AC dan TV, resepsionis 24 jam, serta layanan concierge, laundry, dan penyewaan mobil.',
                'category' => 'Accommodation',
                'subcategory' => 'Hotel',
                'image' => 'Ando_Hotel.jpg'
            ],
            [
                'name' => 'ARTOTEL Batam',
                'address' => 'Jl. Pembangunan, Batu Selicin, Kec. Lubuk Baja, Kota Batam',
                'latitude' => 1.139908,
                'longitude' => 104.008722,
                'description' => 'Hotel bintang 4 di Lubuk Baja, berlokasi strategis di komplek Pertokoan Penuin Center. Menawarkan kamar-kamar modern dengan sentuhan seni, fasilitas lengkap, dan akses mudah ke pusat perbelanjaan dan destinasi wisata.',
                'category' => 'Accommodation',
                'subcategory' => 'Hotel',
                'image' => 'ARTOTEL_Batam.jpg'
            ],
            [
                'name' => 'AP Premier Batam',
                'address' => 'Jl. Gajah Mada, Sei Ladi, Kec. Sekupang, Kota Batam',
                'latitude' => 1.146075,
                'longitude' => 104.019718,
                'description' => 'Hotel bintang 4 di Nagoya, menawarkan akomodasi mewah dengan kolam renang indoor dan outdoor, pusat kebugaran, restoran dengan masakan Indonesia dan internasional, serta layanan kamar 24 jam.',
                'category' => 'Accommodation',
                'subcategory' => 'Hotel',
                'image' => 'AP_Premier_Batam.jpg'
            ],
            [
                'name' => 'Aston Hotel & Residence',
                'address' => 'Jl. Sriwijaya No.1, Kp. Pelita, Kec. Lubuk Baja, Kota Batam',
                'latitude' => 1.12890,
                'longitude' => 104.020896,
                'description' => 'Hotel bintang 4 di pusat kota, dekat dengan pusat perbelanjaan Nagoya Hill. Menawarkan kamar dan apartemen modern, fasilitas lengkap seperti kolam renang, spa, pusat kebugaran, dan restoran.',
                'category' => 'Accommodation',
                'subcategory' => 'Hotel',
                'image' => 'Aston_Hotel.jpg'
            ],
            [
                'name' => 'I Hotel',
                'address' => 'Jl. Teuku Umar No.1, Kp. Seraya, Kec. Batu Ampar, Kota Batam',
                'latitude' => 1.134539,
                'longitude' => 104.008347,
                'description' => 'Hotel bintang 4 yang terletak strategis di Jalan Teuku Umar, Nagoya. Menawarkan kamar modern dengan AC, TV, dan minibar, serta fasilitas kolam renang, spa, dan pusat kebugaran.',
                'category' => 'Accommodation',
                'subcategory' => 'Hotel',
                'image' => 'I_Hotel.jpg'
            ],
            [
                'name' => 'Harmoni Hotel',
                'address' => 'Jl. Imam Bonjol, Sungai Jodoh, Kec. Batu Ampar, Kota Batam',
                'latitude' => 1.154527,
                'longitude' => 103.997380,
                'description' => 'Hotel bintang 4 yang terletak di pusat perbelanjaan Batam, dekat dengan Nagoya. Menawarkan kamar nyaman dengan AC, TV, dan Wi-Fi gratis, serta fasilitas kolam renang outdoor, pusat kebugaran, dan restoran.',
                'category' => 'Accommodation',
                'subcategory' => 'Hotel',
                'image' => 'Harmoni_Hotel.jpg'
            ],
            [
                'name' => 'Planet Holiday Hotel & Residence',
                'address' => 'Jl. Raja Ali H., Sungai Jodoh, Kec. Batu Ampar, Kota Batam',
                'latitude' => 1.151794,
                'longitude' => 104.007743,
                'description' => 'Hotel bintang 4 di Nagoya, menawarkan kamar modern dengan AC, TV, dan minibar. Fasilitas lengkap termasuk kolam renang, spa, pusat kebugaran, dan berbagai pilihan restoran.',
                'category' => 'Accommodation',
                'subcategory' => 'Hotel',
                'image' => 'Planet_Holiday_Hotel.jpg'
            ],
            [
                'name' => 'Hotel Pacific Palace',
                'address' => 'Jl. Duyung, Sungai Jodoh, Kec. Batu Ampar, Kota Batam',
                'latitude' => 1.155332,
                'longitude' => 104.047136,
                'description' => 'Bagian dari mega super blok Pollux Meisterstadt. Berlokasi di pusat kota Batam dengan desain interior yang megah dan fasilitas mewah. Cocok bagi wisatawan bisnis maupun liburan.',
                'category' => 'Accommodation',
                'subcategory' => 'Hotel',
                'image' => 'Hotel_Pacific_Palace.jpg'
            ],
            [
                'name' => 'Swiss-Belhotel Harbour Bay',
                'address' => 'Jl. Duyung, Sungai Jodoh, Kec. Batu Ampar, Kota Batam',
                'latitude' => 1.153794,
                'longitude' => 104.000877,
                'description' => 'Hotel bintang 4 yang terletak strategis di kawasan Harbour Bay, terhubung langsung dengan terminal feri. Menawarkan kamar modern dengan pemandangan laut, fasilitas lengkap, dan akses mudah ke pusat perbelanjaan.',
                'category' => 'Accommodation',
                'subcategory' => 'Hotel',
                'image' => 'Swiss_Belhotel.jpg'
            ],

        ];

        // Loop untuk menyalin dan membuat entri
        foreach ($places as $place) {
            $imageName = $place['image'];
            $sourcePath = 'seed_images/' . $imageName;
            $destinationPath = 'uploads/' . $imageName;

            // Pastikan file disalin hanya jika belum ada di public
            if (Storage::disk('local')->exists($sourcePath) && !Storage::disk('public')->exists($destinationPath)) {
                Storage::disk('public')->put($destinationPath, Storage::disk('local')->get($sourcePath));
            }

            // Perbarui jalur gambar sebelum membuat entri
            $place['image'] = '/uploads/' . $imageName;
            // Kode Baru yang Lebih Aman
            Place::firstOrCreate(['name' => $place['name']], $place);
        }
    }
}