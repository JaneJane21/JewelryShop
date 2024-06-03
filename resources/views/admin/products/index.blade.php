@extends('layout.app')
@section('title')
    Админка.Товары
@endsection
@section('content')
    <div class="container" id="products">
        <div class="row mt-5 justify-content-between align-items-center">
            <div class="col-6">
                <h1>Все товары</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('show_products_add') }}" class="btn btn-dark">Добавить товар</a>
            </div>
        </div>
        <div v-if="products.length>0">
        <div class="row mt-5 justify-content-between align-items-center">
            <input @input="searchProduct" v-model="searchInput" class="form-control" placeholder="Я ищу...">
        </div>
        <div class="row mt-5 justify-content-between align-items-center">
            <div class="col-md-4">
                <label for="type_id" class="form-label">Категория</label>
                <select @change="filterType" v-model="selectedType" id="type_id" class="form-select" name="type_id">
                    <option value="">Выбрать категорию</option>
                  <option v-for="type in types" :value="type.id">@{{type.title}}</option>
                </select>

              </div>
              <div v-if="subtypesForType.length>0" class="col-md-4">
                <label for="subtype_id" class="form-label">Подкатегория</label>
                <select  @change="filterSubtype" id="subtype_id" v-model="selectedSubType" class="form-select" name="subtype_id">
                    <option value="">Выбрать подтип</option>
                    <option v-for="subtype in subtypesForType" :value="subtype.id">@{{subtype.title}}</option>
                </select>

            </div>
            {{-- <div v-if="sizesForType.length>0" class="col-md-4">
                <label for="sizes[]" class="form-label">Размерный ряд</label>

                    <div class="col-4" v-for="size in sizesForType" class="mr-1">
                        <input type="checkbox" name="sizes[]" :id="`size_${size.id}`" :value="size">
                        <label :for="`size_${size.id}`">@{{size.number}}</label>
                    </div>
            </div> --}}
            <div class="col-md-4">
                <label for="material_id" class="form-label">Материал</label>
                <select  @change="filterMaterial" v-model="selectedMaterial" id="material_id" class="form-select" name="material_id">
                    <option value="">Выбрать материал</option>
                    <option v-for="material in materials" :value="material.id">@{{material.title}}</option>
                </select>

            </div>
            <div class="col-md-4">
                <label for="cutting_id" class="form-label">Огранка</label>
                <select  @change="filterCutting" v-model="selectedCutting" id="cutting_id" class="form-select" name="cutting_id">
                    <option value="">Выбрать огранку</option>
                    <option v-for="cutting in cuttings" :value="cutting.id">@{{cutting.title}}</option>
                </select>

            </div>
            <div class="col-md-4">
                <label for="stone_id" class="form-label">Вставка</label>
                <select  @change="filterStone" v-model="selectedStone" id="stone_id" class="form-select" name="stone_id">
                    <option value="">Выбрать вставку</option>
                    <option v-for="stone in stones" :value="stone.id">@{{stone.title}}</option>
                </select>

            </div>
            <div class="col-md-4">
                <label for="whome_id" class="form-label">Для кого</label>

                <select  @change="filterWhome" v-model="selectedWhome" id="whome_id" class="form-select" name="whome_id">
                    <option value="">Выбрать для кого</option>
                    <option v-for="whom in whoms" :value="whom.id">@{{whom.title}}</option>
                </select>

            </div>
            <div class="col-md-4">
                <label for="brand_id" class="form-label">Бренд</label>
                <select  @change="filterBrand" v-model="selectedBrand" id="brand_id" class="form-select" name="brand_id">
                    <option value="">Выбрать бренд</option>
                    <option v-for="brand in brands" :value="brand.id">@{{brand.title}}</option>
                </select>

            </div>
            <div class="col-md-4">
                <label for="sample_id" class="form-label">Проба</label>
                <select  @change="filterSample" v-model="selectedSample" id="sample_id" class="form-select" name="sample_id">
                    <option value="">Выбрать пробу</option>
                    <option v-for="sample in samples" :value="sample.id">@{{sample.title}}</option>
                </select>

            </div>
        </div>
        <div class="row mt-5 justify-content-between align-items-center">
            <div class="col-6">
                <h1>Все товары</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('show_products_add') }}" class="btn btn-dark">Добавить товар</a>
            </div>
        </div>
        <div class="row mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Изображение</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Характеристики</th>
                        <th scope="col">Наличие</th>
                        <th scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in filterSample">
                        <th scope="row">@{{ product.id }}</th>
                        <td style="width: 200px;">@{{ product.title }}</td>
                        <td style="width:150px;">
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
                            <div class="" v-else>нет изображений</div>
                        </td>
                        <td>@{{ product.price }}</td>
                        <td>
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Категория: </strong>@{{ product.type.title }}</li>
                                <li v-if="product.subtype" class="list-group-item"><strong>Подкатегория:
                                    </strong>@{{ product.subtype.title }}</li>
                                <li class="list-group-item"><strong>Материал: </strong>@{{ product.material.title }}</li>
                                <li class="list-group-item"><strong>Проба: </strong>@{{ product.sample.title }}</li>
                                <li class="list-group-item"><strong>Вставка: </strong>@{{ product.stone.title }}</li>
                                <li class="list-group-item"><strong>Огранка: </strong>@{{ product.cutting.title }}</li>
                                <li class="list-group-item"><strong>Для кого: </strong>@{{ product.whome.title }}</li>
                                <li class="list-group-item"><strong>Бренд: </strong>@{{ product.brand.title }}</li>

                            </ul>
                        </td>
                        <td>
                            <ul v-for="stock in product.stocks" class="list-group mb-2">
                                <li class="list-group-item">
                                    <p>@{{ stock.filial_title }}</p>
                                    <div v-for="(elem,index) in stock.counts" class="row">
                                <div v-if="stock.sizes.length>0" class="col-6">
                                    Размер: @{{ stock.sizes[index] }}
                                </div>
                                <div class="col-6">
                                    В наличии: @{{ elem }}
                                </div>
                                    </div>
                                </li>
                            </ul>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <a style="width: 100%" :href="`{{ route('show_products_edit')}}/${product.id}`" class="btn btn-outline-primary">Редактировать</a>
                                </div>
                                <div class="col-12 mb-2">
                                    <a style="width: 100%" :href="`{{ route('destroyProduct')}}/${product.id}`" class="btn btn-outline-danger">Удалить</a>
                                </div>
                            </div>


                        </td>

                    </tr>

                </tbody>
            </table>
        </div>
    </div>
        <div class="row mt-5" v-else>
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        const app = {
                data() {
                    return {
                        products: [],
                        productFilial: [],

                        types:[],
                        stones:[],
                        whoms:[],
                        cuttings:[],
                        samples:[],
                        materials:[],
                        brands:[],
                        filials:[],

                        subtypesForType:[],
                        sizesForType:[],

                        selectedType:'',
                        selectedSubType:'',

                        selectedStone:'',
                        selectedWhome:'',
                        selectedCutting:'',
                        selectedSample:'',
                        selectedMaterial:'',
                        selectedBrand:'',

                        searchInput:'',
                        selectedFilter:''
                    }
                },
                methods: {
                    async getData() {
                        const response = await fetch('{{ route('getProducts') }}')
                        const response_filial = await fetch('{{ route('getProductFilial') }}')

                        this.products = await response.json()
                        this.productFilial = await response_filial.json()

                        for (let elem of this.products) {

                            // photos = elem.images.split(';')
                            // photos.pop()
                            // elem.images = photos
                            elem.filials = []
                            elem.filials = this.productFilial.filter(filial => filial.product_id === elem.id)
                        }
                        console.log(this.products)
                        for (let elem of this.products) {
                           elem.stocks = []
                            for (let filial of elem.filials) {
                                let stock = elem.stocks.filter(f => f.filial_title === filial.filial.title)

                                if(stock.length==0){
                                    let stock = {
                                        filial_title: filial.filial.title,
                                        counts: [],
                                        sizes: [],
                                    }

                                    stock.counts.push(filial.count)
                                    if (filial.size) {
                                    stock.sizes.push(filial.size.number)
                                    }
                                    elem.stocks.push(stock)
                                    stock = {}
                                }
                                else{

                                    stock[0].counts.push(filial.count)
                                    if (filial.size) {
                                    stock[0].sizes.push(filial.size.number)
                                    }

                                    stock = {}
                                }
                            }
                            // else{
                            //     let s = elem.stocks.filter(f => f)
                            // }
                        }

                    },
                    async getCategories(){
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
                    delete(product){
                        console.log('product')
                    },




                    // console.log(this.productFilial);
                },
                computed:{
                    searchProduct(searchInput){
                        if(this.searchInput){
                            return [...this.products].filter(product=> ((product.title).toLowerCase().includes((this.searchInput).toLowerCase()) ||
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
                            return this.products
                        }
                    },
                    filterType(selectedType){

                        if(this.selectedType){
                            this.chooseType()
                            return [...this.searchProduct].filter(prod => prod.type.id === this.selectedType)
                        }
                        else{
                            return this.searchProduct
                        }
                    },
                    filterSubtype(selectedSubType){

                        if(this.selectedSubType){

                            return [...this.filterType].filter(prod => prod.subtype.id === this.selectedSubType)
                        }
                        else{
                            return this.filterType
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


            mounted() {
                this.getData()
                this.getCategories()
            }
        }
        Vue.createApp(app).mount('#products')
    </script>
@endsection
