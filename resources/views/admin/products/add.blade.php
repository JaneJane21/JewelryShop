@extends('layout.app')
@section('title')
Админка.Добавление товара
@endsection
@section('content')
<div class="container" id="add_product">
    <div class="row mt-5 justify-content-between">
        <div class="col-6">
            <h1>Создание товара</h1>
        </div>
    </div>
    <div class="row mt-5">
        <form method="post" class="row g-3" enctype="multipart/form-data" @submit.prevent="send_product" id="product_data">
            <div class="col-md-6">
              <label for="title" class="form-label">Название товара</label>
              <input type="text" class="form-control" id="title" name="title">
              <div v-for="error in errors.title">
                @{{ error }}
            </div>
            </div>
            <div class="col-md-1">
              <label for="price" class="form-label">Цена товара</label>
              <input type="text" class="form-control" id="price" name="price">
              <div v-for="error in errors.price">
                @{{ error }}
            </div>
            </div>
            <div class="col-12">
              <label for="description" class="form-label">Описание товара</label>
              <textarea type="text" class="form-control" id="description" name="description"></textarea>
              <div v-for="error in errors.description">
                @{{ error }}
            </div>
            </div>
            <div class="col-md-4">
              <label for="type_id" class="form-label">Категория</label>
              <select @change="chooseType" v-model="selectedType" id="type_id" class="form-select" name="type_id">
                <option v-for="type in types" :value="type.id">@{{type.title}}</option>
              </select>
              <div v-for="error in errors.type_id">
                @{{ error }}
            </div>
            </div>
            <div v-if="subtypesForType.length>0" class="col-md-4">
                <label for="subtype_id" class="form-label">Подкатегория</label>
                <select id="subtype_id" v-model="selectedSubType" class="form-select" name="subtype_id">
                    <option v-for="subtype in subtypesForType" :value="subtype.id">@{{subtype.title}}</option>
                </select>
                <div v-for="error in errors.subtype_id">
                    @{{ error }}
                </div>
            </div>
            <div v-if="sizesForType.length>0" class="col-md-4">
                <label for="sizes[]" class="form-label">Размерный ряд</label>

                    <div class="col-4" v-for="size in sizesForType" class="mr-1">
                        <input  type="checkbox" name="sizes[]" v-model="selectedSizes" :id="`size_${size.id}`" :value="size">
                        <label :for="`size_${size.id}`">@{{size.number}}</label>
                    </div>


                {{-- <select @change="chooseSizes" multiple id="sizes[]" v-model="selectedSizes" class="form-select" name="sizes[]">
                    <option v-for="size in sizesForType" :value="size.id">@{{size.number}}</option>
                </select> --}}
            </div>
            <div class="col-md-4">
                <label for="material_id" class="form-label">Материал</label>
                <select v-model="selectedMaterial" id="material_id" class="form-select" name="material_id">
                    <option v-for="material in materials" :value="material.id">@{{material.title}}</option>
                </select>
                <div v-for="error in errors.material_id">
                    @{{ error }}
                </div>
            </div>
            <div class="col-md-4">
                <label for="cutting_id" class="form-label">Огранка</label>
                <select v-model="selectedCutting" id="cutting_id" class="form-select" name="cutting_id">
                    <option v-for="cutting in cuttings" :value="cutting.id">@{{cutting.title}}</option>
                </select>
                <div v-for="error in errors.cutting_id">
                    @{{ error }}
                </div>
            </div>
            <div class="col-md-4">
                <label for="stone_id" class="form-label">Вставка</label>
                <select v-model="selectedStone" id="stone_id" class="form-select" name="stone_id">
                    <option v-for="stone in stones" :value="stone.id">@{{stone.title}}</option>
                </select>
                <div v-for="error in errors.stone_id">
                    @{{ error }}
                </div>
            </div>
            <div class="col-md-4">
                <label for="whome_id" class="form-label">Для кого</label>
                <select v-model="selectedWhome" id="whome_id" class="form-select" name="whome_id">
                    <option v-for="whom in whoms" :value="whom.id">@{{whom.title}}</option>
                </select>
                <div v-for="error in errors.whome_id">
                    @{{ error }}
                </div>
            </div>
            <div class="col-md-4">
                <label for="brand_id" class="form-label">Бренд</label>
                <select v-model="selectedBrand" id="brand_id" class="form-select" name="brand_id">
                    <option v-for="brand in brands" :value="brand.id">@{{brand.title}}</option>
                </select>
                <div v-for="error in errors.brand_id">
                    @{{ error }}
                </div>
            </div>
            <div class="col-md-4">
                <label for="sample_id" class="form-label">Проба</label>
                <select v-model="selectedSample" id="sample_id" class="form-select" name="sample_id">
                    <option v-for="sample in samples" :value="sample.id">@{{sample.title}}</option>
                </select>
                <div v-for="error in errors.sample_id">
                    @{{ error }}
                </div>
            </div>
            <div class="mb-3">
                <label for="images[]" class="form-label">Добавьте изображения</label>
                <input @change="show_images"  multiple class="form-control" type="file" id="images[]" name="images[]">
              </div>
            <div class="col-md-4">
                <label for="filial_id" class="form-label">Наличие в филиалах</label>
                <form id="filial_form">

                    <div v-for="filial in filials" class="filial-box row mb-3" id="`filial_${filial.id}`">

                        <div class="col-6">
                            <input  v-model="selectedFilials" name="filials[]" type="checkbox" class="form-check-input" :id="`filial_check_${filial.id}`" :value="filial">
                            <label :for="`filial_check_${filial.id}`" class="form-check-label">@{{filial.title}}</label>
                        </div>
                        <div v-if="selectedSizes.length>0" class="col-6">
                           <div v-for="size in selectedSizes" class="sizes-box row">
                            <div class="col-4">
                                <input  type="checkbox" :class="`form-check-input size_for_filial_${filial.id}`" :id="`size_check_${filial.id}_${size.id}`" :value="size.id">
                                <label :for="`size_check_${size.id}`" class="form-check-label">@{{size.number}}</label>
                            </div>
                            <div class="col-4">
                                <input  :id="`count_for_size_${size.id}_${filial.id}`" type="text" name="count" :class="`form-control count_for_filial_${filial.id}`">
                            </div>
                        </div>
                        </div>
                        <div class="col-6" v-else>
                            <input  :id="`count_for_${filial.id}`" type="text" name="count" :class="`form-control only_count_for_${filial.id}`">
                        </div>

                    </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
                </form>
            </div>




          </form>
    </div>
