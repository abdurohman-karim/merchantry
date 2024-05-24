<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title font-size-10"><i>Управление</i></li>
                <li>
                    <a href="{{ route('home') }}" class="waves-effect">
                        <i class="fas fa-home"></i>
                        <span>Основной</span>
                    </a>
                </li>
                @canany(["Просмотр пользователей","Просмотр разрешений","Посмотреть роли"])
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-users-cog"></i>
                        <span key="t-tasks">Контрол доступа</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false">
                        @can("Просмотр пользователей")
                        <li class="{{ Request::is('users*') ? "mm-active":''}}"><a href="{{ route('users.index') }}" key="t-task-list">
                                <i class="fas fa-angle-right px-2"></i>
                                Пользователи
                            </a>
                        </li>
                        @endcan
                        @can('Посмотреть роли')
                        <li class="{{ Request::is('roles*') ? "mm-active":''}}"><a href="{{ route('roles.index') }}" key="t-kanban-board">
                                <i class="fas fa-angle-right px-2"></i>
                                Роли
                            </a>
                        </li>
                        @endcan
                        @can('Просмотр разрешений')
                        <li class="{{ Request::is('permissions*') ? "mm-active":''}}"><a href="{{ route('permissions.index') }}" key="t-create-task">
                                <i class="fas fa-angle-right px-2"></i>
                                Разрешения
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                @can('merchants.index')
                    <li>
                        <a href="{{ route('merchants.index') }}" class="waves-effect {{ Request::is('merchants*') ? "mm-active":'' }}">
                            <i class="fas fa-store"></i>
                            <span>Магазины</span>
                        </a>
                    </li>
                @endcan
                @can('products.index')
                    <li>
                        <a href="{{ route('products.index') }}" class="waves-effect {{ Request::is('products*') ? "mm-active":'' }}">
                            <i class="fas fa-cart-plus"></i>
                            <span>Продукты</span>
                        </a>
                    </li>
                @endcan
                @can('transactions.index')
                    <li>
                        <a href="{{ route('transactions.index') }}" class="waves-effect {{ Request::is('transactions*') ? "mm-active":'' }}">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Транзакции</span>
                        </a>
                    </li>
                @endcan
                @can('transactions.in')
                    <li>
                        <a href="{{ route('transactions.in') }}" class="waves-effect {{ Request::is('transactions/in*') ? "mm-active":'' }}">
                            <i class="fas fa-arrow-circle-down"></i>
                            <span>Приход</span>
                        </a>
                    </li>
                @endcan
                @can('transactions.out')
                    <li>
                        <a href="{{ route('transactions.out') }}" class="waves-effect {{ Request::is('transactions/out*') ? "mm-active":'' }}">
                            <i class="fas fa-arrow-circle-up"></i>
                            <span>Расход</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
