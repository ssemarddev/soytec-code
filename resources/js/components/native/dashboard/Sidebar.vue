<script>
    import Mixin from "./SidebarMixin.js"

    export default {
        mixins: [Mixin],
    }
</script>

<template>
    <section class="sidebar scroll" :class="{ 'icons-only': collapse }">
        <button @click="$emit('toogle')" class="btn bg-transparent text-white close"><i class="bi bi-x-square"></i></button>
        <a href="/" class="sidebar-header">
            <img v-if="user.avatar !== undefined" :src="'src/img/avatars/' + user.avatar" />
            <hr />
            <h5 class="mb-0">{{ user.name }}</h5>
            <span class="badge bg-success">{{ user.level }}</span>
        </a>
        <hr />
        <ul class="nav nav-pills flex-column mb-auto" id="modules">
            <li v-for="button in buttons">
                <a :href="button.href" class="nav-link" :class="{ active: active == button.href.substring(1) }"> <i :class="button.icon" :title="button.name" data-bs-toggle="tooltip"></i> {{ button.name }} </a>
            </li>
        </ul>
        <hr />
        <div class="dropdown">
            <a href="#" id="config" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> <i class="bi bi-gear" style="margin-right: 0.5rem"></i> <strong>Configuración</strong> </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-building"></i> Empresa</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-person-badge"></i> Perfil</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-code-slash"></i> Diseño de la página web</a>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </section>
</template>

<style scoped>
    @media (max-width: 670px) {
        .sidebar {
            position: absolute;
        }
    }

    .sidebar {
        overflow-y: auto;
        overflow-x: hidden;
        width: 250px;
        padding: 1rem;
        display: flex;
        flex-shrink: 0;
        flex-direction: column;
        color: #fff;
        background-color: RGBA(33, 37, 41, var(--bs-bg-opacity, 1));
        transition: width ease-in 0.3s;
        z-index: 100;
        max-height: 100vh;
    }

    .sidebar > .close {
        position: absolute;
        display: none;
        top: 0.5rem;
        right: 0.5rem;
    }

    @media (max-width: 670px) {
        .sidebar:not(.icons-only) > .close {
            display: block;
        }
    }

    .sidebar-header {
        text-align: center;
        text-decoration: none;
        color: #fff;
    }

    .sidebar-header:hover {
        color: #fff;
    }

    .sidebar-header > img {
        width: 80%;
        border-radius: 50%;
        transition: width ease-in 0.3s;
    }

    .sidebar-header > hr {
        margin: 0.15rem;
        color: transparent;
    }

    .sidebar-header > span {
        width: 100%;
        line-height: 1.1em;
        font-size: 1.4em;
        transition: font-size ease-in 0.3s, opacity ease-in 0.3s;
    }

    .sidebar-header > span.badge {
        font-size: 0.9em;
        width: auto;
        margin-top: 0.5rem;
    }

    .sidebar > hr {
        transition: margin-top ease-in 0.3s;
    }

    .nav.nav-pills > li {
        transition: margin-bottom ease-in 0.3s;
    }

    .nav.nav-pills > li:hover {
        background: linear-gradient(60deg, transparent, #ffffff3d, transparent);
    }

    .nav.nav-pills > li > a,
    .sidebar > .dropdown > a {
        white-space: nowrap;
        width: 100%;
        transition: all ease-in 0.3s;
    }

    .nav.nav-pills > li > a > i,
    .sidebar > .dropdown > a > i {
        transition: margin-right ease-in 0.3s;
    }

    #modules > li > .nav-link {
        color: #fff;
    }

    .nav.nav-pills > li > .nav-link > i {
        margin-right: 0.4rem;
        font-size: 0.95em;
    }

    /* Colapsar navbar */
    @keyframes icons-only {
        0%,
        80% {
            display: block;
        }

        100% {
            display: none;
            margin-top: 0;
        }
    }

    @media (max-width: 670px) {
        .icons-only {
            display: none;
        }
    }

    .icons-only {
        width: 85px;
    }

    .icons-only > .sidebar-header > span,
    .icons-only > .sidebar-header > h5 {
        opacity: 0;
        font-size: 0.1em;
    }

    .icons-only > .sidebar-header > span,
    .icons-only > .sidebar-header > h5,
    .icons-only > .sidebar-header > hr {
        animation: icons-only 0.1s ease;
        animation-fill-mode: both;
    }

    .icons-only > hr {
        margin-top: 0;
    }

    .icons-only > .sidebar-header > img {
        width: 90%;
    }

    .icons-only > ul > li > a,
    .icons-only > .dropdown > a {
        width: 55px !important;
        white-space: nowrap;
        overflow: hidden;
        font-size: 1.6em;
        padding-top: 0;
        padding-bottom: 0.2rem;
    }

    .icons-only > .dropdown > a {
        padding-left: 0.85rem;
    }

    .icons-only > ul > li {
        margin-bottom: 0.5rem;
    }

    .icons-only > ul > li > a > i,
    .icons-only > .dropdown > a > i {
        margin-right: 1rem !important;
    }

    .icons-only #config > i {
        font-size: 1.1em;
    }
</style>
