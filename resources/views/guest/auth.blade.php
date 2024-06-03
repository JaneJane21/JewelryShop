@extends('layout.app')
@section('title')
Авторизация пользователя
@endsection
@section('content')
<div class="container mt-5" id="auth_user">
    <div class="row justify-content-center">
      <div class="col-4">
        <div :class="message?'alert alert-success':''">
          @{{ message }}
        </div>
        <h1 class="mb-3 mt-3">Авторизация</h1>
        <form class="row g-3" id="form-auth" @submit.prevent="Auth" method="post">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" type="email" class="form-control" id="email" name="email" :class="errors.email?'is-invalid':''">
              <div class="invalid-feedback" v-for='error in errors.email'>
                @{{ error }}
              </div>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Пароль</label>
              <input style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" type="password" class="form-control" id="password" name="password" :class="errors.password?'is-invalid':''">
              <div class="invalid-feedback" v-for='error in errors.password'>
                @{{ error }}
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn" style="background-color: rgb(28, 27, 102); color:white">Войти</button>
            </div>
          </form>
      </div>

    </div>
</div>
<script>
    const app = {
        data(){
            return{
                errors:[],
                message:'',
            }
        },
        methods:{
            async Auth(){
                let form = document.getElementById('form-auth');
                let formData = new FormData(form);

                const response = await fetch('{{ route('log_user') }}',{
                    method:'post',
                    headers:{
                        'X-CSRF-TOKEN':'{{csrf_token()}}'
                    },
                    body:formData
                });
                console.log(response)
                if(response.status===400){
                    this.errors = await response.json();
                    setTimeout(()=>[
                        this.errors = []
                    ],10000)
                }
                if(response.status===404){
                    this.message = await response.json();
                    setTimeout(()=>{
                        this.message = ''
                    },5000)
                }
                if(response.status===200){
                    window.location = response.url
                }
                // if(response.status===500){
                //     // this.message = await response.json();
                //     console.log('отработка ошибки')
                //     setTimeout(()=>{
                //         this.message = 'ошибка на сервере'
                //     },5000)
                // }
            }
        }
    }
    Vue.createApp(app).mount('#auth_user')
</script>
@endsection
