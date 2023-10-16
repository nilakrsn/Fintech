@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
      <div class="alert alert-success" role="alert">
          {{ session('status') }}
      </div>
     @endif
     <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-9">
                    <div class="card mb-2 p-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <strong style="font-size: medium;">Saldo : {{$saldo}}</strong>
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
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="number" min="10000" class="form-control" value="10000" name="credit">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-dark" style="background-color: #213555;">Save changes</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col">
                <input type="text" class="form-control p-2" placeholder="Search Here">
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="mb-3">Account mutation</h5>
                    @foreach ($mutasi as $data)
                        <div class="row border-bottom mb-2">
                            <div class="col-md-3">
                                {{ $data->credit ? $data->credit : $data->debit }}
                            </div>
                            <div class="col">
                                {{ $data->credit ? 'Kredit' : 'Debit' }}
                            </div>
                            <div class="col">
                                {{$data->description}}
                            </div>
                            <div class="col">
                                <span class="badge rounded-pill border border-warning text-warning">{{$data->status == 'diproses' ? 'PROSES' : ''}}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5>Transaction History</h5>
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
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <img class="rounded" src="{{$product->photo}}" alt="{{$product->name}}" style="max-width: 100%;">
                                </div>
                                <div class="col">
                                    <h5>{{$product->name}}</h5>
                                    <div class="row mb-2">
                                        <div class="col d-flex">
                                        <strong>Harga :</strong>
                                        </div>
                                        <div class="col text-end">
                                            <strong>Rp.{{$product->price}}</strong>
                                        </div>
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
                    <h5>Cart</h5>
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
                                    {{$cart->price * $cart->quantity}}
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
                <div class="card-footer" style="background-color: transparent;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <span style="font-size: 15px;">Total biaya : {{$total_biaya}}</span>
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
    </div>
</div>
@endsection