</div>
<script>
    const app = {
        data(){
            return{
                errors: [],
                message: '',

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
                selectedSizes:[],
                selectedFilials:[],
                PFS:[],

                selectedStone:'',
                selectedWhome:'',
                selectedCutting:'',
                selectedSample:'',
                selectedMaterial:'',
                selectedBrand:'',

                loadedImages:[],


            }
        },
        methods:{
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
                // console.log(this.selectedType)
                // console.log(this.types[this.selectedType])
                if(this.selectedFilials.length>0){
                    this.selectedFilials = []
                // let form = document.querySelector('#filial_form')
                // console.log(form)
                // form.reset()
                }

                let subtype = this.types.find(item=>item.id == this.selectedType).subtypes
                let size = this.types.find(item=>item.id == this.selectedType).sizes
                // console.log('subtype')
                // console.log(subtype)
                if(subtype && subtype.length>0){
                    this.subtypesForType = subtype
                }
                else{
                    this.subtypesForType = []
                }
                if(size && size.length>0){
                    this.sizesForType = size
                }
                else{
                    this.sizesForType = []
                }
                console.log(this.selectedType);
            },
            chooseSizes(){
                console.log(this.selectedSizes)
            },

            show_images(){
                console.log(document.getElementById('images[]'))
                // this.loadedImages = document.getElementById('images[]')
                // console.log(this.loadedImages)
            },
            async send_product(){
                this.show_filials()
                let form = document.getElementById('product_data')
                let form_data = new FormData(form)
                form_data.append('selected_filials',JSON.stringify(this.PFS))
                const response = await fetch('{{ route('storeProduct') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    body:form_data
                })

                if(response.status == 200){
                    
                    window.location = response.url
                }
                if(response.status==400){
                    this.errors = await response.json()
                }

            },



            show_filials(){
                console.log(this.selectedFilials)
                let PFS = []
                for(elem of this.selectedFilials){
                    let filial_product = {}
                    filial_product.filial_id = elem.id

                    filial_product.counts = []
                    let sizes = []
                    let counts = []
                    sizes =  document.querySelectorAll('.size_for_filial_'+elem.id)
                    console.log(sizes.length)
                    if(sizes.length>0){
                        filial_product.sizes = []
                        for(s of sizes){
                            if(s.checked){
                                console.log('size id ' + s.value)
                                let count = document.getElementById('count_for_size_'+s.value+'_'+elem.id)
                                    if(count.value){
                                        console.log('count '+count)
                                        filial_product.sizes.push(s.value)
                                        filial_product.counts.push(count.value)
                                    }
                            }

                        }

                    console.log('filial_product '+filial_product)
                    if(filial_product.sizes.length>0){
                        PFS.push(filial_product)
                    }

                }
                else{
                    console.log('only count')
                    let counts = document.querySelectorAll('.only_count_for_'+elem.id)
                    console.log('counts '+counts)

                    if(counts.length>0){
                       for(let c of counts){
                        console.log(c.value)
                        if(c.value){
                            filial_product.counts.push(c.value)
                        }

                    }
                    if(filial_product.counts.length>0){
                        PFS.push(filial_product)
                    }
                    }

                }
                this.PFS = PFS
                // let sizes = document.querySelectorAll('.size_for_filial')
                // console.log(sizes)
                // for(size of sizes){
                //     if(size.checked)
                //     console.log(size.value)
                //     console.log(size.id)
                // }
                }
            },

            rememberSize(filial,size){
                console.log('size')
                console.log(size)
                let cur_filial = this.selectedFilials.find(item=>item.id == filial.id)
                if(!cur_filial.sizes){
                    cur_filial.sizes = []

                }
                if(size){
                    cur_filial.sizes.push(size)
                }

                console.log('cur_filial')
                console.log(cur_filial)

            },
            rememberCount(filial,size){
                console.log('count')
                let count_value = document.getElementById('count_for_size_'+filial.id+'_'+size).value
                let cur_filial = this.selectedFilials.find(item=>item.id == filial.id)
                if(!cur_filial.counts){
                    cur_filial.counts = []

                }
                if(count_value){
                    cur_filial.counts.push(count_value)
                }
                console.log('cur_filial')
                console.log(cur_filial)

            },
            rememberOnlyCount(filial){
                let count_value = document.getElementById('count_for_size_'+filial.id).value
                let cur_filial = this.selectedFilials.find(item=>item.id == filial.id)
                if(!cur_filial.counts){
                    cur_filial.counts = []

                }
                if(count_value){
                    cur_filial.counts.push(count_value)
                }
                console.log('cur_filial')
                console.log(cur_filial)

            }

        },
        mounted(){
            this.getCategories();
        }
    }
    Vue.createApp(app).mount('#add_product')
</script>
@endsection
