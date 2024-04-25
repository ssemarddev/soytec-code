export default {
    /**
     * @emit select-filter Se llama cuando se selecciona un filtro guardado previamente o cuando se limpia el formulario de búsqueda
     */
    emits: ["select-filter"],
    props: {
        /**
         * Parámetros de búsqueda
         */
        params: Object,
        /**
         * Nombre único donde se almacenan los filtros para el módulo en el navegador
         */
        store: String,
    },
    data() {
        let savedFilters = []
        const store = localStorage.getItem(this.store)
        if (store !== null) {
            savedFilters = JSON.parse(store)
        }
        return {
            /**
             * Filtro seleccionado dentro de la lista de filtros guardados
             * @prop {number} Índice del filtro seleccionado o null si no se ha seleccionado ninguno
             * @prop {boolean} <code>True</code> si se está editando el filtro seleccionado o <code>false</code> si no
             * @type Object
             */
            selected: {
                index: null,
                edit: false,
            },
            /**
             * Entrada del usuario para el nombre del filtro a ser guardado o actualizado
             * @type {String}
             */
            nameInput: "",
            /**
             * Lista de filtros guardados
             * @type {Array<Object>}
             */
            savedFilters: savedFilters,
            /**
             * <code>true</code> si existe un error al guardar el filtro o <code>false</code> si no
             * @type {boolean}
             */
            error: false,
        }
    },
    methods: {
        /**
         * Establece un filtro de la lista de filtros guardados
         * @param {number} index Índice del filtro guardado
         * @event select-filter
         */
        setFilter(index) {
            //Establecer el filtro
            this.selected.index = index
            //Establecer el nombre en la entrada del usuario
            this.nameInput = this.savedFilters[index].name
            //Emitir el evento
            this.$emit("select-filter", this.savedFilters[index].data)
        },
        /**
         * Guarda los parámetros de búsqueda actuales en un filtro
         */
        saveFilter() {
            //Si el nombre del filtro está vacío terminar la ejecución de la función
            if (this.nameInput == "") {
                this.error = true
                return
            }
            //Determinar si se está editando un filtro o se está guardando
            if (this.selected.index !== null) {
                const edit = this.selected.edit
                this.selected.edit = !edit
                if (edit) {
                    //Actualizar datos del filtro
                    this.savedFilters[this.selected.index].name = this.nameInput
                    for (let key in this.params) {
                        this.savedFilters[this.selected.index].data[key] = this.params[key]
                    }
                    //Guardar el filtro
                    localStorage.setItem(this.store, JSON.stringify(this.savedFilters))
                }
            } else {
                const filter = {}
                for (let key in this.params) {
                    filter[key] = this.params[key]
                }
                //Guardar parámetros en un nuevo filtro guardado
                this.savedFilters.push({
                    name: this.nameInput,
                    data: filter,
                })
                localStorage.setItem(this.store, JSON.stringify(this.savedFilters))
                //Establecer el filtro
                this.setFilter(this.savedFilters.length - 1)
            }
        },
        /**
         * Elimina un filtro de la lista de filtros guardados
         * @param {number} index 
         */
        removeFilter(index) {
            //Eliminar el filtro
            this.savedFilters.splice(index, 1)
            localStorage.setItem(this.store, JSON.stringify(this.savedFilters))
            //Comprobar si el filtro eliminado estaba establecido en el formulario 
            if (this.selected.index == index) {
                //Limpiar el formulario
                this.clean()
            }
        },
        /**
         * Elimina todos los filtros guardados
         */
        removeAllFilters() {
            this.savedFilters = []
            localStorage.setItem(this.store, JSON.stringify(this.savedFilters))
            this.clean()
        },
        /**
         * Limpiar el formulario
         */
        clean() {
            this.selected.index = null
            this.selected.edit = false
            this.nameInput = ""
        },
    },
}
