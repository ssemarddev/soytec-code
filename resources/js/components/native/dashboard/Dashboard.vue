<script>
    import Mixin from "./DashboardMixin.js"

    /**
     * Despliega un área de trabajo básica con un panel izquierdo con los enlaces a las diferentes páginas del sistema
     * @component Dashboard
     */
    export default {
        mixins: [Mixin],
    }
</script>

<template>
    <Sidebar @toogle="toogle" :active="active" :user="user" :collapse="collapse" :buttons="buttons" />
    <section class="scroll ms-auto">
        <nav class="navbar navbar-expand navbar-dark bg-dark" aria-label="Navbar">
            <div class="container-fluid">
                <button @click="toogle" class="btn bg-transparent text-white"><i class="bi bi-arrow-left-right"></i></button>
                <a class="navbar-brand" href="#">25/08/2022</a>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav me-auto"></ul>
                    <button class="btn bg-transparent text-white"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</button>
                </div>
            </div>
        </nav>
        <div class="container-fluid" id="main">
            <transition name="bounce" mode="out-in">
                <keep-alive>
                    <component @example="temp" :is="active"> </component>
                </keep-alive>
            </transition>
        </div>
    </section>
</template>

<style scoped>
    #main {
        padding: 0;
    }
    @keyframes zoomInDown {
        from {
            opacity: 0;
            transform: scale3d(0.1, 0.1, 0.1) translate3d(0, -1000px, 0);
            animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
        }

        60% {
            opacity: 1;
            transform: scale3d(0.475, 0.475, 0.475) translate3d(0, 60px, 0);
            animation-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1);
        }
    }
    .bounce-enter-active {
        animation: zoomInDown 0.5s;
    }
    .dropdown-toggle {
        outline: 0;
    }

    .scrollarea {
        overflow-y: auto;
    }

    .navbar-brand {
        font-size: 1em;
        margin-left: 0.5rem;
    }
    section {
        overflow-y: auto;
        width: calc(100vw - 85px);
    }
    @media (max-width: 670px) {
        section {
            width: 100vw;
        }
    }
</style>
