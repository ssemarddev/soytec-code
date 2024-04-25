import Carousel from "bootstrap/js/dist/carousel"
import CarouselControl from "./CarouselControl.vue"
import CarouselPage from "./CarouselPage.js"

export default {
    components: { CarouselControl },
    props: {
        /**
         * Título del contenido de la página que se está mostrando
         */
        title: {
            type: String,
            default: "Módulo",
        },
        /**
         * Páginas a mostrar en los controles del carrusel
         * @type Array<CarouselPage>
         */
        windows: Array,
    },
    provide() {
        return {
            /**
             * @provide Título de la página que se muestra 
             */
            title: this.title,
        }
    },
    methods: {
        /**
         * Cambiar a una página por su ID
         * @param {String} id: ID de la página a mostrar
         */
        goPageById(id) {
            this.windows.map((window) => {
                if (window.id == id) {
                    window.hidden = false
                    this.$el.querySelector(`#${id}`).click()
                }
            })
        },
        /**
         * Ocultar una página de los controles del carrusel por su ID
         * @param {String} id: ID de la página a ocultar
         */
        hidePageById(id) {
            this.windows.map((window) => {
                if (window.id == id) {
                    window.hidden = true
                }
            })
        },
    },
    mounted() {
        new Carousel(this.$el.querySelector(".carousel"))
    },
}
