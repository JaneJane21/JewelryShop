@extends('layout.app')
@section('title')
{{ $product->title }}
@endsection
@section('content')
<div class="container mt-5" id="Detail">
    @if (session()->has('success'))
    <div class="alert alert-success mt-5 mb-5">
        {{session('success')}}
    </div>
    @endif
    <a class="btn btn-link mb-3" style="color: rgb(28, 27, 102)" href="{{ route('catalog') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="rgb(28, 27, 102)" class="bi bi-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
      </svg>назад</a>
    <div class="row mb-5">
        <div class="col-6">
            <div id="carousel_{{ $product->id }}" class="carousel slide w-75">
                <div class="carousel-inner" >
                    @foreach (explode(';', $product->images) as $key=>$img)
                        <div  class="carousel-item {{ $key==0?'active':'' }}">

                            <img src="{{ asset('public'.$img) }}" class="d-block img-fluid" alt="...">

                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel_{{ $product->id }}" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carousel_{{ $product->id }}" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-6">
            <h1 class="">{{ $product->title }}</h1>
            <hr class="mb-5">
            <h2 class="mb-3">{{ $product->price }} рублей</h2>
            @guest
            <div class="row mb-5 align-items-center">
                <div class="col-auto">
                    <a href="{{ route('login') }}" class="btn d-flex align-items-center" style="background-color: rgb(28, 27, 102); color:white;"><span style="margin-right: 5px;">В корзину</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                        </svg>
                    </a>
                </div>
                <div class="col-auto">
                    <a style="color: black" href="{{ route('login') }}">

                        <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                        </svg>

                    </a>
                </div>
            </div>
            @endguest
            @auth
                <div v-if="sizes" class="row mb-5 align-items-center">
                    <div class="form-check" v-for="(size,index) in sizes">
                        <input required v-model="selectedSize" @change="choose_size(size)" :value="size" :checked="index==0? true : false"  class="form-check-input" type="radio" name="size" :id="`size_${ size }`">
                        <label class="form-check-label" :for="`size_${ size }`">
                          @{{ size }}
                        </label>
                    </div>
                </div>
              <div class="row mb-5 align-items-center">
                    <div class="col-auto">
                        <button @click="add_cart"  class="btn d-flex align-items-center" style="background-color: rgb(28, 27, 102); color:white;"><span style="margin-right: 5px;">В корзину</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                            </svg>
                        </a>
                    </div>
                    <div class="col-auto">
                        <a style="color: black" href="{{ route('add_fav') }}/{{ $product->id }}">
                            @if ($is_fav)
                            <svg  xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-heart" viewBox="0 0 16 16">
                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                            </svg>
                            @endif
                        </a>
                    </div>
                </div>
            @endauth

            <p>{{ $product->description }}</p>

        </div>
    </div>
    <div class="row mb-5">
        <div class="col-6">
           <h2>Характеристики</h2>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Категория: </strong>{{ $product->type->title }}</li>
                <!-- @if ($product->subtype)
                <li v-if="product.subtype" class="list-group-item"><strong>Подкатегория:</strong>{{ $product->subtype->title }}</li>
                @endif -->
                <li class="list-group-item"><strong>Материал: </strong>{{ $product->material->title }}</li>
                <li class="list-group-item"><strong>Проба: </strong>{{ $product->sample->title }}</li>
                <li class="list-group-item"><strong>Вставка: </strong>{{ $product->stone->title }}</li>
                <li class="list-group-item"><strong>Огранка: </strong>{{ $product->cutting->title }}</li>
                <li class="list-group-item"><strong>Для кого: </strong>{{ $product->whome->title }}</li>
                <li class="list-group-item"><strong>Бренд: </strong>{{ $product->brand->title }}</li>
            </ul>
        </div>
        <div class="col-6">
            <h2>Наличие в филиалах</h2>
            @foreach ($stock as $elem)
                <div class="row">
                    <div class="col-4">
                        <p>{{ $elem->filial->title }}</p>
                    </div>
                    <div class="col-auto">
                      @if ($elem->size)
                        <p> размер: <strong>{{ $elem->size->number }}</strong></p>
                    @endif
                    </div>
                    <div class="col-auto">

                        <p>{{ $elem->count }} шт.</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <div class="row mb-5">
        <div class="col-12 mb-5">
            <div class="row mb-3 align-items-center">
                <div class="col-auto">
                    <h2 class="">Отзывы</h2>
                </div>
                <div class="col-auto">
                    {{ count($reviews) }}
                </div>
            </div>

            <form action="{{ route('store_review',['id'=>$product->id]) }}" method="post">
                @csrf
                @method('post')
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="positive" class="form-label">Достоинства:</label>
                            <textarea type="text" placeholder="Отметьте положительные качества товара" class="form-control" id="positive" name="positive"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="negative" class="form-label">Недостатки:</label>
                            <textarea type="text" placeholder="Отметьте отрицательные качества товара" class="form-control" id="negative" name="negative"></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="text" class="form-label">Комментарий:</label>
                            <textarea placeholder="Оставьте мнение о товаре" type="text" name="text" class="form-control" style="height: 173px;" id="text"></textarea>
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn" style="background-color: rgb(28, 27, 102); color:white;">Сохранить</button>
            </form>
        </div>
        <div class="col-6">
            @foreach ($reviews as $rev)
            <div class="row rev-block mb-4">
                <div class="row mb-3">
                    <div class="col-auto">
                        <strong>{{ $rev->user->fio }}</strong>
                    </div>
                    <div class="col-auto">
                        <p style="color: grey">{{ $rev->created_at }}</p>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                           <strong>Достоинства:</strong>
                            @if($rev->positive)
                                <p style="color: ">{{ $rev->positive }}</p>
                            @else
                            <p style="color: grey">не указано</p>
                            @endif
                        </div>
                        <div class="col-4">
                            <strong>Недостатки:</strong>
                            @if($rev->negative)
                                <p>{{ $rev->negative }}</p>
                            @else
                                <p style="color: grey">не указано</p>
                            @endif
                        </div>
                        <div class="col-4">
                           @if($rev->text)
                            <strong>Комментарий:</strong>
                            <p>{{ $rev->text }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @if($rev->user->id === Auth::id())
                    <div class="row">
                        <div class="col-auto">
                            <a href="{{ route('delete_review',['id'=>$rev->id]) }}" class="btn btn-outline-danger">удалить отзыв</a>
                        </div>
                    </div>
                @endif

            </div>
            @endforeach
        </div>
    </div>

</div>
<style>
    li{
        background-color: transparent !important;
    }
    .rev-block{
        background-color: white;
        padding: 10px;
        border-radius: 10px;
    }
</style>
<script>
    const app = {
        data(){
            return {
                stock: [],
                sizes:[],
                selectedSize: ''
            }
        },
        methods:{
            async getSizes(){
                const response_stock = await fetch('{{ route('get_stock') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        'Content-Type':'application/json'
                    },
                    body:JSON.stringify({id:{{ $product->id }}})
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
                    console.log(this.selectedSize)
                }
            },
            async add_cart(){
                const response_cart = await fetch('{{ route('add_cart') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        'Content-Type':'application/json'
                    },
                    body:JSON.stringify({id:{{ $product->id }},
                                        size:this.selectedSize})
                })
            },
            choose_size(size){
                console.log(this.selectedSize)
            }
        },
        mounted(){
            this.getSizes()
  
        }
    }
    Vue.createApp(app).mount('#Detail')
</script>
@endsection
