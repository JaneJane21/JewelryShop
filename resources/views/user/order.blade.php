@extends('layout.app')
@section('title')
Мои заказы
@endsection
@section('content')
<div class="container" id="Orders">
    @if (session()->has('success'))
    <div class="alert alert-success mt-5">
        {{session('success')}}
    </div>
    @endif
    <div class="row mt-5">
        <div class="col-auto">
            <h2>Мои заказы</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-7">
            <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col"># заказа</th>
                <th scope="col">Сумма заказа</th>
                <th scope="col">Будет доступно в филиале</th>
                <th scope="col">Срок хранения</th>
                <th scope="col">Место выдачи</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr @click="get_goods({{ $order }})">
                    <th scope="row">{{ $order->id }}</th>
                    <td><strong>{{ $order->sum }}</strong> рублей</td>
                    
                    @if($order->date_start)
                    <td>{{ $order->date_start }}</td> 
                    @else
                    <td>скоро</td> 
                    @endif
                    @if($order->date_end)
                    <td>{{ $order->date_end }}</td> 
                    @else
                    <td>скоро</td> 
                    @endif
                    <td><strong>{{ $order->filial->title }}</strong> ({{ $order->filial->address }})</td>
                    <td><a class="btn btn-link" @click="update_total" href="{{ route('cancel_order',['order'=>$order]) }}">отменить заказ</a></td>
                </tr>
                @endforeach
              
            </tbody>
          </table>
        </div>
        <div style="background-color: white; border-radius:6px;" v-if="goods.length>0" class="col-4 p-4 m-1">
            <h3>Состав заказа:</h3>
            <div class="row " v-for="el in goods">
                <div class="col-4" v-if="el.product.images" style="padding: 0;">
                        <div :id="`carousel_${el.product.id}`" class="carousel slide">
                    <div class="carousel-inner" >
                    <div v-for="(img, index) in el.product.images.split(';')" :class="index==0?'active':''" class="carousel-item">
                            <img :src="'/public'+img" class="d-block img-fluid" alt="...">
                    </div>

                    </div>
                    <button class="carousel-control-prev" type="button" v-bind:data-bs-target="`#carousel_${el.product.id}`" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" v-bind:data-bs-target="`#carousel_${el.product.id}`" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                    </button>
                        </div>
                </div>
                <div class="col-4">
                    @{{ el.product.title }}
                </div>
                <div v-if="el.size" class="col-4">
                    Размер: @{{ el.size.number }}
                </div>
                <div v-else class="col-4">
                    Размер: onesize
                </div>
            </div>
        </div>
        
        
    </div>
    <div class="row mt-5">
        <div class="col-auto">
            <h2>История заказов</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-7">
            <table class="table">
            <thead>
              <tr>
                <th scope="col"># заказа</th>
                <th scope="col">Статус заказа</th>
                <th scope="col">Сумма заказа</th>
                
                <th scope="col">Место выдачи</th>
                
              </tr>
            </thead>
            <tbody>
                @foreach ($history as $order)
                <tr>
                    {{-- @click="get_goods({{ $order }})" --}}
                    <th scope="row">{{ $order->id }}</th>
                    @if($order->status == 'отменен')
                        <td style="color: red">{{ $order->status }}</td>
                    @else
                        <td style="color: green">{{ $order->status }}</td>
                    @endif
                    
                    <td><strong>{{ $order->sum }}</strong> рублей</td>
                    
                        {{-- @if($order->date_end)
                        <td>{{ $order->date_end }}</td> 
                        @else
                        <td></td> 
                        @endif --}}
                    <td><strong>{{ $order->filial->title }}</strong> ({{ $order->filial->address }})</td>
                    
                </tr>
                @endforeach
              
            </tbody>
          </table>
        </div>
        {{-- <div style="background-color: white; border-radius:6px;" v-if="goods.length>0" class="col-4 p-4 m-1">
            <h3>Состав заказа:</h3>
            <div class="row " v-for="el in goods">
                <div class="col-4" v-if="el.product.images" style="padding: 0;">
                        <div :id="`carousel_${el.product.id}`" class="carousel slide">
                    <div class="carousel-inner" >
                    <div v-for="(img, index) in el.product.images.split(';')" :class="index==0?'active':''" class="carousel-item">
                            <img :src="'/public'+img" class="d-block img-fluid" alt="...">
                    </div>

                    </div>
                    <button class="carousel-control-prev" type="button" v-bind:data-bs-target="`#carousel_${el.product.id}`" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" v-bind:data-bs-target="`#carousel_${el.product.id}`" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                    </button>
                        </div>
                </div>
                <div class="col-4">
                    @{{ el.product.title }}
                </div>
                <div v-if="el.size" class="col-4">
                    Размер: @{{ el.size.number }}
                </div>
                <div v-else class="col-4">
                    Размер: onesize
                </div>
            </div>
        </div> --}}
        
        
    </div>
</div>
<script>
    const app = {
        data(){
            return {
                goods:[]
            }
        },
        methods:{
            async get_goods(order){
                this.goods = []
                console.log(order)
                const response_goods = await fetch('{{ route('show_order') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        'Content-Type':'application/json'
                    },
                    body:JSON.stringify({
                        id:order.id
                    })
                })
                if(response_goods.status == 200){
                    this.goods = await response_goods.json()
                    console.log(this.goods)
                }
            },
            update_total(){
                // this.get_num()
            }


        }
    }
    Vue.createApp(app).mount('#Orders')
</script>
@endsection