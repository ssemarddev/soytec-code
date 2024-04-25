import Tooltip from "bootstrap/js/dist/tooltip"
import Modal from "../modal/Modal.js"
import ModalButton from "../modal/ModalButton.js"
import ModalInput from "../modal/ModalInput.js"
import Action from "./Action.js"

export default {
    /**
     * @inject actions: CustomTable
     * @inject items: CustomTable
     * @inject data: CustomTable
     * @inject selection: CustomTable
     * @inject id: CustomTable
     */
    inject: ["actions", "items", "data", "selection", "id"],
    methods: {
        /**
         * Dispara un evento cuando se presiona un botón de acción
         *
         * @param {Action} action: Acción que se disparó en el evento "onclick" deñ botón de acción
         * @event %dynamic%
         * - @param {Object|Array}: Datos de la fila sobre la que se llamó el evento si es una acción de un sola columna
         *                          o un Array con todos los ids de las filas seleccionadas sobre las que se llamó la acción
         */
        emit(action) {
            if (action.single) {
                for (let item of this.data) {
                    if (item.id == this.selection.ids[0]) {
                        this.emitter.emit(`${this.id}-${action.event}`, item)
                        break
                    }
                }
            } else {
                this.showConfirmModal().then((ids) => {
                    this.emitter.emit(`${this.id}-${action.event}`, ids)
                })
            }
        },
        /**
         * Muestra un modal de confirmación para confirmar o rechazar una acción sobre múltiples registros
         *
         * @return {Promise}: Retorna una promesa que se resuelve cuando se presiona Cancelar o Aceptar en el modal
         * - @param {Array}: Array con los ids de las filas seleccionadas de la página visible si se marca el CheckBox
         *                   o un Array con todos los ids de las filas seleccionadas
         */
        showConfirmModal() {
            const visibleSelection = this.selection.getSelectedIdsInArray(this.items)
            const modal = new Modal({
                title: "Confirmar operación",
                background: "#f55555",
                icon: "bi bi-exclamation-triangle",
                description: "¿Seguro que quieres realizar esta acción sobre múltiples registros?",
                inputs: [
                    new ModalInput({
                        type: "checkbox",
                        label: "Hacer esto solo para los registros de esta página",
                        name: "all",
                        value: true,
                        checked: visibleSelection.length >= this.selection.size(),
                    }),
                ],
                accept: new ModalButton({
                    classes: "btn-danger",
                }),
            })
            return new Promise((resolve) => {
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        if (result.data.get("all")) {
                            resolve(visibleSelection)
                        } else {
                            resolve(this.selection.ids)
                        }
                    }
                })
            })
        },
    },
    mounted() {
        this.$el.querySelectorAll("[data-bs-toggle=tooltip]").forEach((button) => {
            new Tooltip(button)
        })
    },
}
