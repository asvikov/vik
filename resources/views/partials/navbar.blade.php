<header>
    <div class="bg-secondary bg-gradient">
    <nav class="container navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="/">VIK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link text-light" href="/reports">Ежедневные отчеты</a>
                        </li>
                        @can('viewAny', \App\Models\User::class)
                            <li class="nav-item">
                                <a class="nav-link text-light" href="/articles">Новости</a>
                            </li>
                        @endcan
                        @can('viewAny', \App\Models\Article::class)
                            <li class="nav-item">
                                <a class="nav-link text-light" href="/users">Пользователи</a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a class="nav-link text-light" href="/logout">Выйти</a>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-light" href="/login">Войти</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    </div>
</header>
