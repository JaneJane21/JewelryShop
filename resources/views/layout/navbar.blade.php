<nav id="Nav" class="navbar navbar-expand-lg" style="background-color: rgb(28, 27, 102)" data-bs-theme="dark">
    <div class="container d-flex flex-column mb-3">
        <div class="row mt-3 mb-3">
            <div class="col-12">
              <a class="navbar-brand" href="{{ route('show_welcome') }}">
            <img src="{{ asset('public\images\logo.png') }}" alt="Logo" class="d-inline-block align-text-top">

          </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 justify-content-between">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav justify-content-between">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('show_welcome') }}">Главная</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('catalog') }}">Каталог</a>
          </li>
            @guest
              <li class="nav-item">
            <a class="nav-link" href="{{ route('show_reg') }}">Регистрация</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('login')}}">Авторизация</a>
          </li>
            @endguest
          @auth
              @if (Illuminate\Support\Facades\Auth::user()->role==1)

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Управление сайтом
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('show_categories') }}">Характеристики</a></li>
                  <li><a class="dropdown-item" href="{{ route('show_filials') }}">Филиалы</a></li>
                  <li><a class="dropdown-item" href="{{ route('show_products') }}">Товары</a></li>
                  <li><a class="dropdown-item" href="{{ route('show_orders') }}">Заказы <span v-if="total != 0" style="display: inline-block; color: white; border-radius:50%; background-color: red; width:20px; height:20px; text-align:center;">@{{ total }}</span></a></li>
                </ul>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Управление профилем
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('admin_profile') }}">Профиль администратора</a></li>
                  <li><a class="dropdown-item" href="{{ route('logout') }}">Выход</a></li>

                </ul>
              </li>
              @elseif (Illuminate\Support\Facades\Auth::user()->role==0)
              <li class="nav-item">
                <a class="nav-link" href="{{route('cart')}}">Корзина</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('fav_page')}}">Избранное</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('my_orders')}}">Заказы</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Управление профилем
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('user_profile') }}">Профиль пользователя</a></li>
                  <li><a class="dropdown-item" href="{{ route('logout') }}">Выход</a></li>

                </ul>
              </li>
              @endif


          @endauth


        </ul>
      </div>
            </div>


        </div>

    </div>
  </nav>
<script>
  const app_nav = {
    data(){
      return {
        total:''
      }
    },
    methods:{
      async get_num(){
        const response = await fetch('{{ route('new_order') }}')
        num = await response.json()
        this.total = num[0]

      }
    },
    mounted(){
      this.get_num()
    },
    updated(){
      this.get_num()
    }
  }
  Vue.createApp(app_nav).mount('#Nav');
</script>
