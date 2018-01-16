<!DOCTYPE html>
<!--
NuLife Website - Front
Version: 1.0.0
Author: NuLife Dev Team
Site: https://www.nulife.co.id
-->
<!--[if IE 9]> <html lang="{{ config('app.locale') }}" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ config('app.locale') }}">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>code of conduct | nulife.co.id</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="" />
    <meta content="" name="" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ asset('web-assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link href="{{ asset('web-assets/css/plugins/socicon/socicon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/bootstrap-social/bootstrap-social.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/animate/animate.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN: BASE PLUGINS  -->
    <link href="{{ asset('web-assets/css/plugins/owl-carousel/assets/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet" type="text/css" />
    <!-- END: BASE PLUGINS -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{ asset('web-assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css" />
    <link href="{{ asset('web-assets/css/themes/default.css') }}" rel="stylesheet" id="style_theme" type="text/css" />
    <link href="{{ asset('web-assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon_.ico') }}" /> </head>

<body class="c-layout-header-fixed c-layout-header-mobile-fixed c-layout-header-topbar c-layout-header-topbar-collapse">
<div class="loader">
    <div class="send">
        <div class="send-indicator">
            <div class="send-indicator-dot"></div>
            <div class="send-indicator-dot"></div>
            <div class="send-indicator-dot"></div>
            <div class="send-indicator-dot"></div>
        </div>
    </div>
    <div class="sent-icon">
        <img src="{{ asset('web-assets/img/logohijau.png') }}">
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="800">
        <defs>
            <filter id="goo">
                <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
                <feComposite in="SourceGraphic" in2="goo" operator="atop"/>
            </filter>
            <filter id="goo-no-comp">
                <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
            </filter>
        </defs>
    </svg>
</div>
<!-- BEGIN: LAYOUT/HEADERS/HEADER-1 -->
<!-- BEGIN: HEADER -->
<header class="c-layout-header c-layout-header-3 c-layout-header-3-custom-menu c-layout-header-default-mobile" data-minimize-offset="80">
    <div class="c-topbar c-topbar-light c-solid-bg">
        <div class="container">
            <!-- BEGIN: INLINE NAV -->
            <nav class="c-top-menu c-pull-right">
                <ul class="c-links c-theme-ul">
                    <li>
                        <a href="#">Help</a>
                    </li>
                    <li class="c-divider">|</li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                    <li class="c-divider">|</li>
                    <li>
                        <a href="#">FAQ</a>
                    </li>
                </ul>
                <ul class="c-ext c-theme-ul">
                    <li class="c-lang dropdown c-last">
                        <a href="#">&nbsp;&nbsp;</a>
                    </li>
                </ul>
            </nav>
            <!-- END: INLINE NAV -->
        </div>
    </div>
    <div class="c-navbar">
        <div class="container">
            <!-- BEGIN: BRAND -->
            <div class="c-navbar-wrapper clearfix">
                <div class="c-brand c-pull-left">
                    <a href="{{ url('/') }}" class="c-logo">
                        <img src="{{ asset('web-assets/img/logo-3.png') }}" alt="NuLife" class="c-desktop-logo">
                        <img src="{{ asset('web-assets/img/logo-3i.png') }}" alt="NuLife" class="c-desktop-logo-inverse">
                        <img src="{{ asset('web-assets/img/logo-3m.png') }}" alt="NuLife" class="c-mobile-logo"> </a>
                    <button class="c-hor-nav-toggler" type="button" data-target=".c-mega-menu">
                        <span class="c-line"></span>
                        <span class="c-line"></span>
                        <span class="c-line"></span>
                    </button>
                    <button class="c-topbar-toggler" type="button">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                </div>
                <!-- END: BRAND -->
                <!-- BEGIN: HOR NAV -->
                <!-- BEGIN: LAYOUT/HEADERS/MEGA-MENU -->
                <!-- BEGIN: MEGA MENU -->
                <!-- Dropdown menu toggle on mobile: c-toggler class can be applied to the link arrow or link itself depending on toggle mode -->
                <nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold">
                    <ul class="nav navbar-nav c-theme-nav">
                        <li class="c-active c-link dropdown-toggle">
                            <a href="{{ url('/') }}" class="c-link dropdown-toggle">Home
                                <span class="c-arrow c-toggler"></span>
                            </a>
                        </li>
                        <li class="c-menu-type-classic">
                            <a href="javascript:;" class="c-link dropdown-toggle">About
                                <span class="c-arrow c-toggler"></span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="c-link dropdown-toggle">Why Us
                                <span class="c-arrow c-toggler"></span>
                            </a>
                        </li>
                        <li class="c-menu-type-classic">
                            <a href="javascript:;" class="c-link dropdown-toggle">Products
                                <span class="c-arrow c-toggler"></span>
                            </a>
                        </li>
                        <li class="c-menu-type-classic">
                            <a href="javascript:;" class="c-link dropdown-toggle">Plan
                                <span class="c-arrow c-toggler"></span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" class="c-link dropdown-toggle">NuVision
                                <span class="c-arrow c-toggler"></span>
                            </a>
                        </li>
                        @if (Auth::check())
                            @if (Auth::user()->isAdmin())
                                <li>
                                    <a href="{{ route('admin') }}" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                                        <i class="icon-screen-desktop"></i> Admin Dashboard</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('dashboard') }}" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                                        <i class="icon-screen-desktop"></i> Dashboard</a>
                                </li>
                            @endif
                        @else
                            <li>
                                <a href="javascript:;" data-toggle="modal" data-target="#login-form" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                                    <i class="icon-user"></i> Sign In</a>
                            </li>
                        @endif
                    </ul>
                </nav>
                <!-- END: MEGA MENU -->
                <!-- END: LAYOUT/HEADERS/MEGA-MENU -->
                <!-- END: HOR NAV -->
            </div>
        </div>
    </div>
</header>
<!-- END: HEADER -->
<!-- END: HEADER -->
<!-- END: LAYOUT/HEADERS/HEADER-1 -->
@if (!Auth::check())
    <!-- BEGIN: CONTENT/USER/FORGET-PASSWORD-FORM -->
    <div class="modal fade c-content-login-form" id="forget-password-form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content c-square">
                <div class="modal-header c-no-border">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="c-font-24 c-font-sbold">Password Recovery</h3>
                    <p>To recover your password please fill in your email address</p>
                    <form class="form-horizontal" role="form" method="POST" action="{{route('post.lost.password')}}"> <?php // {{ route('password.email') }} ?>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="forget-email" class="hide">Email</label>
                            <input type="email" class="form-control input-lg c-square" id="email" name="email" placeholder="Email"> </div>
                        <div class="form-group">
                            <button type="submit" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">Submit</button>
                            <a href="javascript:;" class="c-btn-forgot" data-toggle="modal" data-target="#login-form" data-dismiss="modal">Back To Login</a>
                        </div>
                    </form>
                </div>
                <div class="modal-footer c-no-border">
                </div>
            </div>
        </div>
    </div>
    <!-- END: CONTENT/USER/FORGET-PASSWORD-FORM -->

    <!-- BEGIN: CONTENT/USER/LOGIN-FORM -->
    <div class="modal fade c-content-login-form" id="login-form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content c-square">
                <div class="modal-header c-no-border">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="c-font-24 c-font-sbold greeting"></h3>
                    <p>Let's make today a great day!</p>
                    <form class="form-signin" method="post" action="{{ route('newlogin') }}"> <?php // {{ route('login') }} ?>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="login-email" class="hide">NuLife ID</label>
                            <input type="text" class="form-control input-lg c-square" id="userid" name="userid" placeholder="NuLife ID" autofocus> </div>
                        <div class="form-group">
                            <label for="login-password" class="hide">Password</label>
                            <input type="password" class="form-control input-lg c-square" id="password" name="password" placeholder="Password"> </div>
                        <div class="form-group">
                            <button type="submit" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">Login</button>
                            <a href="javascript:;" data-toggle="modal" data-target="#forget-password-form" data-dismiss="modal" class="c-btn-forgot">Forgot Your Password ?</a>
                        </div>
                    </form>
                </div>
                <div class="modal-footer c-no-border">
                </div>
            </div>
        </div>
    </div>
    <!-- END: CONTENT/USER/LOGIN-FORM -->
    @endif

    <!-- BEGIN: PAGE CONTAINER -->
    <div class="c-layout-page">
        <!-- BEGIN: PAGE CONTENT -->
        <!-- BEGIN: LAYOUT/BREADCRUMBS/BREADCRUMBS-3 -->
        <div class="c-layout-breadcrumbs-1 c-bgimage c-subtitle c-fonts-uppercase c-fonts-bold c-bg-img-center" style="background-image: url({{ asset('web-assets/img/bg-28.jpg') }})">
            <div class="container">
                <div class="c-page-title c-pull-left">
                    <h1 class="c-font-uppercase c-font-bold c-font-white c-font-30 c-font-slim">CODE OF CONDUCT</h1>
                    <h4 class="c-font-white c-font-thin c-opacity-07"> Kode Etik </h4>
                </div>
            </div>
        </div>
        <!-- END: LAYOUT/BREADCRUMBS/BREADCRUMBS-3 -->

        <!-- BEGIN: CONTENT/MISC/ABOUT-1 -->
        <div class="c-content-box c-size-md c-bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 wow animated fadeInLeft">
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">BAB I - Ketentuan Umum</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 1</h4>
                        <p>Dalam kode Etik ini yang dimaksud dengan :
                        <ol>
                            <li><code>Perusahaan</code> adalah <strong>PT. NULIFE INDONESIA SEJAHTERA</strong> (untuk selanjutnya disebut
                                <strong>NULIFE</strong> ) yang bergerak
                                di bidang usaha perdagangan produk, dimana sistem atau cara pemasaran nya dilakukan melalui kegiatan
                                penjualan berjenjang <em>( Multi Level Marketing )</em>.</li>
                            <li>Partner <code>Stockist</code> dan <code>Master Stockist</code> adalah orang perorang atau badan hukum Indonesia
                                yang bersedia bergabung dan memasarkan Produk dalam jaringan pemasaran yang telah dimiliki dan
                                dikembangkan oleh <strong>NULIFE</strong> dan telah mendapatkan persetujuan dari <strong>NULIFE</strong> untuk
                                menjadi anggota dari
                                usaha perusahaan dan bukan merupakan bagian dari struktur organisasi perusahaan.</li>
                            <li><code>Posisi</code> adalah jenjang karier member dalam usaha <strong>NULIFE</strong> dengan urutan atau level 
                            sebagai berikut :
                                <ul style="list-style: none">
                                    <li>Member</li>
                                    <li>A. Ruby</li>
                                    <li>B. Saphire</li>
                                    <li>C. Emerald</li>
                                    <li>D. Diamond</li>
                                    <li>E. Red Diamond</li>
                                    <li>F. Blue Diamond</li>
                                    <li>G. White Diamond</li>
                                    <li>H. Black diamond</li>
                                </ul>
                            </li>
                            <li><code>Sponsor</code> : Member yang merekrut langsung member baru.</li>
                            <li><code>Upline</code> : Member yang secara struktur jaringan berada diatas downline.</li>
                            <li><code>Downline</code> adalah member yang disponsori dari member lain</li>
                            <li><code>Website</code> adalah alamat domain di dunia maya, yang berisi tentang aktivitas perusahaan, marketing plan
                                dan informasi seputar produk-produk <strong>NULIFE</strong>.</li>
                            <li><code>Konsumen</code> adalah pembeli akhir dari produk–produk yang dipasarkan <strong>NULIFE</strong>
                                dengan tujuan untuk dipakai sendiri.</li>
                            <li><code>Produk</code> adalah setiap barang yang di pasarkan oleh <strong>NULIFE</strong> kepada para member.</li>
                            <li><code>Jaringan</code> adalah seluruh member yang berada dalam kelompok pohon member yang bersangkutan.</li>
                            <li><code>Starter kit</code> adalah panduan yang diberikan oleh <strong>NULIFE</strong> kepada member baru yang
                                berisi antara lain :
                                Kode Etik dan peraturan member, katalog produk, Daftar Harga,company profile, Formulir-Formulir keanggotaan
                                dan alat bantu lain nya. Isi starter kit ini akan terus dilakukan perubahan perubahan baik pengurangan
                                maupun penambahan sesuai kebutuhan.</li>
                            <li>WEBSITE Resmi <strong>NULIFE</strong> adalah <code>www.nulife.co.id</code> , Informasi Elektronik yang telah terdaftar atas
                                Nama <strong>NULIFE</strong>, Sebagai sarana pengembangan Usaha, Informasi usaha, Promosi dan pendaftaran keanggotaan.</li>
                            <li><code>Bonus Harian</code>, adalah bonus yang terdiri dari bonus sponsor dan bonus pairing yang di berikan tiap-tiap
                                hari kepada seorang member yang berhak memperolehnya karena telah memenuhi ketentuan dan syarat - syarat
                                yang ditentukan <strong>NULIFE</strong>.</li>
                            <li><code>Bonus Unilevel</code> adalah bonus yang diberikan tiap-tiap bulanan oleh <strong>NULIFE</strong> kepada seorang member yang
                                berhak memperoleh nya karena telah memenuhi ketentuan atau syarat- syarat yang ditentukan <strong>NULIFE</strong>.</li>
                            <li><code>Bonus Mingguan</code> : Bonus peringkat yang diberika oleh <strong>NULIFE</strong> kepada seorang member yang berhak memperoleh
                                karena telah memenihi ketentuan dana tau syarat-syarat yang ditentukan <strong>NULIFE</strong></li>
                            <li><code>Reward</code> : Bonus yang diberikan sesuai dengan ketentuan perusahaan diluar garis sponsor, pasangan, unilevel
                                dan peringkat.</li>
                            <li><code>Monopoli</code> adalah penguasaan atas produk atau pemasaran produk tertentu oleh salah satu pelaku usaha
                                atau satu jaringan pelaku usaha.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">BAB II - Tentang Member</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Bagian Pertama</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Umum</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 2</h4>
                        <ol>
                            <li>Kesempatan untuk menjadi member adalah sama untuk setiap orang dan tidak bergantung pada jenis kelamin,
                            suku bangsa, golongan maupun agama. Seorang member harus memiliki kewarganegaraan Indonesia
                                atau surat Izin tinggal (KIMS/KITAS) bagi orang asing yang tinggal di Indonesia.</li>
                            <li>Seorang calon member yang telah mengisi dan melakukan registrasi berarti calon member telah sepakat
                                untuk mematuhi ketentuan-ketentuan yang terdapat dalam kode etik dan peraturan member ini dan
                                paket yang berlaku berikut dengan perubahan-perubahan yang dilakukan dari waktu ke waktu
                                oleh <strong>NULIFE</strong>.</li>
                            <li>Setiap member mulai posisi User sampai dengan black diamond dianggap telah membaca, mengerti
                                dan memahami serta melakukan segala ketentuan yang diatur dalam kode etik dan peraturan member
                                ini dan paketyang berlaku dengan baik dan benar termasuk perubahan-perubahan yang dilakukan
                                dari waktu ke waktu oleh <strong>NULIFE</strong>.</li>
                            <li>Setiap Member harus menjaga nama baik <strong>NULIFE</strong> dan segenap karyawan nya serta tidak mencemarkan
                                atau menjelekan nama baik <strong>NULIFE</strong> atau member lain nya.
                                <strong>NULIFE</strong> berhak mencabut keanggotaan seorang member yang telah melakukan perbuatan
                                yang nyata-nyata mengakibatkan pencemaran nama baik <strong>NULIFE</strong> akibat perbuatan tersebut.</li>
                            <li><strong>NULIFE</strong> berhak mencabut keanggotaan seorang member yang telah terbukti secara hukum
                                terlibat tindak pidana penyalahgunaan narkoba, perjudian, pencurian penipuan maupun perbuatan asusila.</li>
                            <li>Setiap member berhak mensponsori calon member-member baru diseluruh wilayah hukum Indonesia.</li>
                            <li>Setiap member adalah berdiri sendiri, tidak termasuk dalam struktur organisasi <strong>NULIFE</strong> dan
                                tidak mempunyai ikatan jam kerja dengan <strong>NULIFE</strong> sehingga tidak berhak mendapatkan gaji
                                atau tunjangan dari <strong>Nulife</strong> dalam betuk apapun juga tidak berhak menuntut <strong>NULIFE</strong>
                                untuk memberikan tunjangan seperti yang dimaksud.</li>
                            <li>Seorang member yang telah mencapai prestasi tertentu dapat mengajukan permohonan untuk menjadi member
                                atas nama satu badan hukum yang telah mendapat pengesahan dari yang berwenang dengan syarat – syarat
                                yang ditentukan oleh <strong>NULIFE</strong>. Penentuan prestasi tertentu tersebut adalah hak mutlak dari
                                <strong>NULIFE</strong>.</li>
                            <li>Segala perubahan dan hal – hal lain yang berhubungan dengan status kememberan harus disampaikan secara
                                tertulis kepada <strong>NULIFE</strong> dimana identitas member yang bersangkutan harus sama form
                                registrasi atau identitas terakhir yang terlampir. Apabila terdapat perbedaan identitas antara yang
                                tertera pada form registrasi dengan identitas permohonan perubahan data, <strong>NULIFE</strong> berhak untuk
                                mengabaikan permohonan tersebut.</li>
                            <li>seluruh perubahan data ke memberan harus disampaikan melalui procedural yangtelah ditetapkan <strong>NULIFE</strong>.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Bagian Kedua</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Pendaftaran Member Baru</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 3</h4>
                        <ol>
                            <li>Pendaftaran member baru dilakukan di tempat yang ditunjuk <strong>NULIFE</strong> atau melalui
                                pendaftaran secara elektronik di website resmi <code>www.nulife.co.id</code>. <strong>NULIFE</strong> tidak
                                dapat menerima pendaftaran member baru yang dilakukan selain ditempat yang ditunjuk oleh
                                <strong>NULIFE</strong>.</li>
                            <li>Setiap permohonan (calon member) harus sudah berumur 17 ( tujuh belas ) Tahun atau sudah pernah menikah
                                sebelum berumur 17 ( tujuh belas ) tahun, Permohonan dapat diajukan, kecuali dalam hal pewarisan dikarenakan
                                meninggal dunia ( lihat ketentuan pasal 8 BAB II bagian kelima tentang pewarisan keanggotaan ).</li>
                            <li>Untuk menjadi seorang member, seorang pemohon pertama-tama harus disponsori oleh salah seorang member
                                lainya yang masih aktif dan masa keanggotaanya belum kadaluarsa.</li>
                            <li>Untuk mendaftar keanggotaan, setiap pemohon dikenakan biaya pendaftaran yang besarnya ditentukan secara
                                sepihak oleh <strong>NULIFE</strong> dan akan mendapatan 1(satu) set Starter Kit dan 1 (satu) set produk.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <h4 class="c-font-bold">Pasal 4</h4>
                        <ol>
                            <li>Pendaftaran menjadi member harus dibuat pada form registrasi baik secara manual atau secara
                                elektronik yang dikeluarkan oleh <strong>NULIFE</strong>. Semua pertanyaan dan persyaratan dengan formulir
                                tersebut harus diisi atau dijawab dengan jujur dan disertain persyaratan lengkap, dimana hasilnya harus
                                disetujui dahulu oleh <strong>NULIFE</strong>.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Bagian Ketiga</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Larangan Keanggotaan Ganda</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 5</h4>
                        <ol>
                            <li>Apabila terbukti bahwa seorang member aktif, kemudian mendaftarkan keanggotaanya dengan menggunakan
                                upline yang lain, baik karena kemauan sendiri maupun karena dipengaruhi oang lain, maka keanggotaanya yang
                                baru akan dicabut dan seluruh jaringan dari keanggotaan yang baru tersebut.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Bagian Keempat</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Keanggotaan Suami Istri Dan Bujangan</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 6</h4>
                        <ol>
                            <li>Setiap satu nomer keanggotaan berlaku seorang member yang tercatat dalam form registrasi dan
                                sekaligus untk pasanganya (suami atau istri) yang sah secara hukum.</li>
                            <li>Member yang masih bujangan dan kemudian menikah, maka dalam tenggang waktu 1 (satu) bulan setelah
                                pernikahanya, member tersebut harus memberi tahu kepada <strong>NULIFE</strong> tentang perubahan
                                status pernikahanya dengan cara kirim data ke bagian admin.</li>
                            <li>Jika sepasang suami istri, keduanya sudah menjadi member sebelum menikah dan salah satu belum
                                mencapai diamond keatas, maka yang bersangkutan harus memilih salah satu keanggotaan tersebut
                                sedangkan yang lainya harus dihentikan atau dihibahkan ke orang lain. Namun kedua-duanya telah
                                berposisi diamond keatas, maka kedua-duanya berhak atau boleh menerusakan ke anggotaanya masing – masing.</li>
                            <li>Segala ketentuan dalam kode etik ini, mengikat member dan pasanganya (suami atau istri) yang namanya tercantum
                                dalam kartu anggota <strong>NULIFE</strong>.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <h4 class="c-font-bold">Pasal 7</h4>
                        <ol>
                            <li>Apabila seorang member memiliki lebih dari 1 (satu) istri yang SAH maka segala hadiah dan fasilitas
                                (Seperti perjalanan ke luar negeri, asuransi kecelakaan, pin, sertifikat, hadiah promo) hanya berlaku
                                untuk seorang istri yang namanya telah ditunjuk oleh member dalam form registrasi.</li>
                            <li>Jika member bercerai, maka yang berhak terhadap keanggotaan <strong>NULIFE</strong> adalah yang namanya
                                tercantum dalam form registrasi (bukan nama pasangan), kecuali ada kesepakatan bersama atau jika pihak
                                pengadilan menentukan lain. Segala akibat hukum yang timbul dikemudian hari akibat adanya perceraian
                                tersebut adalah menjadi kewajiban dan tanggung jawab member yang bersangkutan.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Bagian Kelima</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Pewarisan Keanggotaan</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 8</h4>
                        <ol>
                            <li>Jika seorang member meninggal dunia, maka keanggotaannya tersebut dengan sendirinya kepada pasangannya yang
                                masih hidup, kecuali seluruh ahli warisnya membuat kesepakatan tersendiri dan mengajukan kepada perusahaan
                                serta telah disetujui oleh pasangan tersebut. Pasangan yang masih hidup tersebut wajib menunjukkan akta
                                kematian pasangannya dan menandatangani form registrasi.</li>
                            <li>Bagi member yang belum menikah atau sudah bercerai maka keanggotaan dapat diwariskan kepada ahli waris yang
                                namanya tercantum dalam form registrasi.</li>
                            <li>Apabila terjadi sengketa oleh pihak lain perihal kewarisan ini maka <strong>NULIFE</strong> akan mengikuti
                                keputusan akhir dari pengadilan. Selama dalam proses penyelesaian sengketa tersebut kememberan dapat
                                diambil alih sementara oleh <strong>NULIFE</strong> sampai mendapat keputuan hukum yang tetap.</li>
                            <li>Jika ternyata si Penerima warisan telah menjadi member, maka yang bersangkutan wajib memilih keanggotaan
                                salah satu diantaranya, dimana yang satunya lagi dapat dihibahkan kepada orang lain.</li>
                            <li>Jika seorang penerima warisan belum berumur 17 ( Tujuh Belas) tahun, maka <strong>NULIFE</strong> berhak
                                menunjuk seorang dari kerabat keluarga si penerima warisan untuk menjadi walinya sampai yang bersangkutan
                                berumur 17 (Tujuh Belas) tahun.</li>
                            <li>Dalam hal si penerima waris juga meninggal dunia, maka <strong>NULIFE</strong> akan menunjuk ahli waris
                                terdekat sesuai dengan ketentuan hukum yang berlaku di Indonesia atau berdasarkan hasil musyawarah para
                                ahli waris yang ada (yang dibuat dihadapan notaris).</li>
                            <li>Dalam hal pewarisan kememberan, maka segala hadiah dan fasilitas (Seperti perjalanan ke luar negeri, asuransi
                                kecelakaan, pin, sertifikat, hadiah promo) tidak dapat dipindahkan kepada sipenerima warisan, kecuali
                                fasilitas-fasilitas umum seperti bonus bulanan. Segala fasilitas dan hadiah lainnya dapat dinikmati jika
                                sipenerima warisan mengalami kenaikan posisi ataupun memenuhi persyaratan seperti yang tercantum dalam PAKET.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <h4 class="c-font-bold">Pasal 9</h4>
                        <ol>
                            <li>Keanggotaan member tidak dapat dialihkan dengan cara apapun termasuk hibah maupun jual beli keanggotaan
                                kepada pihak lain kecuali :
                                <ul>
                                    <li>Karena adanya perkawinan antar member sebagaimana tercantum dalam <code>Bab II Pasal 6</code></li>
                                    <li>Karena adanya pewarisan sebagaimana tercantum dalam <code>Bab II Pasal 8</code></li>
                                </ul>
                            </li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Bagian Keenam</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Berhentinya keanggotaan seorang member</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 10</h4>
                        <ol>
                            <li>Masa Keanggotaan seorang member dinyatakan berakhir bila:
                                <ul style="list-style: none">
                                    <li>a. Telah habis masa berlakunya dan tidak diperpanjang lagi oleh yang bersangkutan
                                        (lihat ketentuan <code>Bab II bagian ketujuh Pasal 11 Ayat 1</code>), Maka segala hadiah dan
                                        faslitas yang belum dinikmatinya secara otomatis akan dianggap hangus.</li>
                                    <li>b. Member yang bersangkutan mengundurkan diri dengan terlebih dahulu menyampaikan permohonan
                                        tertulis kepada <strong>NULIFE</strong> dan telah disetujui oleh <strong>NULIFE</strong>.</li>
                                    <li>c. Dicabut keanggotaannya karena pelanggaran Kode Etik.</li>
                                    <li>d. Dicabut keanggotaannya karena ada keputusan atau perintah dari pengadilan.</li>
                                </ul>
                            </li>
                            <li>Jika berakhirnya keanggotaan karena dicabut <code>(1.c)</code> atau karena ada putusan atau perintah dari
                                pengadilan <code>(1.d)</code>, maka segala fasilitas dan bonus yang belum diterima secara otomatis
                                dinyatakan hangus.</li>
                            <li>Seorang member yang sudah dicabut keanggotaannya, baru dapat memohon kembali menjadi member setelah
                                6 (enam) bulan kemudian dengan pertimbangan bahwa pelanggaran yang dilakukan sebelumya masih dapat
                                ditolerir oleh <strong>NULIFE</strong>. Yang bersangkutan akan mendapat nomor keanggotaan baru dan
                                memulai usahanya dari awal (posisi member atau user).</li>
                            <li><strong>NULIFE</strong> berhak sepenuhnya tanpa harus memberikan alasan untuk menolak apabila seorang
                                member yang sudah dicabut karena melanggar kode etik, bermaksud mendaftarkan diri kembeli menjadi
                                member <strong>NULIFE</strong>.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <h4 class="c-font-bold">Pasal 11</h4>
                        <ol>
                            <li>Member yang terindikasi ada atau terbukti melakukan suatu penempatan posisi structural di jaringan binary
                                dengan tidak wajar dan dinilai merugikan perusahaan maka <strong>NULIFE</strong> berhak sepenuhnya untuk
                                melakukan tindakan pembekuan akun yang terkait di dalam jaringan tersebut.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">BAB III - Tanggung Jawab dan kewajiban Upline atau Leader</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 12</h4>
                        <ol>
                            <li>Seorang upline wajib menjaga perilaku yang baik dengan memberikan bimbingan, pelatihan dan
                                penjelasan segala sesuatu hal yang berhubungan dengan usaha <strong>NULIFE</strong> dengan benar, tulus
                                dengan tidak memberikan keterangan yang menyesatkan (menipu) para downline (atau calon downlinenya)
                                baik dalam hal produk maupun <strong>PAKET NULIFE</strong>.</li>
                            <li>Untuk melindungi dan membangun jaringan member maka seorang upline tidak diperbolehkan menawarkan,
                                membujuk, berusaha mengajak, mempengaruhi atau merebut calon member baru yang sudah mempunyai upline lain,
                                termasuk kepada member yang keanggotaannya masih berlaku, baik yang berada dalam jaringannya maupun dalam
                                jaringan member lain untuk pindah jaringan, secara langsung atau tidak langsung.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <h4 class="c-font-bold">Pasal 13</h4>
                        <p>Nulife akan melakukan tindakan administrative berupa himbauan, peringatan keras maupun pencabutan terhadap pelanggaran
                            ketentuan sebagaimana yang diatur dalam <code>pasal 12</code>.</p>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">BAB IV - Penghitungan dan pembayaran Bonus</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 14</h4>
                        <ol>
                            <li>Satu periode penjualan adalah tanggal 1 bulan berjalan sampai dengan akhir bulan berjalan tersebut sesuai
                                dengan kalender masehi.</li>
                            <li>Hanya para member yang memenuhi syarat yang ada di system saja yang akan mendapatkan bonus.</li>
                            <li>Bonus yang berhak diterima member akan dibayarkan dengan cara :
                                <ul style="list-style: none">
                                    <li>A. Transfer langsung<br />
                                        Ketentuan ini mengatur bagi member yang memperoleh bonus harian, mingguan dana tau bulanan,
                                        maka <strong>NULIFE</strong> akan mengirimkan langsung bonus yang diterima member melalui bank
                                        yang ditunjuk member bersangkutan. Segala biaya akan dibebankan oleh bank terhadap pengiriman
                                        bonus menjadi beban dan tanggung jawab member yang bersangkutan, dimana biaya tersebut akan
                                        dipotong langsung dari bonus tersebut. <strong>NULIFE</strong> tidak bertanggung jawab jika terjadi
                                        sesuatu terhadap bonus seseorang member setelah transaksi melalui bank tersebut dilakukan.</li>
                                    <li>B. Setiap member, wajib memiliki rekening bank yang atas namanya sendiri atau pasanganya yang sah
                                        secara hukum. Penghitungan dan pengiriman bonus ini juga mengikuti system perpajakan yang berlaku di
                                        Indonesia, dimana setiap member yang mendapatkan bonus akan langsung dipotong pajak penghasilan (pph)
                                        dan pajak pertambahan (ppn) sesuai dengan peraturan perpajakan yang berlaku. Segala perpajakan
                                        dari seorang member menjadi beban dan tanggung jawab seorang member yang bersangkutan dan
                                        tidak ada sangkut pautnya dengan <strong>NULIFE</strong>.</li>
                                </ul>
                            </li>
                            <li>Jika seorang member melakukan tindakan yang merugikan <strong>NULIFE</strong> dari segi materil (sepanjang
                                bisa dibuktikan secara hukum), maka <strong>NULIFE</strong> berhak langsung memotong kerugian tersebut dari
                                bonus yang bersangkutan ditambah denda sebesar 5% (lima persen) di atas suku bunga bank Indonesia (SBI)
                                sampai dengan terpenuhinya kerugian tersebut, atau perusahaan berhak melakukan hold atas bonus dari
                                member yang terbukti melakukan perbuatan yang berindikasi merugikan perusahaan. Setelah segala kerugian
                                yang ditimbulkan member tersebut diselesaikan, maka NULIFE berhak untuk segera menghentikan keanggotaaan
                                yang bersangkutan, perbuatan yang berindikasi merugikan perusahaan tersebut antara lain:
                                <ul style="list-style: none;">
                                    <li>a. Melakukan rekayasa system dan berpola yang berakibat pada kerugian perusahaan yang kami
                                        istilahkan “POLA SNIPER”.</li>
                                    <li>b. Melakukan tindakan pencurian PIN.</li>
                                </ul>
                            </li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">BAB V - Penjualan</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 14</h4>
                        <ol>
                            <li>Setiap member wajib melakukan pelayanan purna jual terhadap setiap konsumennya.</li>
                            <li>Member Dilarang mencabut atau merusak atau mengganti segala <strong>NULIFE</strong> atau stiker yang
                                tertera pada setiap kemasan produk, brosur ataupun alat bantu jual lainya yang dikeluarkan <strong>NULIFE</strong>
                                yang dapat menyebabkan kesalahpahaman oleh konsumen.</li>
                            <li>Member tidak boleh membuat suatu penjelasan sendiri berkenaan dengan produk–produk <strong>NULIFE</strong>,
                                selain dari yang tertulis pada <strong>NULIFE</strong> produk atau brosur–brosur resmi yang dikeluarkan
                                <strong>NULIFE</strong>, kecuali secara resmi telah mendapat izin dari <strong>NULIFE</strong>.</li>
                            <li>Member dilarang menjual produk–produk yang sudah kadaluarsa atau rusak.</li>
                            <li>Member yang hendak membuka stand pameran produk <strong>NULIFE</strong> dalam suatu acara bisnis tidak
                                diperbolehkan melakukan penjualan, kecuali telah mendapat izin secara tertulis dari <strong>NULIFE</strong>
                                untuk membuka stan pameran produk tersebut.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <h4 class="c-font-bold">Pasal 16</h4>
                        <ol>
                            <li>Ketika seorang member menjual produk (dalam keadaan bagaimanapun) tidak boleh salah dalam menjelaskan
                                kualitas, daya guna, cara pemakaian ataupun kandungan dari produk-produk yang dipasarkan
                                <strong>NULIFE</strong>.</li>
                            <li>Member harus sopan dan tidak memaksa pada saat menawarkan produk-produk <strong>NULIFE</strong>.</li>
                            <li>Setiap Member harus memberikan bon pembelian (kwitansi pembelian) kepada konsumennya apabila diminta.
                                Setiap bon pembelian harus mencantumkan jumlah produk, jenis produk, jumlah harga, nama, nomor kode,
                                tanggal transaksi dan tanda tangan member yang bersangkutan.</li>
                            <li>Pada setiap penjualan member wajib memberikan penjelasan yang benar mengenai Jaminan Kepuasan Konsumen
                                dan jika dikemudian hari konsumen tersebut menggunakan haknya sesuai jaminan tersebut, member yang
                                bersangkutan wajib melayani sebaik dan secepat mungkin sebagaimana diatur dalam Undang - undang Perlindungan
                                Konsumen.</li>
                            <li>Member tidak berhak menjelaskan dengan mengatas namakan <strong>NULIFE</strong> berkenaan dengan kesalahan
                                pemakaian atau konsumen dalam hal pemakaian atau penggunaan produk-produk <strong>NULIFE</strong>.</li>
                            <li><strong>NULIFE</strong> tidak bertanggung jawab jika terjadi pelanggaran <code>pasal 15 dan 16</code>,
                                Member yang melanggar hal tersebut, harus mengganti segala kerugian yang ditimbulkannya, baik
                                kepada <strong>NULIFE</strong> maupun pihak ketiga yang dirugikan, termasuk dari segi aspek hukum yang
                                berlaku di Negara Republik Indonesia.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">BAB VI - Nama dan Logo NULIFE</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 17</h4>
                        <ol>
                            <li>Semua produk-produk <strong>NULIFE</strong> telah didaftarkan di instansi yang berwenang baik merk,
                                logo maupun hak cipta nya, sehingga member dilarang keras memproduksi, menjual atau mengusahakan
                                dari sumber lain produk-produk <strong>NULIFE</strong> maupun alat bantu produk, seperti buku-buku,
                                spanduk, makalah seminar, pin, sertifikat penghargaan, kartu nama maupun produk-produk lain nya
                                yang bukan resmi dikeluarkan <strong>NULIFE</strong> sebelum terlebih dahulu diizinkan secara
                                tertulis oleh <strong>NULIFE</strong>.</li>
                            <li>Seorang member tidak boleh mengaku bahwa dia mempunyai kedudukan atau dapat mewakili <strong>NULIFE</strong>
                                dalam hal apapun, misal nya membuat ikatan kerja, menjual saham <strong>NULIFE</strong>, memberikan penjelasan
                                kepada media massa atau hal lain nya yang sifat nya seolah–olah mewakili <strong>NULIFE</strong>.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <h4 class="c-font-bold">Pasal 18</h4>
                        <ol>
                            <li><strong>NULIFE</strong> hanya memberikan izin kepada member yang telah berposisi minimal diamond untuk
                                menggunakan logo <strong>NULIFE</strong> untuk keperluan pengembangan jaringan, seperti antara lain undangan,
                                spanduk, umbul-umbul, sertifikat penghargaan maupun buku.</li>
                            <li>Izin sebagaimana ayat 1(satu), diberikan dengan syarat yang bersangkutan telah mengajukan permohonan
                                tertulis kepada <strong>NULIFE</strong> dan telah mendapatkan persetujuan tertulis dari <strong>NULIFE</strong>.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <h4 class="c-font-bold">Pasal 19</h4>
                        <p>Demi menjaga dan memelihara integritas usaha <strong>NULIFE</strong>, maka bagi pihak-pihak dan termasuk member
                            di dalamnya yang dengan sengaja atau tanpa sengaja menggunakan merek dagang logo <strong>NULIFE</strong> tanpa
                            izin dari <strong>NULIFE</strong>, maka atas pelanggaran tersebut <strong>NULIFE</strong> tanpa peringatan terlebih
                            dahulu berhak mencabut kartu keanggotaan member, serta dapat menempuh jalur hukum baik pidana maupun perdata.</p>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">BAB VII - Kegiatan yang Dilarang</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Bagian Pertama</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Umum</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 20</h4>
                        <ol>
                            <li>Member, Stockist termasuk Master Stockiest dilarang menggunakan atau memanfaatkan jaringan <strong>NULIFE</strong>
                                untuk mengadakan pelatihan-pelatihan atau acara khusus di luar bisnis <strong>NULIFE</strong> atau bersifat
                                komersial, kecuali telah mendapatkan izin secara tertulis dari <strong>NULIFE</strong>.</li>
                            <li>Dalam menjalankan aktivitasnya, member tidak diperkenankan menggunakan suatu aktivitas pertemuan
                                <strong>NULIFE</strong> untuk kepentingan lainnya yang berhubungan dengan politik atau SARA.</li>
                            <li>Seorang member dilarang menyatakan bahwa dia ataupun member lainnya mempuanyai suatu daerah penjualan tertentu
                                secara monopoli.</li>
                            <li><strong>NULIFE</strong> akan melakukan tindakan administrative berupa himbauan, peringatan, peringatan keras
                                atau pencabutan keanggotaan terhadap pelanggaran ketentuan sebagaimana yang diatur dalam pasal ini.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Bagian Kedua</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Bergabung Dengan MLM Lain</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 21</h4>
                        <ol>
                            <li>Member dilarang mempengaruhi atau mengajak member <strong>NULIFE</strong> lainnya menjadi anggota perusahaan
                                MLM lain atau segala jenis usaha perdagangan yang menggunakan system jaringan dalam bentuk apapun.</li>
                            <li>Member dilarang memasarkan produk atau jasa perusahaan MLM lain dan menjelek-jelekkan, membandingkan produk atau jasa
                                <strong>NULIFE</strong> dengan produk jasa yang dipasarkan oleh perusahaan lainnya.</li>
                            <li>Member dilarang menjadi pemilik, bagian dari manajemen, bagian dari dewan pembina atau jabatan struktural lainnya dalam perusahaan MLM lain atau perusahaan sejenis yang menggunakan sistem bisnis berjenjang.</li>    
                            <li>Member yang sudah berposisi red diamond ke atas, dan sudah pernah menerima bonus diamond
                                (termasuk pasangannya) dilarang menjadi anggota (member) diperusahaan MLM lain atau segala jenis
                                usaha perdagangan yang menggunakan sistem jaringan (network) dalam bentuk apapun.</li>
                            <li><strong>NULIFE</strong> berhak mencabut keanggotaan member tanpa peringatan terlebih dahulu terhadap
                                pelanggaran pasal ini.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Bagian Ketiga</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Penjualan ID Paket</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 22</h4>
                        <ol>
                            <li>Demi menjaga kelangsungan usaha <strong>NULIFE</strong> serta melindungi kepentingan member dalam menjalankan
                                usaha nya, maka dalam menjalankan aktivitas nya member dilarang menyalah gunakan system PAKET yang berlaku,
                                antara lain seperti hal-hal yang diatur berikut ini:
                                <ul style="list-style: none;">
                                    <li>a. Member dilarang menarik dana dari member atau calon member dengan maksud untuk memenuhi
                                        persyaratan PAKET <strong>NULIFE</strong> atau dengan menjanjikan mendapatkan prestasi atau posisi
                                        dengan cara singkat, sehingga dimungkinkan merusak citra <strong>NULIFE</strong> ataupun mengganggu
                                        keberlangsungan usaha <strong>NULIFE</strong>.</li>
                                    <li>b. Menarik dana dari member tanpa membeli produk.</li>
                                    <li>c. Melakukan jual beli poin dan nilai rabat dengan maksud untuk memenuhi persyaratan.</li>
                                    <li>d. Dilarang Jual beli ID PAKET.</li>
                                </ul>
                            </li>
                            <li><strong>NULIFE</strong> berhak mencabut keanggotaan member tanpa peringatan terlebih dahulu terhadap
                                pelanggaran pasal ini.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Bagian Keempat</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Penjualan Produk</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 23</h4>
                        <ol>
                            <li>Produk-produk <strong>NULIFE</strong> tidak boleh dijual atau dipamerkan ditoko-toko, toko obat,
                                toko online, apotek, supermarket, kios-kios, atau tempat-tempat umum lain nya yang serupa, kecuali
                                ditempat-tempat yang ditunjuk <strong>NULIFE</strong>.</li>
                            <li>Harga jual dari semua produk (harga konsumen) ditentukan oleh <strong>NULIFE</strong>. Member dilarang
                                untuk menjual produk-produk tersebut dengan harga yang lebih rendah atau harga yang lebih tinggi
                                dari harga konsumen.</li>
                            <li><strong>NULIFE</strong> berhak mencabut keanggotaan member tanpa peringatan terlebih dahulu terhadap
                                pelanggaran pasal ini.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <h4 class="c-font-bold">Pasal 24</h4>
                        <ol>
                            <li>Member dilarang untuk melakukan pembelanjaan produk yang melebihi batas wajar yang bertujuan untuk
                                menimbun produk.</li>
                            <li>Member dilarang membelanjakan, menggunakan, menjalankan akun keanggotaan yang bukan atas nama nya sendiri.</li>
                            <li>Akun keanggotaan member dilarang dibelanjakan, digunakan, dijalankan oleh orang lain selain diri nya sendiri.</li>
                            <li><strong>NULIFE</strong> berhak mencabut keanggotaan member tanpa peringatan terlebih dahulu terhadap
                                pelanggar pasal ini.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Bagian Kelima</h1>
                            <h1 class="c-font-uppercase c-font-bold c-font-20">Melakukan Kegiatan Ekspor Impor</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 25</h4>
                        <p>Member tidak diperkenan kan melakukan kegiatan ekspor - impor segala produk atau produk yang dipasarkan
                            <strong>NULIFE</strong> (Indonesia), baik dari maupun ke negara lain, ataupun membantu pihak lain untuk
                            melakukan hal tersebut. <strong>NULIFE</strong> berhak mencabut keanggotaan member tanpa peringatan
                            terlebih dahulu terhadap pelanggar pasal ini dan akan menempuh jalur hukum baik pidana maupun perdata
                            terhadap pelanggar ketentuan ini.</p>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">BAB VIII - Perihal Pelaporan Pengaduan</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 26</h4>
                        <ol>
                            <li>Laporan pengaduan dapat diajukan oleh seorang member yang berkepentingan dan merasa dirugikan oleh
                                ditributor lainnya.</li>
                            <li>Laporan pengaduan harus dilaporkan secara tertulis kepada <strong>NULIFE</strong> atau tempat-tempat yang ditunjuk oleh
                                <strong>NULIFE</strong> disertai dengan alasan-alasannya dan bukti-bukti yang cukup.</li>
                            <li>Laporan pengaduan yang dapat diajukan hanyalah yang mengenai pelanggaran terhadap peraturan dan Kode
                                Etik <strong>NULIFE</strong>.</li>
                            <li><strong>NULIFE</strong> menjamin kerahasiaan setiap identitas pengadu atau pelapor.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">BAB IX - Sanksi</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 27</h4>
                        <ol>
                            <li><strong>NULIFE</strong> berhak sepenuhnya memberikan sanksi maupun melakukan peninjauan kembali atas
                                sanksi yang dikeluarkan apabila dianggap perlu terhadap seorang yang terbukti melakukan pelanggaran kode
                                etik maupun PAKET, baik hal tersebut berdasarkan laporan pengaduan maupun hasil pemeriksaan dari
                                pihak <strong>NULIFE</strong>.</li>
                            <li>Dengan pertimbangan atas berat dan ringannya sifat pelanggaran kode etik dan peraturan member,
                                pelanggaran dapat dikenakan sanksi berupa:
                                <ul style="list-style: none;">
                                    <li>a. Himbauan</li>
                                    <li>b. Klarifikasi</li>
                                    <li>c. Peringatan</li>
                                    <li>d. Pencabutan keanggotaan</li>
                                </ul>
                            </li>
                            <li>Untuk melindungi dan menjaga ketenangan member pada umumnya ataupun untuk menjaga keberlangsungan usaha
                                perusahaan akibat perbuatan yang dilakukan member yang melanggar kode etik ini, maka perusahaan
                                berhak untuk memberikan sanksi berupa pemberhentian sementara untuk waktu tertentu ataupun
                                pencabutan keaggotaan member tanpa memberikan peringatan terlebih dahulu.</li>
                            <li>Pemberian sanksi berupa pencabutan keanggotaan member dilakukan oleh pejabat di Departemen Hukum
                                <strong>NULIFE</strong> atau Direksi <strong>NULIFE</strong> atau kuasa hukum yang ditunjuk <strong>NULIFE</strong>,
                                dan diberitahukan kepada yang bersngkutan dalam bentuk tertulis.</li>
                            <li>Nama anggota dan nomor anggota dari member yang dicabut keanggotaannya akan dicantumkan dalam website
                                resmi atau majalah NULIFE maupun media informasi lainnya yang dikeluarkan resmi oleh <strong>NULIFE</strong>.</li>
                            <li>Segala bonus hadiah yang belum diterima tidak akan diberikan kepada yang bersangkutan, dan dinyatakan
                                hangus terhitung sejak tanggal efektif pencabutan.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">BAB X - Penyelesaian Perselisihan</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 28</h4>
                        <ol>
                            <li>Apabila terjadi perselisihan antara member dan <strong>NULIFE</strong> mengenai pelaksanaan Peraturan dan
                                Kode Etik ataupun kebijakan lain yang dikeluarkan oleh <strong>NULIFE</strong> kepada member, maka
                                perselisihan tersebut akan diselesaikan sesuai dengan prosedur-prosedur hukum serta persyaratan
                                administrasi yang berlaku pada Badan Arbitrase Nasional Indonesia (BANI). Segala keputusan dan ketentuan
                                BANI adalah bersifat mutlak dan bersifat mengikat semua pihak.</li>
                            <li>Segala biaya yang dikeluarkan yang timbul dalam perselisihan tersebut akan ditanggung oleh masing-masing
                                pihak atau mengikuti ketentuan yang telah diatur BANI.</li>
                        </ol>
                        <div class="m-b-30">&nbsp;</div>
                        <div class="c-content-title-1">
                            <h1 class="c-font-uppercase c-font-bold c-font-20">BAB XI - Penutup</h1>
                            <div class="c-line-left c-theme-bg"></div>
                        </div>
                        <h4 class="c-font-bold">Pasal 29</h4>
                        <ol>
                            <li>Kode etik dan peraturan member ini berlaku di wilayah Indonesia terhitung sejak tanggal <code>1 Mei 2017</code>
                                sampai dengan adanya perubahan atau pembaruan selanjutnya.</li>
                            <li>Jika sepanjang berlakunya kode etik dan peraturan member ini terdapat perubahan atau kebijakan yang
                                dilakukan <strong>NULIFE</strong>, maka perubahan tersebut akan disampaikan melalui website atau majalah
                                resmi <strong>NULIFE</strong> atau diumumkan melalui kantor cabang customer center setempat.</li>
                            <li>Dengan diberlakukanya kode etik dan peraturan member ini, maka kode etik dan peraturan member yang pernah ada
                                dan berlaku sebelumnya, dinyatakan tidak berlaku lagi.</li>
                            <li><strong>NULIFE</strong> berhak untuk mengambil kebijakan sendiri terhadap hal-hal yang belum diatur dalam kode
                                etik dan peraturan member ini.</li>
                            <li><strong>NULIFE</strong> berhak sepenuhnya untuk melakukan perubahan baik penambahan, pengurangan, maupun
                                pembaharuan terhadap kode etik dan peraturan member maupun patner dari waktu ke waktu demi menjaga
                                kelangsungan usaha <strong>NULIFE</strong>.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: CONTENT/MISC/ABOUT-1 -->
        <!-- END: PAGE CONTENT -->
    </div>
    <!-- END: PAGE CONTAINER -->

    <!-- BEGIN: LAYOUT/FOOTERS/FOOTER-4 -->
    <a name="footer"></a>
    <footer class="c-layout-footer c-layout-footer-2">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="c-container c-first">
                        <div class="c-content-title-1">
                            <h3 class="c-font-uppercase c-font-bold">Success Starts With Your Mind</h3>
                            <div class="c-line-left"></div>
                            <p class="c-feature-16-desc c-font-grey">All can be done well if always think positive and optimistic in all things, then it will also motivate us to be the best. There is a fascinating experience from the world boxer Muhammad Ali. He once said that the champion resulted from desire, dreams, and vision.</p>
                        </div>
                        <a href="#" class="btn c-theme-btn c-btn-uppercase c-btn-square c-btn-bold">Join NuLife Now</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="c-container c-last">
                        <div class="c-content-title-1">
                            <h3 class="c-font-uppercase c-font-bold">Share the Dream</h3>
                            <div class="c-line-left"></div>
                        </div>
                        <ul class="c-socials">
                            <li>
                                <a href="#">
                                    <i class="icon-social-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icon-social-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icon-social-youtube"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icon-social-tumblr"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="c-copyright">
                <p>
                    <a href="https://www.instantssl.com/wildcard-ssl.html" target="_blank" style="text-decoration:none; ">
                        <img alt="Wildcard SSL" src="https://www.instantssl.com/ssl-certificate-images/support/comodo_secure_100x85_transp.png" style="border: 0px;">
                    </a>
                </p>
                <p class="c-font-oswald c-font-14">
                    Copyright &copy; 2017, nulife.co.id
                    &nbsp;&nbsp;<a class="c-font-blue c-font-grey-1-hover" href="{{ route('coc') }}">Code of Conduct</a>
                    &nbsp;&nbsp;<a class="c-font-blue c-font-grey-1-hover" href="#">Term of Use</a>
                    &nbsp;&nbsp;<a class="c-font-blue c-font-grey-1-hover" href="#">Privacy Policy</a>
                </p>
            </div>
        </div>
    </footer>
    <!-- END: LAYOUT/FOOTERS/FOOTER-4 -->
    <!-- BEGIN: LAYOUT/FOOTERS/GO2TOP -->
    <div class="c-layout-go2top">
        <i class="icon-arrow-up"></i>
    </div>
    <!-- END: LAYOUT/FOOTERS/GO2TOP -->
    <!-- BEGIN: LAYOUT/BASE/BOTTOM -->
    <!-- BEGIN: CORE PLUGINS -->
    <!--[if lt IE 9]>
    <script src="{{ asset('web-assets/js/plugins/excanvas.min.js') }}"></script>
    <![endif]-->
    <script src="{{ asset('web-assets/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/TweenMax.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/loader.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/jquery-migrate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/plugins/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/plugins/jquery.easing.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/plugins/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/plugins/reveal-animate.js') }}" type="text/javascript"></script>
    <!-- END: CORE PLUGINS -->
    <!-- BEGIN: LAYOUT PLUGINS -->
    <script src="{{ asset('web-assets/js/plugins/jquery.themepunch.tools.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/plugins/jquery.themepunch.revolution.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/plugins/jquery.cubeportfolio.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/plugins/owl.carousel.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/plugins/jquery.waypoints.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/plugins/jquery.counterup.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/plugins/jquery.fancybox.pack.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/plugins/jquery.smooth-scroll.js') }}" type="text/javascript"></script>
    <!-- END: LAYOUT PLUGINS -->
    <!-- BEGIN: THEME SCRIPTS -->
    <script src="{{ asset('web-assets/js/components.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/app.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function()
        {
            App.init(); // init core

            var thehours = new Date().getHours();
            var themessage;
            var morning = ('Good Morning!');
            var afternoon = ('Good Afternoon!');
            var evening = ('Good Evening!');

            if (thehours >= 0 && thehours < 12) {
                themessage = morning;

            } else if (thehours >= 12 && thehours < 17) {
                themessage = afternoon;

            } else if (thehours >= 17 && thehours < 24) {
                themessage = evening;
            }

            $('.greeting').append(themessage);
        });
    </script>
    <!-- END: THEME SCRIPTS -->
    <!-- BEGIN: PAGE SCRIPTS -->
    <script src="{{ asset('web-assets/js/plugins/revolution.extension.kenburn.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/plugins/revolution.extension.parallax.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-assets/js/slider.js') }}" type="text/javascript"></script>
    <!-- END: PAGE SCRIPTS -->
    <!-- END: LAYOUT/BASE/BOTTOM -->

    <!-- ALERT RESET PASSWORD -->
    @if (session('status'))
    <div class="c-cookies-bar c-cookies-bar-2 c-cookies-bar-top c-theme-bg c-theme-darken c-rounded wow animate fadeInDown js-cookie-consent cookie-consent" data-wow-delay="1s">
        <div class="c-cookies-bar-container">
            <div class="row">
                <div class="col-md-10">
                    <div class="c-cookies-bar-content c-font-white cookie-consent__message">
                        {{ session('status') }}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="c-cookies-bar-btn">
                        <a class="c-cookies-bar-close btn c-btn-white c-btn-square c-btn-bold js-cookie-consent-agree cookie-consent__agree" href="javascript:;">{{ trans('cookieConsent::texts.agree') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if ($errors->has('email'))
    <div class="c-cookies-bar c-cookies-bar-2 c-cookies-bar-top c-theme-bg c-theme-darken c-rounded wow animate fadeInDown js-cookie-consent cookie-consent" data-wow-delay="1s">
        <div class="c-cookies-bar-container">
            <div class="row">
                <div class="col-md-10">
                    <div class="c-cookies-bar-content c-font-white cookie-consent__message">
                        {{ $errors->first('email') }}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="c-cookies-bar-btn">
                        <a class="c-cookies-bar-close btn c-btn-white c-btn-square c-btn-bold js-cookie-consent-agree cookie-consent__agree" href="javascript:;">{{ trans('cookieConsent::texts.agree') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif


    @if ($errors->has('userid') || $errors->has('password'))
    <div class="c-cookies-bar c-cookies-bar-2 c-cookies-bar-top c-theme-bg c-theme-darken c-rounded wow animate fadeInDown js-cookie-consent cookie-consent" data-wow-delay="1s">
        <div class="c-cookies-bar-container">
            <div class="row">
                <div class="col-md-10">
                    <div class="c-cookies-bar-content c-font-white cookie-consent__message">
                        User ID / Password do not match.
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="c-cookies-bar-btn">
                        <a class="c-cookies-bar-close btn c-btn-white c-btn-square c-btn-bold js-cookie-consent-agree cookie-consent__agree" href="javascript:;">{{ trans('cookieConsent::texts.agree') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ( Session::has('message') )
    <div class="c-cookies-bar c-cookies-bar-2 c-cookies-bar-top c-theme-bg c-theme-darken c-rounded wow animate fadeInDown js-cookie-consent cookie-consent" data-wow-delay="1s">
        <div class="c-cookies-bar-container">
            <div class="row">
                <div class="col-md-10">
                    <div class="c-cookies-bar-content c-font-white cookie-consent__message">
                        {{  Session::get('message')    }}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="c-cookies-bar-btn">
                        <a class="c-cookies-bar-close btn c-btn-white c-btn-square c-btn-bold js-cookie-consent-agree cookie-consent__agree" href="javascript:;">{{ trans('cookieConsent::texts.agree') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ( Session::has('message') )
    <div class="c-cookies-bar c-cookies-bar-2 c-cookies-bar-top c-theme-bg c-theme-darken c-rounded wow animate fadeInDown js-cookie-consent cookie-consent" data-wow-delay="1s">
        <div class="c-cookies-bar-container">
            <div class="row">
                <div class="col-md-10">
                    <div class="c-cookies-bar-content c-font-white cookie-consent__message">
                        {{  Session::get('message')    }}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="c-cookies-bar-btn">
                        <a class="c-cookies-bar-close btn c-btn-white c-btn-square c-btn-bold js-cookie-consent-agree cookie-consent__agree" href="javascript:;">{{ trans('cookieConsent::texts.agree') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <?php
    if (session('pesan-flash')) {
        $pesanan = session('pesan-flash');
    } else {
        if (!isset($pesanan)) {
            $pesanan = [];
        }
    }
    ?>
    @if ($pesanan && !empty($pesanan))
        @if (is_string($pesanan))
            <div class="c-cookies-bar c-cookies-bar-2 c-cookies-bar-top c-theme-bg c-theme-darken c-rounded wow animate fadeInDown js-cookie-consent cookie-consent" data-wow-delay="1s">
                <div class="c-cookies-bar-container">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="c-cookies-bar-content c-font-white cookie-consent__message">
                                {{  $pesanan['pesan']  }}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="c-cookies-bar-btn">
                                <a class="c-cookies-bar-close btn c-btn-white c-btn-square c-btn-bold js-cookie-consent-agree cookie-consent__agree" href="javascript:;">{{ trans('cookieConsent::texts.agree') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</body>

</html>