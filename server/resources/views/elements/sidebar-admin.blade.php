<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ !empty($navAccount)? $navAccount : '' }}" href="/manage/account">
                    <span data-feather="users"></span>
                    アカウント管理
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ !empty($navOrganization)? $navOrganization : '' }}" href="/manage/organization">
                    <span data-feather="clipboard"></span>
                    法人管理
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ !empty($navGroup) ? $navGroup : '' }}" href="/manage/group">
                    <span data-feather="users"></span>
                    部門管理
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ !empty($navService)? $navService : '' }}" href="/manage/service">
                    <span data-feather="file"></span>
                    サービス管理
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ !empty($navAdmin)? $navAdmin : '' }}" href="/manage/admin">
                    <span data-feather="monitor"></span>
                    管理者管理
                </a>
            </li>
        </ul>
    </div>
</nav>
