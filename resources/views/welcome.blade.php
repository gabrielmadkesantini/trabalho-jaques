@extends('!layout.layout')

@section('title', 'Flix Screen')

@section('content')

  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <!-- Navbar Start -->
  <div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">
      <div class="col-lg-3 d-none d-lg-block">
        <a class="btn shadow-none d-flex align-items-center bg-primary text-white w-100"
          style="height: 65px; margin-top: 10px; padding: 0 30px;">
          <h6 class="m-0">Categorias</h6>
        </a>
        <nav
          class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0"
          id="navbar-vertical">
          <div class="navbar-nav w-100 overflow-hidden" style="height:460px">
            <div class="nav-item dropdown">
            </div>
              @foreach ($categorias as $categoria)
                @php
                  $currentUrl = url()->current(); 
                  $paramName = 'categoria'; 
                  $paramValue = $categoria->name;
                  $urlWithParam = $currentUrl . '?' . $paramName . '=' . urlencode($paramValue);
                @endphp

                <a href="{{ $urlWithParam }}" style="display: block; margin-bottom: 20px; border-bottom: 1px solid #ccc;">
                  {{ $categoria->name }}
                </a>
              @endforeach
          </div>
        </nav>
      </div>
      <div class="col-lg-9">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
          </button>
        </nav>
        <div class="container-fluid pt-5">
         
          @if ($movies instanceof \Illuminate\Database\Eloquent\Collection && $movies->count() > 0)
          <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">FILMES</span></h2>
          </div>
            <div class="row px-xl-5 pb-3">
              @foreach ($movies as $movie)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                  <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                      @if ($movie->imagem)
                        <a href="{{ route('movie.moviePage', $movie->id) }}">
                          <img class="img-fluid w-100" src="{{ asset('storage/' . $movie->imagem) }}"
                            alt="{{ $movie->nome }}" style="width: 150px; height: 200px; object-fit: cover;">
                        </a>
                      @else
                        Sem imagem
                      @endif
                    </div>
                    <div class="card-body border text-center p-0 pt-4 pb-3">
                      <h6 class="text-truncate mb-3" style="font-size: 14px; margin-left: 2px;"><a
                          href="{{ route('movie.moviePage', $movie->id) }}">{{ $movie->nome }}</a>
                      </h6>
                      <div class="d-flex" style="margin-left: 8px;"></div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @else
          <p>Sem resultado para essa pesquisa</p>
          @endif
        </div>
        <div>
        @endsection
