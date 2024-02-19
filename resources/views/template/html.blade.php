<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap5.min.css') }}">
    
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/responsive.bootstrap5.min.js') }}"></script>
</head>
<style>

    body{
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background-color: #e5e3d6e7;
    }

    .mtp{
        margin-top: 7em;
        margin-bottom: 7em;
    }

    .card{
        /* border-top: #ced4da; */
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .card-hover:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Warna bayangan sedikit lebih gelap saat hover */
    }

    .card {
        transition: transform 0.3s ease;
    }

    .card-hover:hover {
        transform: scale(1.05); /* Perbesar kartu saat hover */
    }

    .border-bottom {
        border: none;
        border-bottom: 1px solid #ced4da; /* Bootstrap gray color for the underline */
        border-radius: 0;
    }

    footer{
        margin-top: auto;
        width: 100%;
    }

</style>
<body>
    @yield('body')
    <footer class="text-light text-center p-3" style="background-color: black">
        <div class="row m-3">
            <div class="col-5 m-4">
                <h5 class="text-start">Kontak Kami</h5>
                <p class="text-start">
                    No Telepon : <a href="#" class="text-white">+62666999</a>
                    <br>
                    Whatsapp : <a href="#" class="text-white">+62666999</a>
                    <br>
                    Email : <a href="#" class="text-white">superadmintixTake@gmail.com</a>
                </p>
                <h6 class="text-start"> Alamat </h6>
                <p class="text-start"> Jl. Indah No 1 iya indah kaya kamu yang no1 di hatiku ❤️😘</p>
            </div>
            <div class="col-5 m-3">
                <img src="{{ asset('img/pertajam.png') }}" class="mb-2" style="width: 100px">
                <p>Tix.Take adalah sebuah platform yang dirancang untuk memberikan kemudahan kepada pengguna dalam menemukan, memilih, dan membeli tiket event tanpa perlu menghabiskan waktu untuk mengantri atau mencari informasi tiket secara manual.</p>
            </div>
        </div>
        &copy; {{ date('Y') }} Tix.Take
    </footer>
<script>
    new DataTable('#example',{
        responsive : true;
    });
</script>
</body>
</html>