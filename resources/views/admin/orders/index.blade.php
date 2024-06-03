@extends('layout.app')
@section('title')
Все заказы
@endsection
@section('content')
<div class="container" id="All_Orders">
    <div class="row mt-5">
        <div class="col-auto">
            <h2>Все заказы</h2>
        </div>
    </div>
    <div class="row mt-3 mb-5">
        <div class="col-12">
            <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col"># заказа</th>
                <th scope="col">Статус заказа</th>
                <th scope="col">Заказчик</th>
                <th scope="col">Сумма заказа</th>
                <th scope="col">Место выдачи</th>
                <th scope="col">Дата поступления в филиал</th>
                <th scope="col">Срок хранения в филиале</th>
                <th scope="col">Действия</th>
                <th scope="col">Комментарий администратора</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr @click="get_goods({{ $order }})">
                    {{-- @click="get_goods({{ $order }})" --}}
                    <th scope="row">{{ $order->id }}</th>
                    @if($order->status == 'отменен')
                        <td style="color: red">{{ $order->status }}</td>
                    @else
                        <td style="color: green">{{ $order->status }}</td>
                    @endif
                    <td>{{ $order->user->fio }}</td>
                    <td><strong>{{ $order->sum }}</strong> руб</td>
                    
                        {{-- @if($order->date_end)
                        <td>{{ $order->date_end }}</td> 
                        @else
                        <td></td> 
                        @endif --}}
                    <td><strong>{{ $order->filial->title }}</strong> ({{ $order->filial->address }})</td>
                    <td>
                    @if($order->date_start)
                       {{ $order->date_start }} 
                    {{-- <button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                      </svg>
                    </button>  --}}
                    @endif    
                    </td>
                    <td>
                        @if($order->date_end)
                        {{ $order->date_end }}
                        {{-- <button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                          </svg>
                        </button> --}}
                        @endif
                    </td>
                    <td>
                        <div class="row">
                            @if($order->status == 'в обработке')
                            <button type="button" @click="update_total" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $order->id }}" class="col-12 mb-3 btn btn-outline-primary">подтвердить</button>
                            <!-- Modal -->
                            <div class="modal fade" id="confirmModal{{ $order->id }}" tabindex="-1" aria-labelledby="confirmModal{{ $order->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="confirmModal{{ $order->id }}Label">Подтверждение заказа #{{ $order->id }}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="post" action="{{ route('admin_confirm',['order'=>$order]) }}">
                                        @csrf
                                        @method('put')
                                        <div class="row mb-4">
                                            <div class="col-6">
                                                <label class="label-control" for="date_start">Дата поступления в филиал</label>
                                                <input type="date" class="form-control" id="date_start" name="date_start">
                                            </div>
                                            <div class="col-6">
                                                <label class="label-control" for="date_end">Дата завершения хранения в филиале</label>
                                                <input type="date" class="form-control" id="date_end" name="date_end">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Сохранить</button>
                                    </form>
                                    </div>
                                    
                                
                                </div>
                                </div>
                            </div>
                            @endif
                            @if($order->status == 'подтвержден')          
                            <button data-bs-toggle="modal" data-bs-target="#cancelModal{{ $order->id }}" class="col-12 mb-3 btn btn-outline-danger">отменить</button>
                            <!-- Modal -->
                            <div class="modal fade" id="cancelModal{{ $order->id }}" tabindex="-1" aria-labelledby="cancelModal{{ $order->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="cancelModal{{ $order->id }}Label">Отмена заказа #{{ $order->id }}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="post" action="{{ route('admin_cancel',['order'=>$order]) }}">
                                        @csrf
                                        @method('put')
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <label class="label-control" for="comment">Причина отмены</label>
                                                <textarea class="form-control" id="comment" name="comment"></textarea>
                                            </div>
                                            
                                        </div>
                                        <button type="submit" class="btn btn-primary">Сохранить</button>
                                    </form>
                                    </div>
                                    
                                
                                </div>
                                </div>
                            </div>
                            <a href="{{ route('admin_done',['order'=>$order]) }}" class="col-12 mb-3 btn btn-outline-success">заказ получен</a> 
                            @endif
                        </div>
                    </td>
                    <td>{{ $order->comment }}</td>
                </tr>
                @endforeach
              
            </tbody>
          </table>
        </div>
        <div style="background-color: white; border-radius:6px;" v-if="goods.length>0" class="col-5 p-4">
            <h3>Состав заказа:</h3>
            <div class="row mb-2" v-for="el in goods">
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
                <div class="col-8">
                    @{{ el.product.title }}
                    <div v-if="el.size">
                    <strong>Размер: @{{ el.size.number }}</strong>
                    </div>
                    <div v-else>
                        Размер: onesize
                    </div>
                </div>
                
            </div>
        </div>
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
    Vue.createApp(app).mount('#All_Orders')
</script>
@endsection