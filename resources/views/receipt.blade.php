@php
    function rupiah($angka){
        
        $hasil_rupiah = "Rp" . number_format($angka,0,',','.');
        return $hasil_rupiah;
    
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>e-Receipt #{{ $transactions[0]->order_id }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="card">
                <div class="card-header px-5 text-center">
                    <h3 style="font-size: 50px">e-Receipt #{{ $transactions[0]->order_id }}</h3>
                </div>
                <div class="card-body">
                    @foreach ($transactions as $transaction)
                    <div class="row" style="font-size: 40px">
                        <div class="col">
                            <div class="mb-4 fw-bold">
                                {{ $transaction->product->name }} 
                            </div>
                            <div class="row">
                                <div class="col">
                                {{ $transaction->quantity }} x 
                                </div>
                                <div class="col text-end">
                                {{rupiah($transaction->price * $transaction->quantity)}}
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
                <div class="card-footer" >
                    <div class="row fw-bold" style="font-size: 40px">
                        <div class="col" >
                            <span>Total biaya : </span>
                        </div>
                        <div class="col text-end">
                            <span>{{rupiah($total_biaya)}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>