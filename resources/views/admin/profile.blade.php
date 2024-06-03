@extends('layout.app')
@section('title')
Профиль администратора
@endsection
@section('content')
<div class="container" id="Profile">
    <h2 class="mt-5">Профиль администратора</h2>
    <div class="row mt-3" style="box-shadow: 0 0 20px rgba(0,0,0,.1); background-color: rgb(231, 231, 233); padding: 25px; border-radius: 10px;">
        <div class="col-7">
            <div class="row mb-4">

                    <div class="row align-items-center">
                        <div class="col-6 d-flex align-items-center justify-content-center" style="border-radius: 50%; width:50px; height:50px; background-color: rgb(191, 212, 243); color: grey; font-weight: bold;"><p style="margin: 0;">{{ mb_substr($user->fio,0,1) }}</p></div>
                        <div class="col-6">
                            {{ $user->fio }}
                        </div>
                    </div>


            </div>
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <p>Email: <span >{{ $user->email }}</span></p>
                </div>
                <div class="col-auto">
                    <p>Телефон: <span style="font-size: 16px;">{{ $user->phone }}</span></p>
                </div>
                <div class="col-auto">
                    <p>Дата рождения: <span style="font-size: 16px;">{{ $user->birthday }}</span></p>
                </div>
            </div>
            <div class="row">
                <div class="col-auto">
                    <button data-bs-toggle="modal" data-bs-target="#editModal" class="btn" style="background-color: rgb(28, 27, 102); color:white;">Редактировать</button>
                    <!-- Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editModalLabel">Редактирвоание профиля</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="row g-3" id="form-reg" @submit.prevent="Reg" method="post">
                                    <div class="col-md-8">
                                        <label for="fio" class="form-label">Фамилия Имя Отчество</label>
                                        <input value="{{ $user->fio }}" style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" type="text" class="form-control" id="fio" name="fio" :class="errors.fio?'is-invalid':''">
                                        <div class="invalid-feedback" v-for='error in errors.fio'>
                                          @{{ error }}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <label for="birthday" class="form-label">Дата рождения</label>
                                        <input value="{{ $user->birthday }}" style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" type="date" class="form-control" id="birthday" name="birthday" :class="errors.birthday?'is-invalid':''">
                                        <div class="invalid-feedback" v-for='error in errors.birthday'>
                                          @{{ error }}
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input value="{{ $user->email }}" style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" type="email" class="form-control" id="email" name="email" :class="errors.email?'is-invalid':''">
                                        <div class="invalid-feedback" v-for='error in errors.email'>
                                          @{{ error }}
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <label for="phone" class="form-label">Телефон</label>
                                        <input value="{{ $user->phone }}" style="border: 1px solid rgb(28, 27, 102);outline: rgb(28, 27, 102);" type="text" class="form-control" id="phone" name="phone" :class="errors.phone?'is-invalid':''">
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
                                        <button type="submit" class="btn" style="background-color: rgb(28, 27, 102); color:white">Сохранить изменения</button>
                                      </div>
                                    </form>
                            </div>

                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin_profile_destroy') }}" class="btn btn-outline-danger">удалить профиль</a>
                </div>
            </div>
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
          const response = await fetch('{{ route('admin_profile_edit') }}',{
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
            location.reload()
            this.message = await response.json();
            setTimeout(()=>{
              this.message = ''
            },5000)
          }
        }
      }
    }
    Vue.createApp(app).mount('#Profile')
  </script>
@endsection
