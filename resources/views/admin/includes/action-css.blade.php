@push('style')
<style type="text/css">
    .user-dropdown-link {
        display: inline-block;
        position: relative;
        background: #fff;
        border: 1px solid #aaa;
        padding: 8px 25px 8px 12px;
        font-size: 16px;
        font-weight: 500;
        color: #000;
        border-radius: 5px;
    }

    .user-dropdown-link:after {
        position: absolute;
        content: "";
        width: 0.5em;
        height: 0.5em;
        border-style: solid;
        border-width: 1.2px 0 0 1.2px;
        border-color: initial;
        right: 8px;
        transform: rotate(-135deg) translateY(-50%);
        transform-origin: top;
        top: 45%;
        transition: all .3s ease-out;
    }

    .user-dropdown-menu {
        position: relative;
    }

    .user-item-submenu {
        padding-left: 0;
        margin-bottom: 0;
        position: absolute;
        background: #fff;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        border-radius: 3px;
        width: 150px;
        opacity: 0;
        visibility: hidden;
        transform: scale(0);
        transition: all .5s ease;
    }

    .user-dropdown-menu.show .user-item-submenu {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }

    .user-item-submenu .submenu-item {
        list-style: none;
    }

    .user-item-submenu .submenu-item .submenu-item-link {
        padding: 6px;
        display: block;
        font-size: 14px;
        font-weight: 400;
        color: #000;
        border-bottom: 1px solid #ddd;
    }

    .user-item-submenu .submenu-item .submenu-item-link:hover {
        background: #ddd;
    }

    .user-dropdown-link:hover {
        color: #000;
    }

    .user-item-submenu .submenu-item:last-child .submenu-item-link {
        border-bottom: none;
    }
    .action-dropdown-link {
        display: inline-block;
        position: relative;
        background: #fff;
        border: 1px solid #aaa;
        padding: 8px 25px 8px 12px;
        font-size: 16px;
        font-weight: 500;
        color: #000;
        border-radius: 5px;
    }

    .action-dropdown-link:after {
        position: absolute;
        content: "";
        width: 0.5em;
        height: 0.5em;
        border-style: solid;
        border-width: 1.2px 0 0 1.2px;
        border-color: initial;
        right: 8px;
        transform: rotate(-135deg) translateY(-50%);
        transform-origin: top;
        top: 45%;
        transition: all .3s ease-out;
    }

    .action-btn-list {
        padding-left: 0;
        margin-bottom: 0;
        position: absolute;
        background: #fff;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        border-radius: 3px;
        width: 100px;
        opacity: 0;
        visibility: hidden;
        transform: scale(0);
        transition: all .5s ease;
        z-index: 99;
    }

    .action-dropdown-menu.active .action-btn-list {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }

    .action-btn-list-item {
        list-style: none;
    }

    .action-dropdown-link:hover {
        color: #000;
    }
    .action-btn-link:hover {
        background: #ddd;
        color: #000;
    }

    .action-btn-link {
        padding: 6px;
        display: block;
        font-size: 14px;
        font-weight: 400;
        color: #000;
        border-bottom: 1px solid #ddd;
    }
</style>
@endpush
