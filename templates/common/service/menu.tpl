<ul class="menu-small">
    <li class="menu-item hamburger js-menu-hamburger">
        <i class="glyphicon glyphicon-menu-hamburger"></i>
        <ul class="submenu" id="menu-hamburger">
            <li class="menu-item clearfix menu-hamburger-hidden">
                <div class="menu-hamburger-left"></div>
                <div class="menu-hamburger-closed"><i class="glyphicon glyphicon-remove"></i></div>
            </li>
            <li class="menu-item"><a class="link" href="/service/catalog">Каталог</a></li>
            {$top_menu}
        </ul>
    </li>
    <li class="menu-item order"><a class="link" data-toggle="modal" data-target="#feedpopup">Сделать заказ</a></li>
</ul>

<ul class="menu">
    <li class="menu-item catalog js-menu-catalog">
        <a class="link" href="/service/catalog"><i class="glyphicon glyphicon-menu-hamburger"></i> Каталог</a>
        <div id="menu-slide">
            {$top_menu_catalog}
        </div>
    </li>
    {$top_menu}
    <li class="menu-item order"><a class="link" data-toggle="modal" data-target="#feedpopup">Сделать заказ</a></li>
</ul>