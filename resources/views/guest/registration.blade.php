@extends('layout.app')
@section('title')
Регистрация
@endsection
@section('content')
<div class="container mt-5" id="Registration">
    <div class="row justify-content-center">
      <div class="col-7">
        <div :class="message?'alert alert-success':''">
          @{{ message }}
        </div>
        <h1 class="mb-3 mt-3">Регистрация</h1>
        <form class="row g-3" id="form-reg" @submit.prevent="Reg" method="post">
          <div class="col-md-8">
              <label for="fio" class="form-label">Фамилия Имя Отчество</label>
              <input style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" type="text" class="form-control" id="fio" name="fio" :class="errors.fio?'is-invalid':''">
              <div class="invalid-feedback" v-for='error in errors.fio'>
                @{{ error }}
              </div>
            </div>
            <div class="col-md-4">
              <label for="birthday" class="form-label">Дата рождения</label>
              <input style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" type="date" class="form-control" id="birthday" name="birthday" :class="errors.birthday?'is-invalid':''">
              <div class="invalid-feedback" v-for='error in errors.birthday'>
                @{{ error }}
              </div>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" type="email" class="form-control" id="email" name="email" :class="errors.email?'is-invalid':''">
              <div class="invalid-feedback" v-for='error in errors.email'>
                @{{ error }}
              </div>
            </div>
            <div class="col-md-6">
              <label for="phone" class="form-label">Телефон</label>
              <input style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" type="text" class="form-control" id="phone" name="phone" :class="errors.phone?'is-invalid':''">
              <div class="invalid-feedback" v-for='error in errors.phone'>
                @{{ error }}
              </div>
            </div>
            
            
            <div class="col-md-6">
              <label for="password" class="form-label">Пароль</label>
              <input style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" type="password" class="form-control" id="password" name="password" :class="errors.password?'is-invalid':''">
              <div class="invalid-feedback" v-for='error in errors.password'>
                @{{ error }}
              </div>
            </div>
            <div class="col-md-6">
              <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
              <input style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" type="password" class="form-control" id="password_confirmation" name="password_confirmation" :class="errors.password?'is-invalid':''">
              <div class="invalid-feedback" v-for='error in errors.password'>
                @{{ error }}
              </div>
            </div>
            <div class="col-12">
              <div class="form-check">
                <input style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" class="form-check-input" type="checkbox" id="rule" name="rule" :class="errors.rule?'is-invalid':''">
                <div class="invalid-feedback" v-for='error in errors.rule'>
                  @{{ error }}
                </div>
                <label class="form-check-label" for="rule">
                  Согласен(-на) на обработку ПД
                </label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn" style="background-color: rgb(28, 27, 102); color:white">Зарегистрироваться</button>
            </div>
          </form>
      </div>
        
    </div>
</div>
<script>
  const app={
    data(){
      return{
        errors:[],
        message:'',
      }
    },
    methods:{
      async Reg(){
        let form = document.getElementById('form-reg');
        let formData = new FormData(form);
        const response = await fetch('{{ route('Registration') }}',{
          method:'post',
          headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
          },
          body:formData
        });
        if(response.status===400){
          this.errors = await response.json();
          setTimeout(()=>{
            this.errors = []
          },10000)
        }
        if(response.status===200){
          this.message = await response.json();
          setTimeout(()=>{
            this.message = ''
          },5000)
        }
      }
    }
  }
  Vue.createApp(app).mount('#Registration')
</script>
@endsection

