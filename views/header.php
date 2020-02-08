<header class="sb-header">
    <nav class="navbar navbar-expand-lg navbar-light">

        <a class="navbar-brand" href="/">Задачник</a>

        <!--button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sb-menu-items" aria-controls="sb-menu-items" aria-expanded="false">
          <span class="navbar-toggler-icon"></span>
        </button-->

        <!--div class="collapse navbar-collapse" id="sb-menu-items"-->
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="newtask">Добавить новую задачу</a>
            </li>
        </ul>

        <ul class="navbar-nav mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link disabled"><?= is_null(App::$user) ? 'Гость' : App::$user->name; ?></a>
            </li>
            <li class="nav-item">
				<?= is_null(App::$user)
                    ? '<a class="nav-link" href="auth">войти</a>'
                    : '<a class="nav-link" href="user/logout">выйти</a>'; ?>
            </li>
        </ul>

        <!--form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form-->
        <!--/div-->
    </nav>
</header>