@extends('layouts.app')

@php
    function rupiah($angka){
        
        $hasil_rupiah = "Rp" . number_format($angka,0,',','.');
        return $hasil_rupiah;
    
    }
@endphp

@section('content')
<div class="container">
    @if (session('status'))
      <div class="alert alert-success" role="alert">
          {{ session('status') }}
      </div>
     @endif
     <div class="row justify-content-center">
        @if(Auth::user()->role == "bank")
        <div class="col-md-3">
            <div class="card mb-3 ">
                <div class="card-body">
                    <div class="row d-flex">
                        <div class="col">
                            <p class="lead fw-bold">Balance</p>
                            <h4>{{rupiah($saldo)}}</h4>
                        </div>
                        <div class="col text-end ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5em"  fill="gray" class="bi bi-cash" viewBox="0 0 16 16">
                            <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                            <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row d-flex">
                        <div class="col">
                            <p class="lead fw-bold">Customer</p>
                            <h4>{{$nasabah}}</h4>
                        </div>
                        <div class="col text-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5em" fill="gray" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <p class="lead fw-bold">Transactions</p>
                            <h4>{{$transactions}}</h4>
                        </div>
                        <div class="col text-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="5em" fill="gray" class="bi bi-bag" viewBox="0 0 16 16">
                            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="fw-bold">
                    Account mutation
                    </h5>
                    @foreach($requestTopUp as $request)
                        <div class="row border-top mb-2">
                        <form action="{{ route('acceptRequest')}}" method="POST" >
                            <input type="hidden" value="{{$request->id}}" name="wallet_id">
                            @csrf
                           <div class="mt-3 d-flex align-items-center">
                                <div class="col">
                                    {{$request->user->name}}
                                </div>
                                <div class="col">
                                    {{rupiah($request->credit)}}
                                </div>
                                <div class="col">
                                    {{$request->created_at}}
                                </div>
                                <div class="col">
                                    <button class="btn btn-dark" type="submit" style="background-color: #213555;">
                                        Accept Request
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
      
        @elseif(Auth::user()->role == "siswa")
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-9">
                    <div class="card mb-3 p-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <span class="fw-bold" style="font-size: medium;">Balance : {{rupiah($saldo)}}</span>
                            </div>
                            <div class="col text-end">
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#formTopUp" style="background-color: #213555;">
                                Top Up
                                </button>
                            </div>
                        </div>

                        <!-- Modal -->
                        <form action="{{ route('topUp') }}" method="POST">
                            @csrf
                            <div class="modal fade" id="formTopUp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Top Up</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="number" min="10000" class="form-control" value="10000" name="credit">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-dark" style="background-color: #213555;">Top Up</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col">
                <input type="text" class="form-control p-2 mb-3" placeholder="Search Here">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="fw-bold">
                    Account mutation
                    </h5>
                    @foreach ($mutasi as $data)
                        <div class="row border-top mb-2">
                            <div class="d-flex align-items-center mb-3">
                                <div class="col">
                                    {{ rupiah($data->credit ? $data->credit : $data->debit) }}
                                </div>
                                <div class="col">
                                    {{ $data->credit ? 'Kredit' : 'Debit' }}
                                </div>
                                <div class="col">
                                    {{$data->description}}
                                </div>
                                <div class="col text-end">
                                @if ($data->status == 'diproses' && $data->description == 'top up saldo')
                                    <span class="badge rounded-pill bg-warning text-dark ">PROSES</span>
                                @elseif ($data->status == 'selesai' && $data->description == 'top up saldo')
                                    <span class="badge rounded-pill bg-success">SELESAI</span>
                                @endif
    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="fw-bold">Transaction History</h5>
                    @foreach ($transactions as $key => $transaction)
                   <div class="row">
                        <div class="col d-flex justify-content-start align-items-center">
                            <div class="row">
                                <div class="col">
                                    <strong>{{$transaction[0]->order_id}}</strong>
                                </div>
                                <div class="col">
                                    {{$transaction[0]->created_at}}
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end align-items-center">
                            <a href="{{ route('download', ['order_id' => $transaction[0]->order_id]) }}" class="btn btn-dark" style="background-color: #213555;" target="_blank">
                                Download
                            </a>
                        </div>
                   </div>
                   @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                @foreach ($products as $key => $product)
                <form method="POST" action="{{ route('addToCart') }}">
                     @csrf
                     <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                     <input type="hidden" value="{{$product->id}}" name="product_id">
                     <input type="hidden" value="{{$product->price}}" name="price">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <img class="rounded" src="{{$product->photo}}" alt="{{$product->name}}" style="max-width: 100%;">
                                </div>
                                <div class="col">
                                    <h5 class="fw-bold">{{$product->name}}</h5>
                                    <div class="row mb-2">
                                        <div class="col d-flex">Price :</div>
                                        <div class="col text-end"> {{rupiah($product->price)}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <input class="form-control" type="number" name="quantity" value="1" min="1">
                                                </div>
                                                <div class="col text-end">
                                                    <button type="submit" class="btn btn-dark" style="background-color: #213555;">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </form>
                @endforeach
            </div>

        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="fw-bold">Cart</h5>
                    @foreach ($carts as $key => $cart)
                    <div class="row">
                        <div class="col">
                            <div>
                                <strong>
                                {{$cart->product->name}}
                                </strong>
                            </div>
                            <div class="row">
                                <div class="col">
                                    {{$cart->quantity}}x
                                </div>
                                <div class="col text-end">
                                    {{rupiah($cart->price * $cart->quantity)}}
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
                <div class="card-footer" style="background-color: transparent;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <span style="font-size: 15px;">Total biaya : {{rupiah($total_biaya)}}</span>
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('payNow') }}" method="POST">
                                @csrf
                                <div class="d-grid">
                                    <button type="submit"  class="btn btn-dark" style="background-color: #213555;">Pay</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>       
        </div>
       
        @elseif(Auth::user()->role == "kantin")
        dd(Auth::user())
        @endif
    </div>
</div>
@endsection
