<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script src="https://kit.fontawesome.com/c43b725176.js" crossorigin="anonymous"></script>
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    {{-- lines billow for dropdown search --}}
    <!-- Hierarchy Select CSS -->
    <link rel="stylesheet" href="/css/hierarchy-select.min.css">
    <!-- Demo CSS -->
    {{-- <link rel="stylesheet" href="/css/demo.css"> --}}

    <!-- Scripts -->

    <script src='https://www.google.com/recaptcha/api.js'></script>

    <style>
      .badge {
        background-color: red;
        color: white;
        padding: 4px 8px;
        border-radius: 50%;
        display: inline-block;
        margin-left: 4px;
      }
    </style>
    
</head>
<body>


    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm" >
            <div class="container-fluid">
                <a class="navbar-brand" href="{{url('/')}}">Home</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                  @isAdmin
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('student.index')}}" >كل الطلاب</a>
                  </li>
                 
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('student.create')}}">إضافة طالب</a>
                  </li>

                  <li class="nav-item">

                    <a class="nav-link" href="{{route('studentReq.index')}}">طلبات التسجيل<span class="badge">{{ $ReqNum }}</span></a>
                  </li>
                  @endisAdmin

                  @isStudent
                      <li class="nav-item">

                        @isStoredStudent               
                          <a class="nav-link" href="{{ route('student1.show',  Auth::User()->id) }}">عرض صفحتي</a>
                        @else
                          @haveReq
                          <a class="nav-link" href="{{route('studentReq.show', Auth::User()->id)}}">عرض الطلب</a>
                          @else
                          <a class="nav-link" href="{{route('studentReq.create')}}">طلب تسجيل</a>
                          @endhaveReq
                        @endisStoredStudent
                      </li>
                  @endisStudent
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Dropdown link
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li>
                  
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->

                    @isAdmin
                        <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            إدارة المستخدمين
                          </a>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('users.index')}}">عرض المستخدمين</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.create')}}">إنشاء حساب</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                          </ul>
                        </li>
                    @endisAdmin


                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
              </div>
            </div>
          </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://kit.fontawesome.com/c43b725176.js" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="/js/script.js"></script>

    {{-- lines billow for search dropdown --}}
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Popper Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>
    <!-- Hierarchy Select Js -->
    <script src="/js/hierarchy-select.min.js"></script>
    
    <script>
    $(document).ready(function(){
        $('#example').hierarchySelect({
        hierarchy: false,
        width: 'auto'
      });
    });
    </script>

</body>
</html>
