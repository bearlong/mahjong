<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet">

<style>
    :root {
        --aside-width: 190px;
        --header-nav-height: 56px;
    }

    .navbar {
        padding-left: var(--aside-width);
    }

    .sidebar {
        width: var(--aside-width);
        height: 100vh;
        /* border-radius: 0 var(--header-nav-height) var(--header-nav-height) 0; */
        top: 0;
    }

    .sidebar ul {
        padding: 0;
        margin: 0;
    }

    .sidebar ul a {
        color: #999;
    }

    .arrow {
        position: absolute;
        right: 10px;
        display: none;
    }

    .sidebar ul a:hover,
    .sidebar ul a.active {
        background: linear-gradient(to right, #000 10%, goldenrod);
        color: white;
    }

    .sidebar ul .sub-label:hover {
        background: #999;
        transition: .3s;
    }

    .main-sidebar {
        cursor: pointer;
    }

    .sub-label-ul {
        max-height: 0px;
        overflow: hidden;
        transition: .5s;
    }

    .sub-label-ul-active {
        max-height: 100px;
        overflow: hidden;
        transition: .5s;
    }

    .list-unstyle {
        list-style: none;
    }

    .logo {
        width: calc(var(--aside-width) - 20px);
    }

    .object-fit-cover {
        width: 100%;
        height: 100%;
    }

    .main-content {
        margin: 0 0 0 var(--aside-width);
        padding-top: var(--header-nav-height);
    }

    .hamburger {
        font-size: 24px;
        color: goldenrod;
        cursor: pointer;
    }

    #switch {
        display: none;
    }

    #switch:checked~.list-group {
        max-height: 260px;
    }

    .list-group {
        top: var(--header-nav-height);
        right: -5px;
        max-height: 0;
        overflow: hidden;
        transition: .5s;
    }
</style>