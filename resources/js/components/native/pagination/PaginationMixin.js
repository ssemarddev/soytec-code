export default {
    /**
     * @inject config: CustomTable
     */
    inject: ["config"],
    props: {
        /**
         * Botones de paginación de la tabla
         */
        pages: Array,
    },
    data() {
        return {
            /**
             * Contiene los botones de de paginación de la tabla que son ocultados para ajustarse al ancho disponible
             */
            hiddenButtons: [],
            /**
             * Contiene los botones de paginación cuyo número es reemplazado por el texto "..." para indicar que se han ocultado botones de la paginación para ajustarse al ancho disponible
             */
            ellipsisButtons: [],
        }
    },
    watch: {
        pages() {
            setTimeout(() => {
                this.resize()
            }, 100)
        },
        "config.page": function () {
            this.resize()
        },
    },
    methods: {
        /**
         * Ir a la página siguiente
         */
        nextPage() {
            this.config.page++
        },
        /**
         * Ir a la página anterior
         */
        previousPage() {
            this.config.page--
        },
        /**
         * Mostrar una página por su índice
         * @param {number} index Índice de la página a mostrar
         */
        selectPage(index) {
            this.config.page = index
        },
        /**
         * Ocultar los botones sobrantes según el ancho disponible para mostrar los botones de paginación
         */
        resize() {
            this.hiddenButtons = []
            this.ellipsisButtons = []
            //Página actual
            const num = this.config.page
            //Ancho disponible menos el padding
            const width = this.$el.offsetWidth - 25
            //Cantidad de botones
            const length = this.pages.length
            //Cantidad de botones que no caben
            let diff = length + 2 - Math.ceil(width / 45)
            if (diff > 0) {
                //Si la página actual no es la primera añadir "..." a la primera página
                if (num != 0) {
                    diff++
                    this.ellipsisButtons.push(0)
                }
                //Si la página actual no es la última añadir "..." a la última página
                if (num != length - 1) {
                    diff++
                    this.ellipsisButtons.push(length - 1)
                }
                //Ocultar las páginas que no caben
                for (let i = 0, left = 0, rigth = length; i < diff; i++) {
                    //Alternar para ocultar por la derecha o por la izquierda
                    if (i % 2 == 0) {
                        //Si se puede ocultar por la izquierda
                        if (left < num) {
                            //Ocultar por la izquierda
                            this.hiddenButtons.push(left)
                            left++
                        } else {
                            //Ocultar por la derecha
                            this.hiddenButtons.push(rigth)
                            rigth--
                        }
                    } else {
                        //Si se puede ocultar por la derecha
                        if (rigth > num) {
                            //Ocultar por la derecha
                            this.hiddenButtons.push(rigth)
                            rigth--
                        } else {
                            //Ocultar por la izquierda
                            this.hiddenButtons.push(left)
                            left++
                        }
                    }
                }
            }
        },
    },
    mounted() {
        //Detectar cuando cambie el ancho de la ventana del navegador y actualizar los botones de paginación que deben ser ocultados o mostrados según el nuevo ancho disponible
        window.addEventListener("resize", () => {
            this.resize()
        })
    },
}
