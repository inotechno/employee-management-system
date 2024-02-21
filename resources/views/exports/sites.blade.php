<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Site Dan QRCode</title>

    <style>
        @page {
            margin: 0 auto;
        }

        body {
            text-align: center;
            margin: 72 auto;
        }

        .row {
            display: grid;
            grid-template-columns: repeat(2, 400px);
            grid-template-rows: 0px;
            grid-gap: 0px;
        }

        .image {
            width: 330px;
        }
    </style>

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> --}}
</head>

<body>

    {{-- <table class="table text-center">
        <tr> --}}
    <div class="row">
        <img class="image" src="{{ public_path('bg_qrcode.png') }}" alt="">
        <img class="image" src="{{ public_path('bg_qrcode.png') }}" alt="">
        <img class="image" src="{{ public_path('bg_qrcode.png') }}" alt="">
        <img class="image" src="{{ public_path('bg_qrcode.png') }}" alt="">
    </div>
    {{-- </tr>
    </table> --}}
    {{--
    <table class="table" style="width: 100%;text-align:center" border="1">
        <thead>
            <tr>
                <td>
                    <img style="width: 90%;margin:10px" src="{{ public_path('bg_qrcode.png') }}" alt="">
                </td>

                <td>
                    <img style="width: 90%;margin:10px" src="{{ public_path('bg_qrcode.png') }}" alt="">
                </td>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table> --}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
