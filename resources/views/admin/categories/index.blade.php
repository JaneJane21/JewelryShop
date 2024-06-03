@extends('layout.app')
@section('title')
    Админка.Категории
@endsection
@section('content')
    <div class="container mt-5" id="characteristic">

        <div class="row align-items-center justify-content-between">
            <div class="col-7">
                <h1>Управление характеристиками</h1>
            </div>
            <div class="col-3">
                <button class="btn" data-bs-toggle="modal" data-bs-target="#characterModal"
                    style="border-color: rgb(28, 27, 102)">Добавить</button>
            </div>
        </div>
        <div class="row">
            <div :class="message ? 'alert alert-success' : ''">
                @{{ message }}
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="characterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Добавление новой характеристики</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" @submit.prevent="save" id="form_category">
                            <div :class="message ? 'alert alert-success' : ''">
                                @{{ message }}
                            </div>
                            <div class="row">
                                <h4>Основные данные</h4>
                                <div class="col-12 mt-3">
                                    <label for="select" class="label-control">Выберите характеристику*</label>
                                    <select v-model="select_choose" :change="check_select" class="form-control"
                                        name="select" id="select">
                                        <option value="0">Тип</option>
                                        <option value="1">Вставка</option>
                                        <option value="2">Огранка</option>
                                        <option value="3">Проба</option>
                                        <option value="4">Для кого</option>
                                        <option value="5">Материал</option>
                                        <option value="6">Бренд</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="title" class="label-control">Введите название*</label>
                                    <input :class="errors.title ? 'invalid-feedback' : ''" class="form-control" type="text"
                                        id="title" name="title">
                                    <div v-for="error in errors.title">
                                        @{{ error }}
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <h4>Дополнительные характеристики (при наличии)</h4>
                                <div class="row">
                                    <div class="col-6">
                                        <input class="form-check-input m-1" type="checkbox" id="subtype-checkbox"
                                            v-model="yes_subtypes" v-on:click="add_subtype">
                                        <label class="form-check-label" for="subtype-checkbox">Есть подтип</label>
                                    </div>
                                    <div class="col-6">
                                        <input class="form-check-input m-1" type="checkbox" id="size-checkbox"
                                            v-model="yes_sizes" v-on:click="add_sizes">
                                        <label class="form-check-label" for="size-checkbox">Есть размер</label>
                                    </div>
                                </div>
                                <div class="row option-columns mt-3">
                                    <div class="col-6">
                                        <div id="input_subtypes" class="d-none">
                                            <button type="button" v-on:click="add_subtype_input"
                                                class="btn btn-outline-primary">добавить подтип</button>
                                            <input v-for="subtype in subtypes_new" name="subtypes[]"
                                                class="form-control mt-2" type="text">

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div id="input_sizes" class="d-none">
                                            <button type="button" v-on:click="add_size_input"
                                                class="btn btn-outline-primary">добавить размер</button>
                                            <input v-for="subtype in sizes_new" name="sizes[]" class="form-control mt-2"
                                                type="text">


                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="row mt-3 justify-content-end">
                                <div class="col-3">
                                    <button type="submit" class="btn btn-outline-success">Сохранить</button>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <p style="color: grey">*обязательно для заполнения</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-around">


                <button id="type" type="button" @click="setCharacter('type')" class=" btn nav-btn" style="border-color: rgb(28, 27, 102);">Тип</button>


                <button id="stone" type="button" @click="setCharacter('stone')" class="btn nav-btn" style="border-color: rgb(28, 27, 102);">Вставка</button>



                <button id="cutting" type="button" @click="setCharacter('cutting')" class="btn nav-btn" style="border-color: rgb(28, 27, 102);">Огранка</button>


                <button id="sample" type="button" @click="setCharacter('sample')" class="btn nav-btn" style="border-color: rgb(28, 27, 102);">Проба</button>


                <button id="whome" type="button" @click="setCharacter('whome')" class="btn nav-btn" style="border-color: rgb(28, 27, 102);">Для кого</button>


                <button id="material" type="button" @click="setCharacter('material')" class="btn nav-btn" style="border-color: rgb(28, 27, 102);">Материал</button>


                <button id="brand" type="button" @click="setCharacter('brand')" class="btn nav-btn" style="border-color: rgb(28, 27, 102);">Бренд</button>
            </div>
        </div>

        <div class="row mt-5" v-if="data.length>0">
            <div class="col-8">
                <table class="table table-blue table-bordered">
                    <thead>
                        <tr>
                            <th style="background-color:rgb(28, 27, 102); color:white;" scope="col">#</th>
                            <th style="background-color:rgb(28, 27, 102); color:white;" scope="col">Название</th>
                            <th style="background-color:rgb(28, 27, 102); color:white;" scope="col">Есть связанные характеристики</th>
                            <th style="background-color:rgb(28, 27, 102); color:white;" scope="col">Действия</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="char in data">
                            <th scope="row">@{{ char.id }}</th>
                            <td>@{{ char.title }}</td>
                            <td v-if="(char.subtypes && char.subtypes.length>0) || (char.sizes && char.sizes.length>0)">
                                <a href="#" style="color: black" class="d-block" v-on:click="details_subtype(char)" v-if="char.subtypes.length !=0">подтип</a>
                                <a href="#" style="color: black" class="d-block" v-on:click="details_size(char)" v-if="char.sizes.length !=0">размер</a>
                            </td>
                            <td v-else>
                                <div class="row">
                                    <div class="col-6">
                                      <p>нет</p>
                                    </div>
                                    <div class="col-6">
                                      <button type="button" class="btn btn-outline-secondary" @click="show_adding(char)">добавить</button>
                                    </div>
                                </div>


                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-3 m-2">
                                        <form>
                                            <button class="btn btn-outline-primary">Подробнее</button>
                                        </form>
                                    </div>
                                    <div class="col-3 m-2">
                                        <button type="button" @click="rememberChar(char)" data-bs-toggle="modal" data-bs-target="#changeCharModal" class="btn btn-outline-primary">Изменить</button>
                                    </div>
                                    <div class="col-3 m-2">
                                        <a :href="`{{route('destroyGlobal')}}/${char.id}/${activeGlobalCat}`" type="submit" class="btn btn-outline-danger">Удалить</a>

                                    </div>
                                </div>
                                <div class="modal fade" id="changeCharModal" tabindex="-1" aria-labelledby="changeCharModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h1 class="modal-title fs-5" id="changeCharModalLabel">Изменение параметра</h1>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          <form @submit.prevent="changeGlobalCat" class="row" :id="`form_change_global_${changingChar.id}`">

                                            <div class="col-6">
                                                <input class="form-control" :class="errors.title?'invalid-feedback':''" :value="changingChar.title" type="text" name="title">
                                                <div v-for="error in errors.title">
                                                    @{{ error }}
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-outline-success" type="submit">Сохранить изменения</button>
                                            </div>
                                          </form>
                                        </div>

                                      </div>
                                    </div>
                                  </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-4 ">
                <div class="d-none" id="detail">
                    <div class="card" >

                        <div class="card-header" style="background-color:rgb(28, 27, 102); color:white;">
                            <div class="row mb-3 align-items-center justify-content-between">
                                <div v-if="detailHeader.length>0" class="col-6">
                                    @{{ this.detailHeader }}
                                </div>
                                <div v-else class="col-6">
                                   Создание характеристики
                                </div>
                                <div class="col-2">
                                    <button @click="close_details" style="color: white" type="button" class="btn">X</button>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center justify-content-between">

                                <div class="col-12">
                                    <form class="row align-items-end" id="add_subchar_form" @submit.prevent="add_subchar">
                                        <div class="col-12">
                                            <label for="parametr" class="label-control">Выберите вид подкатегории</label>
                                        </div>
                                        <div class="col-7">
                                            <select class="form-control" name="parametr" id="select_for_add">

                                            <option value="Подтипы">Подтип</option>
                                            <option value="Размеры">Размер</option>
                                        </select>
                                        </div>

                                        <div class="col-12">
                                            <label for="title" class="label-control">Введите название нового пункта</label>
                                        </div>
                                        <div class="col-7">

                                            <input type="text" name="title" class="form-control" id="title">
                                        </div>
                                        <div class="col-5">
                                            <button type="submit" class="btn btn-light">Добавить</button>
                                        </div>


                                    </form>
                                </div>
                            </div>

                          </div>

                        <ul v-for="elem in detailsBlock" class="list-group list-group-flush">

                                <div class="row align-items-center justify-content-between">
                                    <div class="col-9">
                                    <form @submit.prevent="edit_subchar(elem.id)" class="row align-items-center justify-content-between" :id="`edit-subchar-form_${elem.id}`">
                                <div class="col-8">
                                    <li v-if="elem.title" class="list-group-item"><input :class="errors.title?'invalid-feedback':''" type="text" style="border: none" name="title" class="form-control" :value="elem.title">
                                        <div v-for="error in errors.title">
                                            @{{ error }}
                                        </div>
                                    </li>
                                    <li v-if="elem.number" class="list-group-item"><input :class="errors.number ?'invalid-feedback':''" type="text" style="border: none" name="number" class="form-control" :value="elem.number">
                                        <div v-for="error in errors.number">
                                            @{{ error }}
                                        </div>
                                    </li>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-outline-primary">Изменить</button>
                                </div>
                                </form>
                                    </div>

                                <div class="col-3">
                                <form @submit.prevent="delete_subchar(elem.id)" id="delete-subchar-form">
                                    <button type="submit"  class="btn btn-outline-danger">Удалить</button>

                                </form>
                            </div>
                            </div>




                        </ul>
                      </div>
                </div>
            </div>
        </div>
        <div class="row mt-5" v-else>
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <script>
        const app = {
            data() {
                return {
                    errors: [],
                    message: '',


                    select_choose: 0,
                    yes_subtypes: false,
                    yes_sizes: 0,
                    subtypes_new: [],
                    sizes_new: [],

                    types:[],
                    stones:[],
                    whoms:[],
                    cuttings:[],
                    samples:[],
                    materials:[],
                    brands:[],

                    activeGlobalCat:'type',
                    data:[],
                    detailsBlock:[],
                    detailHeader:'',
                    activeDetail:'',

                    changingChar:'',
                }
            },
            methods: {
                add_subtype_input() {
                    this.subtypes_new.push('')
                },
                add_size_input() {
                    this.sizes_new.push('')
                },
                rememberChar(elem){
                    console.log(elem)
                    this.changingChar = elem
                },

                details_subtype(char){

                   let block = document.getElementById('detail')
                    block.classList.remove('d-none')
                    this.detailsBlock = char.subtypes
                    this.detailHeader = 'Подтипы'
                    this.activeDetail = char
                    return this.detailsBlock
                },
                show_adding(char){
                    document.getElementById('detail').classList.remove('d-none')
                    // this.detailHeader = 'Добавление подхарактеристики к ' + char.title
                    this.detailHeader = ''
                    this.activeDetail = char
                    this.detailsBlock = char.subtypes
                    return this.detailsBlock
                },
                // destroy_global_cat(id){
                //     console.log(this.activeGlobalCat)
                //     console.log(id)
                // },

                async changeGlobalCat(){
                    let route = ''
                    let form = document.getElementById('form_change_global_'+this.changingChar.id);
                    let form_data = new FormData(form)
                    form_data.append('type',this.activeGlobalCat)
                    form_data.append('id',this.changingChar.id)
                    // route = 'editGlobal/'+this.changingChar.id+this.activeGlobalCat
                    const response = await fetch('{{ route('editGlobal') }}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{ csrf_token() }}'
                        },
                        body:form_data
                    })
                    if (response.status === 404) {
                        this.errors = await response.json()
                    }
                    if (response.status === 200) {
                        this.message = await response.json()
                        setTimeout(() => {
                            this.message = ''
                        }, 2000);
                        form.reset()
                        this.getCategories()
                    }
                },

                details_size(char){

                   let block = document.getElementById('detail')
                    block.classList.remove('d-none')
                    this.detailsBlock = char.sizes
                    this.detailHeader = 'Размеры'
                    this.activeDetail = char
                    return this.detailsBlock
                },

                close_details(){
                    let block = document.getElementById('detail')
                    block.classList.add('d-none')
                },

                async add_subchar(char){
                    let select = document.getElementById('select_for_add');
                    let form = document.getElementById('add_subchar_form')
                    let form_data = new FormData(form)
                    form_data.append('id',this.activeDetail.id)
                    let route = ''
                    if(select.value=='Размеры'){
                        route = '{{route('store_size')}}'
                    }
                    else if(select.value=='Подтипы'){
                        route = '{{route('store_subtype')}}'
                    }

                    const response = await fetch(route,{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body: form_data

                    })
                    if (response.status === 404) {
                        this.errors = await response.json()
                    }
                    if (response.status === 200) {
                        let res = await response.json()
                        this.message = res[0]
                        setTimeout(() => {
                            this.message = ''
                        }, 2000);
                        form.reset()
                        this.getCategories()
                        // console.log(this.activeDetail)
                        this.detailsBlock = res[1];
                        if(select.value == 'Размеры'){
                            this.detailHeader='Размеры'
                        }
                        else if(select.value == 'Подтипы'){
                            this.detailHeader='Подтипы'
                        }
                        // if(this.detailHeader=='Подтипы'){
                        //     this.detailsBlock = res[1];
                        //     // console.log(this.detailsBlock)
                        // }
                        // else if(this.detailHeader=='Размеры'){
                        //     this.detailsBlock = res[1]
                        // }

                    }
                },

                async edit_subchar(id){

                    let form = document.getElementById('edit-subchar-form_'+id);
                    let form_data = new FormData(form)

                    form_data.append('id',id)
                    console.log(form_data)
                    let route = ''
                    if(this.detailHeader=='Размеры'){
                        route = '{{route('update_size')}}'
                    }
                    else if(this.detailHeader=='Подтипы'){
                        route = '{{route('update_subtype')}}'
                    }

                    const response = await fetch(route,{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body: form_data

                    })

                    if (response.status === 400) {
                        this.message = await response.json()
                    }
                    // if (response.status === 404) {
                    //     this.errors = await response.json()
                    // }
                    if (response.status === 200) {
                        let res = await response.json()
                        this.message = res[0]
                        setTimeout(() => {
                            this.message = ''
                        }, 2000);
                        form.reset()
                        this.getCategories()
                        // console.log(this.activeDetail)

                        if(this.detailHeader=='Подтипы'){
                            console.log(this.activeDetail.subtypes)
                            this.detailsBlock = res[1];
                            // console.log(this.detailsBlock)
                        }
                        else if(this.detailHeader=='Размеры'){
                            this.detailsBlock = res[1]
                        }

                    }
                },

                async delete_subchar(id){

                    let route=''
                    let form = document.getElementById('delete-subchar-form');
                    let form_data = new FormData(form)
                    form_data.append('id',id)
                    if(this.detailHeader=='Размеры'){
                        route = '{{route('delete_size')}}'
                    }
                    else if(this.detailHeader=='Подтипы'){
                        route = '{{route('delete_subtype')}}'
                    }

                    const response = await fetch(route,{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body: form_data
                    })

                    if (response.status === 200){
                        let res = await response.json()
                        this.message = res[0]
                        setTimeout(() => {
                            this.message = ''
                        }, 2000);
                        this.getCategories()

                        if(this.detailHeader=='Подтипы'){
                            console.log(this.activeDetail.subtypes)
                            this.detailsBlock = res[1];

                        }
                        else if(this.detailHeader=='Размеры'){
                            this.detailsBlock = res[1]
                        }
                    }
                },

                setCharacter(preset){
                    let block = document.getElementById('detail')
                    block.classList.add('d-none')

                    let all_btn = document.querySelectorAll('.nav-btn')
                    all_btn.forEach(element => {
                        element.classList.remove('select-btn')
                    });
                    // for(btn in all_btn){

                    //     btn.classList.remove('select-btn')
                    // }
                    let active_btn = document.getElementById(preset)
                    active_btn.classList.add('select-btn')

                    switch(preset){
                        case 'type':
                            this.data = this.types;
                            this.activeGlobalCat = 'type'
                            return this.data;
                        case 'stone':
                            this.data = this.stones;
                            this.activeGlobalCat = 'stone'
                            return this.data;
                        case 'cutting':
                            this.data = this.cuttings;
                            this.activeGlobalCat = 'cutting'
                            return this.data;
                        case 'brand':
                            this.data = this.brands;
                            this.activeGlobalCat = 'brand'
                            return this.data;
                        case 'whome':
                            this.data = this.whoms;
                            this.activeGlobalCat = 'whome'
                            return this.data;
                        case 'material':
                            this.data = this.materials;
                            this.activeGlobalCat = 'material'
                            return this.data;
                        case 'sample':
                            this.data = this.samples;
                            this.activeGlobalCat = 'sample'
                            return this.data;
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

                    this.types = await response_type.json();
                    this.stones = await response_stone.json();
                    this.brands = await response_brand.json();
                    this.cuttings = await response_cutting.json();
                    this.materials = await response_material.json();
                    this.samples = await response_sample.json();
                    this.whoms = await response_whome.json();


                    this.data = this.types;
                    // console.log('this data')
                    // console.log(this.data)
                    // console.log(this.types)
                },

                add_subtype() {
                    this.yes_subtypes = !this.yes_subtypes
                    if (this.yes_subtypes) {
                        let inp = document.getElementById('input_subtypes')
                        inp.classList.remove('d-none')
                        this.subtypes_new.push('')
                    }
                    else {
                        let inp = document.getElementById('input_subtypes')
                        inp.classList.add('d-none')
                        this.subtypes_new = []


                    }
                },

                add_sizes() {
                    this.yes_sizes = !this.yes_sizes
                    if (this.yes_sizes) {
                        let inp = document.getElementById('input_sizes')
                        inp.classList.remove('d-none')
                        this.sizes_new.push('')
                    }
                    else {
                        let inp = document.getElementById('input_sizes')
                        inp.classList.add('d-none')
                        this.sizes_new = []


                    }
                },


                async save() {
                    let form = document.getElementById('form_category')
                    let form_data = new FormData(form)
                    const response = await fetch(this.check_select, {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: form_data
                    })
                    if (response.status === 400) {
                        this.errors = await response.json()
                    }
                    if (response.status === 200) {
                        this.message = await response.json()
                        form.reset()
                        this.subtypes_new = []
                        this.sizes_new = []
                        this.getCategories()
                    }
                }

            },
            computed: {
                check_select() {
                    switch (parseInt(this.select_choose)) {
                        case 0:
                            return '{{ route('TypeSave') }}'
                        case 1:
                            return '{{ route('StoneSave') }}'
                        case 2:
                            return '{{ route('CuttingSave') }}'
                        case 3:
                            return '{{ route('SampleSave') }}'
                        case 4:
                            return '{{ route('WhomSave') }}'
                        case 5:
                            return '{{ route('MaterialSave') }}'
                        case 6:
                            return '{{ route('BrandSave') }}'
                    }
                },



            },
            mounted(){
                this.getCategories();
            }
        }
        Vue.createApp(app).mount('#characteristic')
    </script>
    <style>
        .select-btn{
            background-color:rgb(28, 27, 102);
            color:white;
        }
    </style>
@endsection
