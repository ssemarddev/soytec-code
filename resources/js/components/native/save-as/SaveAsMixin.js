import Dropdown from "bootstrap/js/dist/dropdown"
import * as XLSX from "xlsx"
import jsPDF from "jspdf"
import autoTable from "jspdf-autotable"

import Modal from "../modal/Modal.js"
import ModalButton from "../modal/ModalButton.js"

export default {
    /**
     * @inject columns: CustomTable
     * @inject selection: CustomTable
     * @inject data: CustomTable
     * @inject title: CustomTable
     */
    inject: ["columns", "selection", "data", "title"],
    methods: {
        /**
         * Guardar un reporte de los datos de la tabla
         * @param {String} extension Extensión del archivo (usar "print" para mandar a imprimir el reporte)
         */
        save(extension) {
            this.question(extension).then((selectedOnly) => {
                switch (extension) {
                    case "xlsx":
                    case "csv":
                    case "txt":
                    case "html":
                        this.xlsxProccess(extension, selectedOnly)
                        break
                    case "pdf":
                    case "print":
                        this.jsPDFProccess(extension, selectedOnly)
                        break
                }
            })
        },
        /**
         *
         * @param {String} extension Extensión del archivo
         * @return {Promise} Retorna una promesa que se resuleve cuando se presiona el botón de aceptar del modal
         */
        question(extension) {
            const question = extension == "print" ? "¿Seguro que quieres imprimir un reporte?" : "¿Seguro que quieres crear un reporte?"
            //Configurar el modal
            const modal = new Modal({
                title: "Confirmar operación",
                background: "#0d6efd",
                icon: "bi bi-patch-question",
                description: question,
                inputs: [
                    {
                        type: "checkbox",
                        label: "Exportar solo los registros seleccionados",
                        name: "all",
                        value: true,
                        checked: false,
                    },
                ],
                accept: new ModalButton({
                    classes: "btn-success",
                }),
            })
            return new Promise((resolve) => {
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        resolve(result.data.get("all"))
                    }
                })
            })
        },
        /**
         * Guardar reportes de tabla en xlsx, html, csv, txt
         * @param {String} extension Extensión del archivo
         * @param {boolean} selectedOnly <code>true</code> si solo se exportarán las filas seleccionadas o <code>false</false> si se exportarán todas las filas
         */
        xlsxProccess(extension, selectedOnly) {
            //Obtener nombre del reporte
            const name = this.getFileName(extension)
            //Crear un libro
            const wb = XLSX.utils.book_new()
            //Añadir hoja
            wb.SheetNames.push("Hoja uno")
            //Agregar los datos
            const ws = XLSX.utils.aoa_to_sheet(this.getBody(selectedOnly))
            //Agregar la hoja al libro
            wb.Sheets["Hoja uno"] = ws
            //Guardar y mandar para descargar el libro
            XLSX.writeFile(wb, name, { bookType: extension })
        },
        /**
         * Guardar reportes de tabla en PDF o mandarlo a imprimir
         * @param {String} extension Extensión del archivo
         * @param {boolean} selectedOnly <code>true</code> si solo se exportarán las filas seleccionadas o <code>false</false> si se exportarán todas las filas
         */
        jsPDFProccess(extension, selectedOnly) {
            //Obtener nombre del reporte
            const name = this.getFileName(extension)
            //Crear un documento
            const doc = new jsPDF()
            //Llamar al plugin de autotable
            const data = this.getBody(selectedOnly)
            autoTable(doc, {
                head: data.slice(0, 1),
                body: data.slice(1),
            })
            //Si no es imprimir se descarga el archivo
            if (extension == "pdf") {
                doc.save(name)
            } else {
                //Si es imprimir se guarda y se abre en una nueva ventana para imprimir
                doc.autoPrint()
                doc.output("dataurlnewwindow", { filename: name.replace(".print", "") })
            }
        },
        /**
         * Obtener los datos de las filas que se van a exportar
         * @param {boolean} selectedOnly 
         * @return {Array<String>} datos de las filas a guardar
         */
        getBody(selectedOnly) {
            const data = []
            //Obtener los encabezados de las columnas
            data.push(this.getHead())
            for (let item of this.data) {
                //Comprobar si la fila está seleccionada
                const selected = this.selection.contains([item])
                //Si la fila está seleccionada o se exportarán todas las filas añadir los datos de la fila actual a la lista de filas que se guardarán
                if (!selectedOnly || selected) {
                    const row = []
                    for (let key in this.columns) {
                        const column = this.columns[key]
                        if (column.visible) {
                            row.push(column.content(item))
                        }
                    }
                    data.push(row)
                }
            }
            return data
        },
        /**
         * Obtener encabezados de las columnas
         * @return {Array<String>} Nombres de las columnas visibles a exportar
         */
        getHead() {
            const row = []
            for (let key in this.columns) {
                const column = this.columns[key]
                //Comprobar si la columna está visible y añadirla a los encabezados
                if (column.visible) {
                    row.push(column.name)
                }
            }
            return row
        },
        /**
         * Obtener el nombre del archivo
         * @param {String} extension Extensión del archivo
         * @return {String} El nombre del archivo a guardar
         */
        getFileName(extension) {
            //Obtener fecha en español en formato "DD de Month del YYYY" (Ejemplo 12 de marzo del 2022)
            const date = new Date().toLocaleDateString("es-ES", {
                day: "numeric",
                year: "numeric",
                month: "long",
            })
            return `Reporte de ${this.title} (${date}).${extension}`
        },
    },
    mounted() {
        new Dropdown(this.$el.querySelector(".dropdown-toggle"))
    },
}
