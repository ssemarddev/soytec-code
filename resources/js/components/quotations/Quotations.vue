<script>
    import jsPDF from "jspdf"
    import autoTable from "jspdf-autotable"

    import Modal from "../native/modal/Modal.js"
    import ModalButton from "../native/modal/ModalButton.js"
    import Column from "../native/Column.js"
    import Action from "../native/action-buttons/Action.js"
    import ApiAction from "../native/table/ApiAction.js"

    import BasicMixin from "../../mixins/Basic.js"

    import QuotationForm from "./QuotationForm.vue"
    import QuotationModal from "./Modal.vue"

    import Utils from "../../Utils.js"

    export default {
        mixins: [BasicMixin],
        components: { QuotationForm },
        data() {
            return {
                api: {
                    index: new ApiAction({
                        url: "api/quotations",
                    }),
                    store: new ApiAction({
                        url: "api/quotations",
                        message: () => {
                            return "La cotización fue creada correctamente"
                        },
                    }),
                    update: new ApiAction({
                        type: "post",
                        url: (id, item) => {
                            return `api/quotations/${id}`
                        },
                        message: () => {
                            return "La cotización fue actualizada correctamente"
                        },
                    }),
                    destroy: new ApiAction({
                        url: "api/quotations",
                        message: (ids) => {
                            return ids.length == 1 ? "La cotización fue eliminada correctamente" : "Las cotizaciones seleccionadas fueron eliminadas correctamente"
                        },
                    }),
                },
                actions: [
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
                        event: "report",
                        name: "Crear reporte",
                        icon: "bi bi-file-earmark-pdf",
                        single: true,
                    }),
                    new Action({
                        event: "details",
                        name: "Ver detalles",
                        icon: "bi bi-info-circle",
                        single: true,
                    }),
                ],
                columns: {
                    client: new Column({
                        id: "client",
                        type: "text",
                        name: "Cliente",
                        icon: "bi bi-person-circle",
                        content(item) {
                            return `${item.client.name} ${item.client.lastName}`
                        },
                        html(item) {
                            return `<img src="${item.client.avatar}" /> ${item.client.name} ${item.client.lastName}`
                        },
                    }),
                    name: new Column({
                        id: "name",
                        type: "text",
                        name: "Nombre",
                        icon: "bi bi-calculator",
                    }),
                    description: new Column({
                        id: "description",
                        type: "text",
                        name: "Descripción",
                        icon: "bi bi-receipt",
                    }),
                    services: new Column({
                        id: "services",
                        type: "text",
                        name: "Servicios",
                        icon: "bi bi-tools",
                        content(item) {
                            let result = []
                            for (let service of item.services) {
                                result.push(service.name)
                            }
                            return result.join("\n")
                        },
                        html(item) {
                            let code = ""
                            for (let i in item.services) {
                                const service = item.services[i]
                                const num = Number(i) + 1
                                code += `<p class="mb-1" data-bs-toggle="tooltip" title="${service.description}">${num}: ${service.name}</p>`
                            }
                            return code
                        },
                    }),
                    created_at: new Column({
                        id: "created_at",
                        type: "date",
                        name: "Fecha de creación",
                        icon: "bi bi-calendar",
                        content(item) {
                            return Utils.localeDateString(item.created_at)
                        },
                        html(item) {
                            return Utils.localeDateString(item.created_at)
                        },
                    }),
                },
            }
        },
        methods: {
            onreport(item, print) {
                //Crear un documento
                const doc = new jsPDF()
                //Título
                doc.setFontSize(18)
                doc.setFont("arial", "normal", 400)
                doc.text(`Cotización para: ${item.name}`, 14, 25)
                //Descripción
                doc.setFontSize(11)
                doc.setTextColor(100)
                const size = doc.internal.pageSize
                var width = size.width ? size.width : size.getWidth()
                doc.setFont("Helvetica", "normal", 400)
                doc.text(item.description, 14, 31, { align: "justify", lineHeightFactor: 1.5, maxWidth: 180 })
                //Cliente
                doc.setFontSize(14)
                doc.setTextColor("#000000")
                doc.setFont("arial", "normal", 700)
                doc.text("Cliente: ", 14, 48)
                doc.setFont("arial", "normal", 400)
                doc.text(`${item.client.name} ${item.client.lastName}`, 33, 48)
                doc.setFont("Helvetica", "normal", 400)
                doc.setTextColor(100)
                doc.setFontSize(11)
                //Servicios
                doc.text("Servicios: ", 14, 53)
                const services = []
                let totalTime = 0
                let totalPrice = 0
                for (let service of item.services) {
                    const row = []
                    row.push(service.name)
                    row.push(service.description)
                    row.push(Utils.timeToString(service.time))
                    row.push(service.cost)
                    services.push(row)
                    totalTime += service.time
                    totalPrice += Number(service.cost)
                }
                //Crear la tabla
                autoTable(doc, {
                    startY: 56,
                    head: [["Nombre", "Descripción", "Tiempo", "Costo"]],
                    body: services,
                })
                //Footer
                doc.setFont("arial", "normal", 700)
                doc.text("Tiempo total: ", 14, doc.lastAutoTable.finalY + 10)
                doc.setFont("arial", "normal", 400)
                doc.text(Utils.timeToString(totalTime), 38, doc.lastAutoTable.finalY + 10)
                doc.setFont("arial", "normal", 700)
                doc.text("Precio total: ", 120, doc.lastAutoTable.finalY + 10)
                doc.setFont("arial", "normal", 400)
                doc.text(`${totalPrice.toFixed(2)}`, 145, doc.lastAutoTable.finalY + 10)
                //Guardar o imprimir reporte
                const name = `Cotización - ${item.name}.pdf`
                if (print == undefined) {
                    doc.save(name)
                } else {
                    //Si es imprimir se guarda y se abre en una nueva ventana para imprimir
                    doc.autoPrint()
                    doc.output("dataurlnewwindow", { filename: name })
                }
            },
            ondetails(item) {
                const modal = new Modal(
                    {
                        window: item.name,
                        accept: new ModalButton({
                            text: "Imprimir",
                            icon: "bi bi-printer",
                            classes: "btn-success",
                        }),
                        cancel: new ModalButton({
                            text: "Cerrar",
                            icon: "bi bi-x-circle",
                            classes: "btn-secondary",
                        }),
                        close: new ModalButton({}),
                    },
                    QuotationModal,
                    [{ quotation: item }]
                )
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        this.onreport(item, true)
                    }
                })
            },
        },
    }
</script>

<template>
    <Carousel title="Cotizaciones" ref="carousel" :windows="windows">
        <template #content="content">
            <div class="carousel-item" style="padding-top: 2.5rem">
                <QuotationForm @submit="onsubmit" />
            </div>
            <div class="carousel-item active">
                <CustomTable ref="table" id="quotations" @details="ondetails" @report="onreport" @edit="onedit" :config="config" :api="api" :columns="columns" :actions="actions" />
            </div>
            <div class="carousel-item" style="padding-top: 2.5rem">
                <QuotationForm @submit="onsubmit" :item="updating" />
            </div>
        </template>
    </Carousel>
</template>
