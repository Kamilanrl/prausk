<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>e-Receipt #{{ $transactions[0]->order_id }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="card">
                <div class="card-header px-5">
                    <h3 style="font-size: 30px">e-Receipt #{{ $transactions[0]->order_id }}</h3>
                </div>
                <div class="card-body">
                    @foreach ($transactions as $transaction)
                    <div class="row" style="font-size: 20px">
                        <div class="col">
                            <div class="mb-4">
                                <strong>
                                {{ $transaction->product->name }}
                                </strong>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                {{ $transaction->quantity }} x {{ $transaction->price * $transaction->quantity }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer" style="background-color: transparent;">
                    <div class="row" style="font-size: 20px">
                        <div >
                            <span>Total biaya : {{ $total_biaya }}</span>
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
