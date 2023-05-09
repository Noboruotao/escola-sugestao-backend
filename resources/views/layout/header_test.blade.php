<nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Fourth navbar example">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled">Disabled</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
        </ul>

        @if(Auth::check())
            <form class="d-flex mt-3 mt-lg-0" action="{{  route('logout')  }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger" type="submit">Logout</button>
          </form>
        @else
          <form class="d-flex mt-3 mt-lg-0" action="{{  route('login')  }}" method="POST">
            @csrf
            <input class="form-control me-2" name="cpf" value="{{ $pessoa->cpf }}">
            <input class="form-control" name="senha" value="password" hidden>
            <button class="btn btn-outline-success" type="submit">Login</button>
          </form>
        @endif
      </div>
    </div>
</nav>