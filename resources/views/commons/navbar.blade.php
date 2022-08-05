<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        {{-- トップページへのリンク --}}
        <a class="navbar-brand" href="/">Mgal Dance School</a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item">{!! link_to_route('lesson-schedules.index', 'スケジュール', [],  ['class' => 'nav-link']) !!}</li>
                    <li class="nav-item">{!! link_to_route('reservations', '予約一覧', [],  ['class' => 'nav-link']) !!}</li>
                    @if (Auth::user()->is_admin == 1)
                        <li class="nav-item">{!! link_to_route('lessons.index', 'レッスン', [],  ['class' => 'nav-link']) !!}</li>
                        <li class="nav-item">{!! link_to_route('instructors.index', '講師', [],  ['class' => 'nav-link']) !!}</li>
                        <li class="nav-item">{!! link_to_route('studios.index', 'スタジオ', [],  ['class' => 'nav-link']) !!}</li>
                        <li class="nav-item">{!! link_to_route('users.index', 'お客様管理', [],  ['class' => 'nav-link']) !!}</li>
                    @elseif (Auth::user()->is_admin == 0)
                        <li class="nav-item">{!! link_to_route('users.edit', '設定', ['user' => Auth::user()->id],  ['class' => 'nav-link']) !!}</li>
                    @endif    
                    {{-- ログアウトへのリンク --}}
                    <li class="nav-item">{!! link_to_route('logout.get', 'Logout', [],  ['class' => 'nav-link']) !!}</li>
                @else
                    {{-- ユーザ登録ページへのリンク --}}
                    <li>{!! link_to_route('signup.get', 'Signup', [], ['class' => 'nav-link']) !!}</li>
                    {{-- ログインページへのリンク --}}
                    <li class="nav-item">{!! link_to_route('login', 'Login', [], ['class' => 'nav-link']) !!}</li>
                @endif
            </ul>
        </div>
    </nav>
</header>
