export default {
    data() {
        return {
            select: 0,
        }
    },
    watch: {
        select() {
            setTimeout(() => {
                this.updateActivePosition()
            }, 50)
        },
    },
    props: {
        /**
         * Páginas a mostrar en los controles del carrusel
         * @type Array<CarouselPage>
         */
        windows: Array,
    },
    methods: {
        /**
         * Cambiar a una página por su índice
         * @param {int} index: Índice de la página a mostrar
         */
        changePage(index) {
            this.windows.map((window) => (window.active = false))
            this.windows[index].active = true
            this.select = index
        },
        /**
         * Cambia el indicador visual de la página activa a su posición según la página activa
         */
        updateActivePosition() {
            const children = this.$el.querySelector("ul").children
            const select = this.$el.querySelector(".select")
            select.style.width = `${children[this.select + 1].offsetWidth}px`
            select.style.height = `${children[this.select + 1].offsetHeight}px`
            select.style.left = `${children[this.select + 1].offsetLeft}px`
            select.style.top = `${children[this.select + 1].offsetTop}px`
        },
    },
    mounted() {
        this.windows.map((window, index) => {
            if (window.active) {
                this.select = index
            }
        })
        this.updateActivePosition()
        window.addEventListener("resize", () => {
            this.updateActivePosition()
        })
    },
}
