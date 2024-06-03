@extends('layout.app')
@section('title')
Моя корзина
@endsection
@section('content')
<div class="container" id="Cart">
    @if (session()->has('success'))
    <div class="alert alert-success mt-5">
        {{session('success')}}
    </div>
    @endif
    @if ($order)


    <div class="row mt-5 mb-5">
        <div class="col-auto">
            <h2>Моя корзина</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-9">
            <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col">Товар</th>
                    <th scope="col">Размер</th>
                    <th scope="col" class="text-center">Количество</th>
                    <th scope="col">Цена</th> 
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($carts as $cart)
                    <tr>
                        <th scope="row">{{ $cart->product->title }}</th>
                        @if($cart->size)
                            <td>{{ $cart->size->number }}</td>
                        @else
                            <td>onesize</td>
                        @endif
                        
                        <td>
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <a class="btn" href="{{ route('decrease_cart',['id'=>$cart->product->id]) }}">-</a>
                                </div>
                                <div class="col-4">
                                    <input type="text" @input="set_count({{ $cart }})" value="{{ $cart->count }}" class="form-control" id="product_count_{{ $cart->id }}">
                                </div>
                                <div class="col-auto">
                                    <a class="btn" href="{{ route('add_cart_link',['id'=>$cart->product->id]) }}">+</a>
                                </div>
                            </div>
                        </td>
                        <td>{{ $cart->product->price }}руб. x {{ $cart->count }}шт. = <strong>{{ $cart->price }} руб.</strong></td>
                        <td><a href="{{ route('delete_cart',['id'=>$cart->product->id]) }}"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                          </svg></a></td>
                    </tr>
                    @endforeach


                </tbody>
              </table>
        </div>

    </div>

    <div class="row justify-content-end">
        <div class="col-3">
            <p>ИТОГ: <strong>{{ $order->sum }} руб.</strong></p>
            <button class="btn" data-bs-toggle="modal" data-bs-target="#confirmModal" style="background-color: rgb(28, 27, 102); color:white;">оформить заказ</button>

            <!-- Modal -->
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="confirmModalLabel">Выберите филиал</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('confirm_order',['id'=>$order->id]) }}" method="post">
                            @method('put')
                            @csrf
                           @foreach ($filials as $filial)
                            <div class="form-check">
                            <input class="form-check-input" value="{{ $filial->id }}" type="radio" name="filial" id="filial_{{ $filial->id }}">
                            <label class="form-check-label" for="filial_{{ $filial->id }}">
                            {{ $filial->title }}
                            </label>
                            </div>
                            @endforeach
                            <button class="btn mt-3" type="submit" style="background-color: rgb(28, 27, 102); color:white;">подтвердить</button>

                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row mt-5">
        <h1>Корзина пуста</h1>
    </div>

    @endif

</div>
<script>
    const app = {
        data(){
            return {
                data:[]
            }
        },
        methods:{
            // async get_cart(){
            //     const response_cart = await fetch('{{ route('cart') }}');
            //     this.data = await response_cart.json()
            // }
            async set_count(cart){
                console.log(cart);
                let count = document.getElementById("product_count_"+cart.id).value
                console.log(count)
                let new_cnt = {
                    cart:cart.id,
                    count:count,
                }
                const response = await fetch('{{ route('cart_update') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        'Content-Type':'application/json'
                    },
                    body:JSON.stringify(new_cnt)
                })
                if(response.status==200){
                    location.reload()
                }
                // this.get_cart()

            }
        },
        // mounted(){
        //     this.get_cart()
        //     console.log(this.data)
        // }
    }
    Vue.createApp(app).mount('#Cart')
</script>
@endsection
