<header class="header">
    <div class="header-logo">
        <a href="{{ route('home') }}">
            <img class="header__img" src="{{ asset('images/logo.svg') }}" alt="ロゴ画像">
        </a>
    </div>

    <div class="header-search">
        <form action="{{ route('home') }}" method="get">
            <input type="text" name="search" class="header-search__input" placeholder="なにをお探しですか？" value="{{ request('search') }}">
        </form>
    </div>

    <nav class="header-nav">
        <ul class="header-nav-list">
            @if(Auth::check())
                <!-- ログイン認証済みの場合 -->
                <li class="header-nav-item">
                    <form action="/logout" method="post">
                        @csrf
                        <button class="header-nav__button">ログアウト</button>
                    </form>
                </li>
                <li class="header-nav-item"><a class="header-nav-item__myp" href="/mypage">マイページ</a></li>
                <li class="header-nav-item"><a class="header-nav-item__sale" href="/sell">出品</a></li>
            @else
                <!-- 未認証の場合 -->
                <li class="header-nav-item">
                    <a class="header-nav__link" href="{{ route('login') }}">ログイン</a>
                </li>
                <li class="header-nav-item"><a class="header-nav-item__myp" href="/page">マイページ</a></li>
                <li class="header-nav-item"><a class="header-nav-item__sale" href="/sell">出品</a></li>
            @endif
        </ul>
    </nav>
</header>