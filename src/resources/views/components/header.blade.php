<header class="header">
  <img class="header__img" src="{{ asset('images/logo.svg') }}" alt="ロゴ画像">
  @if( Auth::check() )
  <nav class="header-nav">
    <ul class="header-nav-list">
        <li class="header-nav-item"><a href="/logout">検索</a></li>
        <li class="header-nav-item">
            <form action="/logout" method="post">
            @csrf
                <button class="header-nav__button">ログアウト</button>
            </form>
        </li>
        <li class="header-nav-item"><a class="header-nav-item__myp" href="/mypage">マイページ</a></li>
        <li class="header-nav-item"><a class="header-nav-item__sale" href="/sell">出品</a></li>
    </ul>
  </nav>
  @endif
</header>