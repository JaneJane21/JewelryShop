@extends('layout.app')
@section('title')
CASSIOPEIA CATALOG
@endsection
@section('content')
<div class="container" id="Catalog">
    @if (session()->has('success'))

    {{-- <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <strong class="me-auto">Bootstrap</strong>
            <small>11 мин назад</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
          </div>
          <div class="toast-body">
            Привет, мир! Это тост-сообщение.
          </div>
        </div>
    </div> --}}

    <div class="alert alert-success mt-5">
        {{session('success')}}
    </div>

    @endif
    <div class="row mt-5">
        <div class="col-auto">
            <h1>Все товары</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-2" style="margin-right: 40px;">
            <div class="row mt-5 justify-content-between align-items-center">
                <input @input="searchProduct" v-model="searchInput" class="form-control" placeholder="Я ищу...">
            </div>
            <div class="row mt-5 justify-content-between align-items-center">
                <div class="col-12 mb-4">
                    <label for="type_id" class="form-label">Категория</label>
                    <select @change="filterType" v-model="selectedType" id="type_id" class="form-select" name="type_id">
                        <option value="">Выбрать категорию</option>
                      <option v-for="type in types" :value="type.id">@{{type.title}}</option>
                    </select>

                  </div>
                  <div v-if="subtypesForType.length>0" class="col-12 mb-4">
                    <label for="subtype_id" class="form-label">Подкатегория</label>
                    <select  @change="filterSubtype" id="subtype_id" v-model="selectedSubType" class="form-select" name="subtype_id">
                        <option value="">Выбрать подтип</option>
                        <option v-for="subtype in subtypesForType" :value="subtype.id">@{{subtype.title}}</option>
                    </select>

                </div>
                <div v-if="sizesForType.length>0" class="col-12 mb-4">
                    <label for="size_шв" class="form-label">Размерный ряд</label>
                    <select  @change="filterSizetype" id="size_id" v-model="selectedSizeType" class="form-select" name="size_id">
                        <option value="">Выбрать размер</option>
                        <option v-for="size in sizesForType" :value="size.id">@{{size.number}}</option>
                    </select>
                </div>
                <div class="col-12 mb-4">
                    <label for="material_id" class="form-label">Материал</label>
                    <select  @change="filterMaterial" v-model="selectedMaterial" id="material_id" class="form-select" name="material_id">
                        <option value="">Выбрать материал</option>
                        <option v-for="material in materials" :value="material.id">@{{material.title}}</option>
                    </select>

                </div>
                <div class="col-12 mb-4">
                    <label for="cutting_id" class="form-label">Огранка</label>
                    <select  @change="filterCutting" v-model="selectedCutting" id="cutting_id" class="form-select" name="cutting_id">
                        <option value="">Выбрать огранку</option>
                        <option v-for="cutting in cuttings" :value="cutting.id">@{{cutting.title}}</option>
                    </select>

                </div>
                <div class="col-12 mb-4">
                    <label for="stone_id" class="form-label">Вставка</label>
                    <select  @change="filterStone" v-model="selectedStone" id="stone_id" class="form-select" name="stone_id">
                        <option value="">Выбрать вставку</option>
                        <option v-for="stone in stones" :value="stone.id">@{{stone.title}}</option>
                    </select>

                </div>
                <div class="col-12 mb-4">
                    <label for="whome_id" class="form-label">Для кого</label>

                    <select  @change="filterWhome" v-model="selectedWhome" id="whome_id" class="form-select" name="whome_id">
                        <option value="">Выбрать для кого</option>
                        <option v-for="whom in whoms" :value="whom.id">@{{whom.title}}</option>
                    </select>

                </div>
                <div class="col-12 mb-4">
                    <label for="brand_id" class="form-label">Бренд</label>
                    <select  @change="filterBrand" v-model="selectedBrand" id="brand_id" class="form-select" name="brand_id">
                        <option value="">Выбрать бренд</option>
                        <option v-for="brand in brands" :value="brand.id">@{{brand.title}}</option>
                    </select>

                </div>
                <div class="col-12 mb-4">
                    <label for="sample_id" class="form-label">Проба</label>
                    <select  @change="filterSample" v-model="selectedSample" id="sample_id" class="form-select" name="sample_id">
                        <option value="">Выбрать пробу</option>
                        <option v-for="sample in samples" :value="sample.id">@{{sample.title}}</option>
                    </select>

                </div>
            </div>
        </div>
        <div  class="col-9">
            <div class="row">
                <div class="col-auto" v-for="product in filterSample">
                    <div class="card" style="width: 18rem; height: 35rem;">
                    <div class="" v-if="product.images">
                        <div :id="`carousel_${product.id}`" class="carousel slide">
                    <div class="carousel-inner" >
                    <div v-for="(img, index) in product.images.split(';')" :class="index==0?'active':''" class="carousel-item">
                            <img :src="'/public'+img" class="d-block img-fluid" alt="...">
                    </div>

                    </div>
                    <button class="carousel-control-prev" type="button" v-bind:data-bs-target="`#carousel_${product.id}`" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" v-bind:data-bs-target="`#carousel_${product.id}`" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                    </button>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                    <p class="card-title">@{{ product.title }}</p>
                    <h5 class="card-title">@{{ product.brand.title }}</h5>
                    <div class="row mb-4 align-items-center justify-content-between">
                        <div class="col-auto">
                            <p style="color: rgb(28, 27, 102); font-size: 14px;" class="card-text">@{{ product.price }} рублей</p>
                        </div>
                        <div class="col-auto">
                            <a :href="`{{ route('detail') }}/${product.id}`" style="color: rgb(28, 27, 102); font-size: 14px;" class="btn btn-link">подробнее</a>
                        </div>
                    </div>
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
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto">
                                <a style="color: black" :href="`{{ route('add_fav') }}/${product.id}`">
                                <svg v-if="favorites.includes(product.id)" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-heart" viewBox="0 0 16 16">
                                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                </svg>
                                </a>

                            </div>

                            <div class="col-auto">

                                <button data-bs-toggle="modal" :data-bs-target="`#sizeModal_${product.id}`" @click="getSizes(product)" class="btn d-flex align-items-center" style="background-color: rgb(28, 27, 102); color:white;"><span style="margin-right: 5px;">В корзину</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                                        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                                    </svg>
                                </button>
                            </div>
                            <!-- Модальное окно -->
                            <div class="modal fade" :id="`sizeModal_${product.id}`" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="sizeModalLabel" aria-hidden="true">
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
                                                <button data-bs-dismiss="modal" @click="add_cart(product)" class="btn d-flex align-items-center" style="background-color: rgb(28, 27, 102); color:white;"><span style="margin-right: 5px;">В корзину</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                                                    <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                                                </svg>
                                                </button>
                                            </div>

                                        </div>
                                        <div class="" v-else>
                                            <p>Обратите внимание! Товар имеет единый размер</p>
                                            <div class="col-auto mt-3">
                                                <button data-bs-dismiss="modal" @click="add_cart(product)" class="btn d-flex align-items-center" style="background-color: rgb(28, 27, 102); color:white;"><span style="margin-right: 5px;">В корзину</span>
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
                    @endauth
                    </div>
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
                catalog:[],

                types:[],
                stones:[],
                whoms:[],
                cuttings:[],
                samples:[],
                materials:[],
                brands:[],
                filials:[],
                favorites:[],

                subtypesForType:[],
                sizesForType:[],

                selectedType:'',
                selectedSubType:'',
                selectedSizeType:'',

                selectedStone:'',
                selectedWhome:'',
                selectedCutting:'',
                selectedSample:'',
                selectedMaterial:'',
                selectedBrand:'',

                searchInput:'',
                selectedFilter:'',

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
            async getData(){
                const response_catalog = await fetch('{{ route('get_catalog') }}')
                this.catalog = await response_catalog.json()

                const response_favs = await fetch('{{ route('getFavs') }}');
                let favs = await response_favs.json();
                favs.forEach(element => {
                    this.favorites.push(element.product_id)
                });

                const response_type = await fetch('{{ route('getTypes') }}');
                const response_brand = await fetch('{{ route('getBrands') }}');
                const response_cutting = await fetch('{{ route('getCuttings') }}');
                const response_material = await fetch('{{ route('getMaterials') }}');
                const response_sample = await fetch('{{ route('getSamples') }}');
                const response_stone = await fetch('{{ route('getStones') }}');
                const response_whome = await fetch('{{ route('getWhomes') }}');
                const response_filial = await fetch('{{ route('getFilials') }}');



                this.types = await response_type.json();
                this.stones = await response_stone.json();
                this.brands = await response_brand.json();
                this.cuttings = await response_cutting.json();
                this.materials = await response_material.json();
                this.samples = await response_sample.json();
                this.whoms = await response_whome.json();
                this.filials = await response_filial.json();

            },
            chooseType(){
                let subtype = this.types.find(item=>item.id == this.selectedType).subtypes
                // let size = this.types.find(item=>item.id == this.selectedType).sizes

                if(subtype && subtype.length>0){
                    this.subtypesForType = subtype
                }
                else{
                    this.subtypesForType = []
                }
                // if(size && size.length>0){
                //     this.sizesForType = size
                // }
                // else{
                //     this.sizesForType = []
                // }
                console.log(this.selectedType);
            },
            chooseSize(){
                let size = this.types.find(item=>item.id == this.selectedType).sizes
                // let size = this.types.find(item=>item.id == this.selectedType).sizes

                if(size && size.length>0){
                    this.sizesForType = size
                }
                else{
                    this.selectedSizeType = []
                }
                // if(size && size.length>0){
                //     this.sizesForType = size
                // }
                // else{
                //     this.sizesForType = []
                // }
                console.log(this.selectedSizeType);
            },
        },
        computed:{
            searchProduct(searchInput){
                if(this.searchInput){
                    return [...this.catalog].filter(product=> ((product.title).toLowerCase().includes((this.searchInput).toLowerCase()) ||
                    (product.type.title).toLowerCase().includes((this.searchInput).toLowerCase()) ||
                    (product.subtype && (product.subtype.title).toLowerCase().includes((this.searchInput).toLowerCase())) ||
                    (product.material.title).toLowerCase().includes((this.searchInput).toLowerCase()) ||

                    (product.stone.title).toLowerCase().includes((this.searchInput).toLowerCase()) ||
                    (product.cutting.title).toLowerCase().includes((this.searchInput).toLowerCase()) ||
                    (product.whome.title).toLowerCase().includes((this.searchInput).toLowerCase()) ||
                    (product.brand.title).toLowerCase().includes((this.searchInput).toLowerCase()))
                    )
                }
                else{
                    return this.catalog
                }
            },
            filterType(selectedType){
                // this.selectedSubType = []
                // this.selectedSizeType = []
                this.sizesForType = []
                this.subtypesForType = []
                if(this.selectedType){
                    console.log('if')
                    this.chooseType()
                    this.chooseSize()
                    return [...this.searchProduct].filter(prod => prod.type.id === this.selectedType)
                }
                else{
                    console.log('else')
                    return this.searchProduct
                }
            },
            filterSizetype(selectedSizeType){
                // console.log('filterSizetype')
                console.log(this.selectedSizeType)
                if(this.selectedSizeType.length>0){
                    console.log(this.filterType)
                    return [...this.filterType].filter(prod => prod.size.id === this.selectedSizeType)
                }
                else{
                    return this.filterType
                }
            },
            filterSubtype(selectedSubType){

                if(this.selectedSubType.length>0){

                    return [...this.filterSizetype].filter(prod => prod.subtype.id === this.selectedSubType)
                }
                else{
                    return this.filterSizetype
                }
            },
            filterMaterial(selectedMaterial){

                if(this.selectedMaterial){

                    return [...this.filterSubtype].filter(prod => prod.material.id === this.selectedMaterial)
                }
                else{
                    return this.filterSubtype
                }
            },
            filterCutting(selectedCutting){

                if(this.selectedCutting){

                    return [...this.filterMaterial].filter(prod => prod.cutting.id === this.selectedCutting)
                }
                else{
                    return this.filterMaterial
                }
            },
            filterStone(selectedStone){

                if(this.selectedStone){

                    return [...this.filterCutting].filter(prod => prod.stone.id === this.selectedStone)
                }
                else{
                    return this.filterCutting
                }
            },
            filterWhome(selectedWhome){

                if(this.selectedWhome){
                    console.log('in if')
                    return [...this.filterStone].filter(prod => prod.whome.id === this.selectedWhome)
                }
                else{
                    return this.filterStone
                }
            },
            filterBrand(selectedBrand){

                if(this.selectedBrand){

                    return [...this.filterWhome].filter(prod => prod.brand.id === this.selectedBrand)
                }
                else{
                    return this.filterWhome
                }
            },
            filterSample(selectedSample){

                if(this.selectedSample){

                    return [...this.filterBrand].filter(prod => prod.sample.id === this.selectedSample)
                }
                else{
                    return this.filterBrand
                }
            },



        },
        mounted(){
            this.getData()
            // console.log(1)
        }
    }
    Vue.createApp(app).mount('#Catalog')
</script>
{{-- <style>
.carousel-inner {
    height: 150px;
}
.carousel-item {
    height: 150px;
}
.carousel-item img {
    height: 150px;
    object-fit: cover;
}
</style> --}}
@endsection
