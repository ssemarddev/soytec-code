import { computed } from "vue"
import string from "lodash/string"

import Request from "../../../Request.js"
import Selection from "../Selection.js"
import Action from "../action-buttons/Action.js"

export default {
    /**
     * @inject title
     */
    inject: ["title"],
    props: {
        /**
         * Id de la tabla
         */
        id: String,
        /**
         * Configuración de la tabla
         */
        config: Object,
        /**
         * Datos de la API para las acciones frecuentes sobre la tabla
         */
        api: Object,
        /**
         * Columnas de la tabla
         */
        columns: Object,
        /**
         * Acciones sobre las filas de la tabla
         */
        actions: {
            type: Array,
            default: [
                new Action({
                    event: "edit",
                    name: "Editar",
                    icon: "bi bi-pencil-square",
                    single: true,
                }),
                new Action({
                    event: "remove",
                    name: "Eliminar",
                    icon: "bi bi-trash-fill",
                }),
                new Action({
                    event: "state",
                    name: "Inactivar",
                    icon: "bi bi-toggle2-off",
                }),
            ],
        },
    },
    data() {
        return {
            /**
             * Datos de las filas de la tabla
             * @type {Array<Object>}
             */
            data: [],
            /**
             * Backup de los datos de las filas de la tabla
             * @type {Array<Object>}
             */
            backup: [],
            /**
             * Filas seleccionadas
             * @type {Selection}
             */
            selection: new Selection(),
            /**
             * <code>true</code> si los datos ya fueron cargados o <code>false</code> si aún se está procesando la petición http
             * @type {boolean}
             */
            loaded: false,
        }
    },
    computed: {
        /**
         * Datos de las filas de la página que se está visualizando
         * @type {Array<Object>}
         */
        items() {
            //Mostrar las filas a partir de este índice mínimo
            const min = this.config.rows * this.config.page
            //Mostrar las filas hasta este índice máximo
            const max = min + this.config.rows
            const items = []
            for (let i = min; i < max; i++) {
                if (i < this.data.length) {
                    items.push(this.data[i])
                } else {
                    break
                }
            }
            return items
        },
        /**
         * Páginas de la tabla
         * @type {Array<Number>}
         */
        pages() {
            const length = Math.ceil(this.data.length / this.config.rows)
            const pages = []
            for (let i = 0; i < length; i++) {
                pages.push(i + 1)
            }
            return pages
        },
        /**
         * <code>true</code> si todas las filas de la página que se está mostrando están seleccionadas o <code>false</code> si no
         * @type boolean
         */
        checked() {
            return this.selection.contains(this.items)
        },
    },
    methods: {
        /**
         * Alterar estado del checked de todas las filas de la página que se está visualizando
         * @param {Event} e Evento del DOM que disparó este método
         */
        toogleAll(e) {
            this.selection.toogle(this.items, e.target.checked)
        },
        /**
         * Agregar o actualizar un registro en la base de datos
         * @param {String} id Id de la fila a actualizar o <code>null</code>
         * @return {Promise} Una promesa que se resuelve cuando se reciba el resultado de la operación en el backend
         */
        onsubmit({ id, data }) {
            return new Promise((resolve) => {
                if (id == null) {
                    //Crear un nuevo registro
                    Request.post(this.api.store.url, data).then((response) => {
                        this.oncreated(response.data, this.api.store.message(response.data))
                        resolve()
                    })
                } else {
                    //Actualizar un un registro existente
                    Request.post(this.api.update.url(id, data), data).then((response) => {
                        this.onupdated([id], response.data, this.api.update.message(response.data))
                        resolve()
                    })
                }
            })
        },
        /**
         * Eliminar registros de la base de datos
         * @param {Array} ids Ids de los registros a eliminar
         * @return {Promise} Una promesa que se resuelve cuando se reciba el resultado de la operación en el backend
         */
        onremove(ids) {
            const data = new FormData()
            data.append("ids", ids)
            return new Promise((resolve) => {
                Request.delete(this.api.destroy.url, data).then(() => {
                    this.onremoved(ids, this.api.destroy.message(ids))
                    resolve(ids)
                })
            })
        },
        /**
         * Actualizar el estado de múltiples registros en la base de datos
         * @param {Array} ids Ids de los registros a actualizar
         */
        onstate(ids) {
            const data = new FormData()
            data.append("_method", "put")
            data.append("ids", ids)
            Request.post(this.api.state.url, data).then(() => {
                this.onupdated(ids, { state: "Inactiva" }, this.api.state.message(ids))
            })
        },
        /**
         * Carga los datos de la tabla desde la API
         */
        load() {
            this.loaded = false
            Request.get(this.api.index.url)
                .then((response) => {
                    this.data = response.data.slice()
                    this.backup = response.data.slice()
                    this.loaded = true
                })
                .catch((error) => {
                    if (error.request.status == 403) this.loaded = 401
                    else this.loaded = false
                })
        },
    },
    provide() {
        return {
            /**
             * Id de la tabla
             * @type {String}
             */
            id: this.id,
            /**
             * Columnas de la tabla
             * @type {Array<Column>}
             */
            columns: this.columns,
            /**
             * Acciones sobre las filas
             * @type {Array<Action>}
             */
            actions: this.actions,
            /**
             * Filas seleccionadas
             * @type {Selection}
             */
            selection: this.selection,
            /**
             * Configuración de la tabla
             * @type {Object}
             */
            config: this.config,
            /**
             * <code>true</code> si los datos ya fueron cargados o <code>false</code> si aún se está procesando la petición http
             * @type {boolean}
             */
            loaded: computed(() => this.loaded),
            /**
             * Datos de las filas de la tabla
             * @type {Array<Object>}
             */
            data: computed(() => this.data),
            /**
             * Backup de los datos de las filas de la tabla
             * @type {boolean}
             */
            backup: computed(() => this.backup),
            /**
             * Datos de las filas de la página que se está visualizando
             * @type {Array<Object>}
             */
            items: computed(() => this.items),
            /**
             * Páginas de la tabla
             * @type {Array<number>}
             */
            pages: computed(() => this.pages),
        }
    },
    //Lifecycle Hooks
    created() {
        this.load()
    },
    mounted() {
        //Agregar escuchadores de eventos
        const events = ["edit", "remove", "state"]
        for (let event in this.$attrs) {
            if (event.substring(0, 2) == "on") {
                const name = string.kebabCase(event).substring(3)
                this.emitter.on(`${this.id}-${name}`, this.$attrs[event])
                const index = events.indexOf(name)
                if (index >= 0) events.splice(index, 1)
            }
        }
        for (let event of events) {
            this.emitter.on(`${this.id}-${event}`, this[`on${event}`])
        }
        this.emitter.on(`${this.id}-filter`, (data) => {
            this.data = data
            this.change = false
        })
        this.emitter.on(`${this.id}-invalidate-cache`, () => {
            this.load()
        })
    },
}
