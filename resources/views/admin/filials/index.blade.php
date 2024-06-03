@extends('layout.app')
@section('title')
Филиалы
@endsection
@section('content')
<div class="container" id="filials-container">
    <div class="row mt-5">
        <div class="col-7">
            <h1>Филиалы </h1>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#addFilialModal" style="border-color: rgb(28, 27, 102); width:100%; color:black">+ Добавить филиал</button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addFilialModal" tabindex="-1" aria-labelledby="addFilialModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="addFilialModalLabel">Добавление нового филиала</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form class="row" @submit.prevent="addFilial" id="form-store-filial">
                    <div class="col-7">
                        <div class="mb-3">
                        <label class="label-control" for="title">Введите название филиала</label>
                        <input :class="errors.title?'invalid-feedback':''" class="form-control" type="text" name="title" id="title">
                        <div class="" v-for="error in errors.title">
                            @{{ error }}
                        </div>
                    </div>
                    </div>

                    <div class="mb-3">
                        <label class="label-control" for="address">Введите адрес филиала</label>
                    <input class="form-control" type="text" name="address" id="address" :class="errors.address?'invalid-feedback':''">
                    <div class="" v-for="error in errors.address">
                        @{{ error }}
                    </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-outline-success">Сохранить</button>
                    </div>

                </form>
                </div>

            </div>
            </div>
        </div>
    </div>
    <div v-if="filials.length>0" class="row mt-3">
        <div class="col-6">
            <ul  v-for="filial in filials" class="list-group">

            <li class="list-group-item mb-3">
                <form @submit.prevent="editFilial(filial.id)" :id="`change_filial_${filial.id}`">
                    <input type="text" class="form-control mb-2" name="title" :value="filial.title" style="border: none">
                    <input type="text" class="form-control mb-2" name="address" :value="filial.address" style="border: none">
                    <div class="row">
                        <div class="col-2">
                            <button type="submit" class="btn btn-outline-primary">Изменить</button>
                        </div>
                        <div class="col-2">
                            <a :href="`{{ route('destroyFilial') }}/${filial.id}`" class="btn btn-outline-danger">Удалить</a>
                        </div>
                    </div>
                </form>
            </li>
            </ul>
        </div>

                {{-- <form @submit.prevent="editFilial(filial.id)" :id="`change_filial_${filial.id}`">
                <th scope="row">@{{ filial.id }}</th>
                <td><input type="text" class="form-control" name="title" :value="filial.title" style="border: none"></td>
                <td><input type="text" class="form-control" name="address" :value="filial.address" style="border: none"></td>
                <td>
                    <div class="row">
                        <div class="col-6">
                            <button @click="editFilial(filial.id)" type="submit" class="btn btn-outline-primary">Изменить</button>

                        </div>
                        <div class="col-6"></div>
                    </div>
                </td>
                </form> --}}
           </div>
        <div class="" v-else>
            <div class="col-6">
                Список филиалов пуст
            </div>
        </div>

</div>
<script>
const app = {
    data(){
        return {
            filials:[],

            errors:[],
            message:'',
        }
    },
    methods:{
        async getFilials(){
            const response_filial = await fetch('{{ route('getFilials') }}');
            this.filials = await response_filial.json()
        },

        async addFilial(){
            let form = document.getElementById('form-store-filial');
            let form_data = new FormData(form);

            const response = await fetch('{{ route('storeFilial') }}',{
                method: 'post',
                headers:{
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                },
                body:form_data
            });

            if(response.status === 404){
                this.errors = await response().json()
            }

            if(response.status === 200){
                this.message = response.json();
                form.reset()
                this.getFilials();
            }
        },

        async editFilial(id){
            let form = document.getElementById('change_filial_'+id)
            let form_data = new FormData(form)
            form_data.append('id',id)

            const response = await fetch('{{ route('editFilial') }}',{
                method:'post',
                headers:{
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                },
                body: form_data
            });

            if(response.status === 400){
                this.errors = await response.json();
            }
            if(response.status === 200){
                this.message = await response.json();
                this.getFilials();
            }
        }


    },
    mounted(){
        this.getFilials();
    }
}
Vue.createApp(app).mount('#filials-container')
</script>
@endsection
