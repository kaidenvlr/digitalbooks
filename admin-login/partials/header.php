<style>
    .container {
        display: flex;
        background-color: darkcyan;
    }

    .banner {
        padding: 20px 30px;
        background-color: darkcyan;
        color: white;
    }
    .banner:hover {
        background-color: rgb(0, 100, 100);
    }
    
    .banner h4 {
        color: white;
    }

    .rightbar {
        display: flex;
        margin-left: auto;
        margin-right: 0em;
    }

    .navbar {
        display: flex;
        overflow: hidden;
        background-color: darkcyan;
        align-items:right;
    }
    /* Ссылки в панели навигации */
    .navbar a {
        float: left;
        font-size: 16px;
        background-color: darkcyan;
        color: white;
        text-align: center;
        padding: 20px 30px;
        text-decoration: none;
        width: 135px;
    }


    /* Выпадающий контейнер */
    .dropdown {
        float: left;
        overflow: hidden;
    }

    /* Кнопка выпадающего списка */
    .dropdown .dropbtn {
        font-size: 16px;
        border: none;
        outline: none;
        color: white;
        padding: 20px 30px;
        background-color: inherit;
        font-family: inherit; /* Важно для вертикального выравнивания на мобильных телефонах */
        margin: 0; /* Важно для вертикального выравнивания на мобильных телефонах */
        width: 135px;
    }

    /* Добавить красный цвет фона для ссылок на навигационную панель при наведении курсора */
    .navbar a:hover, .dropdown:hover .dropbtn {
        background-color: rgb(0, 100, 100);
    }

    .dropdown:hover .dropdown-content {
        max-height: 300px;
    }

    /* Выпадающее содержимое (скрыто по умолчанию) */
    .dropdown-content {
        max-height:0px;
        overflow:hidden;
        -webkit-transition:max-height 0.4s linear;
        -moz-transition:max-height 0.4s linear;
        transition:max-height 0.4s linear;
        position: absolute;
        background-color: darkcyan;
        color: white;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    /* Ссылки внутри выпадающего списка */
    .dropdown-content a {
        float: none;
        color: white;
        padding: 20px 30px;
        text-decoration: none;
        display: inline-block;
        text-align: left;
        width: 100%;
    }

    /* Добавить серый цвет фона для выпадающих ссылок при наведении курсора */
    .dropdown-content a:hover {
        background-color: rgb(0, 100, 100);
    }

    /* Показать выпадающее меню при наведении курсора */
    .menubox {
        background-color: darkcyan;
        padding: 0 30px;
        color: white;
        align-items: right;
    }

    .menubox:hover {
        background-color: rgb(0, 100, 100);
    }
    a:visited {
        color: white;
    }
</style>

<div class="container ">
    <a class="banner" href="/admin-login/dashboard.php">
        <h4>Admin panel</h4>
    </a>
    <div class="rightbar">
        <div class="navbar">
            <div class="dropdown">
                <button class="button dropbtn">Admin</button>
                <div class="dropdown-content">
                    <a href="/admin-login/logout.php"><i class='fas fa-sign-out-alt'></i>Log out</a>
                </div>
            </div>
        </div>
    </div>
</div>