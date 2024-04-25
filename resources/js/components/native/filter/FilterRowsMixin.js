import Dropdown from "bootstrap/js/dist/dropdown"
import Cell from "./Cell.js"

import TextFilter from "./filters-type/TextFilter.vue"
import RadioFilter from "./filters-type/RadioFilter.vue"
import SelectFilter from "./filters-type/SelectFilter.vue"
import DateFilter from "./filters-type/DateFilter.vue"
import RangeFilter from "./filters-type/RangeFilter.vue"
import TagFilter from "./filters-type/TagFilter.vue"
import SavedFilters from "./SavedFilters.vue"

export default {
    /**
     * @inject backup: CustomTable
     * @inject columns: CustomTable
     * @inject config: CustomTable
     * @inject data: CustomTable
     * @inject id: CustomTable
     */
    inject: ["backup", "columns", "config", "data", "id"],
    components: { TextFilter, RadioFilter, SelectFilter, DateFilter, RangeFilter, TagFilter, SavedFilters },
    /**
     * @emit reset: Se llama cada vez que se limpia el formulario de búsqueda
     * @emit filter: Se llama cada vez que se actualizan los parámetros de búsqueda
     * - @param {Array<Object>} matched Filas que coinciden con los parámetros de búsqueda
     */
    emits: ["reset"],
    data() {
        return {
            /**
             * Un objeto plano cuyas propiedades son los nombres de los parámetros de búsqueda en el formulario y sus valores
             * los datos introducidos por los usuarios en los diferentes campos del formulario
             * @member
             */
            params: {},
            /**
             * <code>true</code> si el switch "Distinguir entre mayúsculas y minúsculas" está activado o <code>false</code> si no
             * está activado
             * @member
             */
            sensible: false,
        }
    },
    methods: {
        /**
         * Filtra los datos de cada fila según los datos introducidos en el formulario de búsqueda
         * @event filter
         */
        filter() {
            const matched = this.backup.filter((row) => {
                //Iterar sobre todos los parámetros de búsqueda
                for (let key in this.params) {
                    //Obtener la columna del parámetro actual
                    const column = this.columns[key]
                    //Obtener el contenido de la columna (en minúscula todo si la búsqueda no es sensible a mayúsuculas y minúsculas)
                    const value = this.sensible ? column.content(row).toString() : column.content(row).toString().toLowerCase()
                    //Instanciar la celda
                    const cell = new Cell(column, value)
                    //Retornar false si no se encuentra el parámetro de búsqueda en la celda
                    if (!cell.filter(this.params[key], this.sensible)) return false
                }
                //Retornar true si se encontraron los parámetros de búsqueda en la fila
                return true
            })
            //Emitir evento
            this.emitter.emit(`${this.id}-filter`, matched)
        },
        /**
         * Limpia el formulario de filtrado
         * @event filter
         */
        reset() {
            //Emitir evento
            this.emitter.emit(`${this.id}-filter`, this.backup)
            //Limpiar parámetros de búsqueda
            this.params = {}
        },
        /**
         * Establece un filtro previamente guardado en el formulario
         * @param {Object} data Datos de los parámetros de búsqueda del filtro guardados
         */
        setFilter(data) {
            this.params = {}
            for (let key in data) {
                this.params[key] = data[key]
            }
            this.filter()
        },
    },
    mounted() {
        //Impedir que el menú del dropdown se cierre cuando se pierda el foco en el botón
        const dropdown = this.$el.querySelector("form > [data-bs-toggle=dropdown]")
        new Dropdown(dropdown, {
            autoClose: false,
        })
        //Añadir eventos para evitar que se oculte parte del formulario de búsqueda si el tamaño de la tabla es más pequeño que el alto del formulario de búsqueda
        dropdown.addEventListener("shown.bs.dropdown", () => {
            document.querySelector(".carousel-inner").style.overflow = "visible"
        })
        dropdown.addEventListener("hidden.bs.dropdown", () => {
            document.querySelector(".carousel-inner").style.overflow = "hidden"
        })
        this.filter()
        //Añadir escuchador para cuando cambian los datos de la tabla
        this.emitter.on(`${this.id}-data-change`, () => {
            this.filter()
        })
    },
}
