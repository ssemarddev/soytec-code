<script>
import Sidebar from './Sidebar.vue'
import NotFound from '../../../components/native/errors/NotFound.vue'
/**
 * Despliega un área de trabajo básica con un panel izquierdo con los enlaces a las diferentes páginas del sistema
 * @component Dashboard
 */
export default {
    components: { NotFound, Sidebar },
    data() {
        const hash = window.location.hash
        const active = hash == "" ? "home" : hash.substring(1)
        return {
            collapse: true,
            active: active,
        }
    },
    props: {
        buttons: Array,
    },
    methods: {
        /**
         * Despliega o colapsa el menú lateral del dashboard
         */
        toogle() {
            this.collapse = !this.collapse
        },
        /**
         * Mostrar el componente seleccionado si existe o mostrar información en pantalla si el componente no existe
         * @param {String} componentLink: Link del componente a mostrar
         */
        showComponent(componentLink) {
            if (componentLink == "") {
                this.active = "home"
            } else {
                if (this.isComponentExist(componentLink)) {
                    this.active = componentLink.substring(1)
                } else {
                    this.active = "NotFound"
                }
            }
        },
        /**
         * Retorna true si el componente existe o false si no existe
         * @param {String} name: Nombre del componente
         * @return {Boolean}: <code>true</code> si el componente existe o <code>false</code> si no existe
         */
        isComponentExist(name) {
            return this.buttons.find((button) => {
                if (button.href == name) return true
            })
        },
    },
    mounted() {
        this.emitter.on("select-component", this.select)
        const hash = window.location.hash
        window.onhashchange = () => {
            this.showComponent(window.location.hash)
        }
        if (hash == "") return
        const exist = this.buttons.find((button) => {
            if (button.href == hash) return true
        })
        if (!exist) this.active = "NotFound"
    },
}
</script>

<template>
    <Sidebar @toogle="toogle" :active="active" :collapse="collapse" :buttons="buttons" />
    <section class="scroll ms-auto">
        <nav class="navbar navbar-expand navbar-dark bg-dark" aria-label="Navbar">
            <div class="container-fluid">
                <button @click="toogle" class="btn bg-transparent text-white"><i
                        class="bi bi-arrow-left-right"></i></button>
                <a class="navbar-brand" href="#">25/08/2022</a>
            </div>
        </nav>
        <div class="container-fluid" id="main">
            <transition name="bounce" mode="out-in">
                <keep-alive>
                    <component :is="active"> </component>
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
}</style>
