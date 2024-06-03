@extends('layout.app')
@section('title')
Мое избранное
@endsection
@section('content')
<div class="container" id="Favs">
    <div class="row mt-5">
        <div class="col-auto">
            <h2>Мое избранное</h2>
        </div>
    </div>

    <div class="row">
        @foreach ($favs as $fav)
            <div class="col-8 m-2" style="background-color: white; border-radius:6px;">
                <div class="row align-items-center">
                    <div class="col-3" style="padding: 0;">
                        <div id="carousel_{{ $fav->product->id }}" class="carousel slide w-75">
                            <div class="carousel-inner" >
                                @foreach (explode(';', $fav->product->images) as $key=>$img)
                                    <div  class="carousel-item {{ $key==0?'active':'' }}">
            
                                        <img src="{{ asset('public'.$img) }}" class="d-block img-fluid" alt="...">
            
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel_{{ $fav->product->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                            </button>
            
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel_{{ $fav->product->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-auto">
                        <p class="mt-3">{{ $fav->product->title }}</p>
                        
                        <p class="mb-3">{{ $fav->product->price }} рублей</p>
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <button data-bs-toggle="modal" data-bs-target="#sizeModal_{{$fav->product->id}}" @click="getSizes({{$fav->product->id}})" class="btn d-flex align-items-center" style="background-color: rgb(28, 27, 102); color:white;"><span style="margin-right: 5px;">В корзину</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                                    <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                                </svg>
                                </button>
                            </div>
                            <div class="col-auto">
                                <a style="color: black" href="{{ route('add_fav') }}/{{ $fav->product->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </a>
                            </div>
                            
                        </div>
                        <!-- Модальное окно -->
                        <div class="modal fade" id="sizeModal_{{$fav->product->id}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="sizeModalLabel" aria-hidden="true">  
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="sizeModalLabel">Выберите размер</h5>
                                <button type="button" @click="clear_data" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                </div>
                                <div class="modal-body">
                                    <div v-if="sizes.length>0" class="row mb-5 align-items-center p-1">
                                        <div class="form-check" v-for="(size,index) in sizes">
                                            <input v-model="selectedSize"  :value="size" :checked="index==0? true : false"  class="form-check-input" type="radio" name="size" :id="`size_${ size }`">
                                            <label class="form-check-label" :for="`size_${ size }`">
                                              @{{ size }}
                                            </label>

                                        </div>
                                        <div class="col-auto mt-3">
                                            <button data-bs-dismiss="modal" @click="add_cart({{$fav->product->id}})" class="btn d-flex align-items-center" style="background-color: rgb(28, 27, 102); color:white;"><span style="margin-right: 5px;">В корзину</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                                                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                                            </svg>
                                            </button>
                                        </div>
                                        
                                    </div>
                                    <div class="" v-else>
                                        <p>Обратите внимание! Товар имеет единый размер</p>
                                        <div class="col-auto mt-3">
                                            <button data-bs-dismiss="modal" @click="add_cart({{$fav->product->id}})" class="btn d-flex align-items-center" style="background-color: rgb(28, 27, 102); color:white;"><span style="margin-right: 5px;">В корзину</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                                                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                                            </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
               
        @endforeach
        
            
    </div>
</div>

<script>
    const app = {
        data(){
            return {
                stock: [],
                sizes:[],
                selectedSize: '',
            }
        },
        methods:{
            clear_data(){
                this.sizes = []
                this.selectedSize = ''
                console.log('clear')
            },
            async getSizes(product){
                const response_stock = await fetch('{{ route('get_stock') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        'Content-Type':'application/json'
                    },
                    body:JSON.stringify({id:product})
                })
                if(response_stock.status == 200){
                    this.stock = await response_stock.json()
                    console.log(this.stock)

                    for (let i of this.stock){
                        if(i.size && !this.sizes.includes(i.size.number)){
                            this.sizes.push(i.size.number)
                        }
                    }
                    this.selectedSize = this.sizes[0]
                    console.log(this.sizes)
                }
            },
            async add_cart(product){
                console.log(product)
                const response_cart = await fetch('{{ route('add_cart') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        'Content-Type':'application/json'
                    },
                    body:JSON.stringify({id:product,
                                        size:this.selectedSize})
                })
            },

        },
    }
    Vue.createApp(app).mount('#Favs')
</script>
@endsection