<script>
    import Request from "../../Request.js"
    import Modal from "../native/modal/Modal.js"
    import ModalInput from "../native/modal/ModalInput.js"
    import BasicMixin from "../../mixins/Basic.js"
    import Column from "../native/Column.js"
    import Action from "../native/action-buttons/Action.js"
    import ApiAction from "../native/table/ApiAction.js"

    import WorkshopForm from "./WorkshopForm.vue"

    export default {
        mixins: [BasicMixin],
        components: { WorkshopForm },
        data() {
            return {
                title: "Taller",
                api: {
                    index: new ApiAction({
                        url: "api/repairs",
                    }),
                    store: new ApiAction({
                        url: "api/repairs",
                        message: () => {
                            return "El equipo fue creado correctamente"
                        },
                    }),
                    update: new ApiAction({
                        type: "post",
                        url: (id, item) => {
                            return `api/repairs/${id}`
                        },
                        message: () => {
                            return "Los datos del equipo fueron actualizados correctamente"
                        },
                    }),
                    destroy: new ApiAction({
                        url: "api/repairs",
                        message: (ids) => {
                            return ids.length == 1 ? "El equipo fue eliminado correctamente" : "Los equipos seleccionados fueron eliminados correctamente"
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
                        event: "ready",
                        name: "Listo pata recoger",
                        icon: "bi bi-check-circle",
                    }),
                    new Action({
                        event: "state",
                        name: "Actualizar estado",
                        icon: "bi bi-wrench-adjustable",
                        single: true,
                    }),
                ],
                columns: {
                    name: new Column({
                        id: "name",
                        type: "text",
                        name: "Equipo",
                        icon: "bi bi-laptop-fill",
                    }),
                    reference: new Column({
                        id: "reference",
                        type: "number",
                        name: "Id de referencia",
                        icon: "bi bi-search-heart-fill",
                    }),
                    contact: new Column({
                        id: "contact",
                        type: "text",
                        name: "Contacto",
                        icon: "bi bi-phone-vibrate-fill",
                    }),
                    price: new Column({
                        id: "price",
                        type: "range",
                        name: "Precio",
                        icon: "bi bi-cash-coin",
                        visible: true,
                        html(item) {
                            return item.price
                        },
                    }),
                    payType: new Column({
                        id: "payType",
                        type: "radio",
                        name: "Tipo de pago",
                        icon: "bi bi-credit-card-fill",
                        options: [
                            { label: "Efectivo", value: "Efectivo" },
                            { label: "Paypal", value: "Paypal" },
                            { label: "Mercado Pago", value: "Mercado Pago" },
                            { label: "Stripe", value: "Stripe" },
                        ],
                    }),
                    state: new Column({
                        id: "state",
                        type: "text",
                        name: "Estado",
                        classes: "text-center",
                        icon: "bi bi-wrench-adjustable",
                        html(item) {
                            if (item.state == "Listo para recoger") {
                                return '<span class="badge bg-success">Listo para recoger</span>'
                            } else {
                                const start = new Date(item.created_at)
                                const today = new Date()
                                const end = new Date(item.finished)
                                const progress = ((today - start) * 100) / (end - start)
                                return `
                                ${item.state}<div class="progress" style="height: .2rem;">
                                    <div class="progress-bar" role="progressbar" style="width: ${progress}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>`
                            }
                        },
                    }),
                    finished: new Column({
                        id: "finished",
                        type: "datetime",
                        name: "Fecha de recogida",
                        icon: "bi bi-calendar-event-fill",
                        html: (item) => {
                            return this.Utils.localeDateTimeString(item.finished)
                        },
                    }),
                    tags: new Column({
                        id: "tags",
                        type: "tags",
                        name: "Etiquetas",
                        icon: "bi bi-tags",
                        visible: false,
                        content: (item) => {
                            return item.tags.join(",")
                        },
                        html(item) {
                            let result = ""
                            for (let tag of item.tags) {
                                result += `<span class="badge bg-secondary me-1">${tag}</span>`
                            }
                            return result
                        },
                    }),
                },
            }
        },
        methods: {
            onstate(item) {
                const modal = new Modal({
                    background: "blue",
                    icon: "bi bi-tools",
                    inputs: [
                        new ModalInput({
                            type: "text",
                            label: "Estado del equipo",
                            placeholder: "Escribe el nuevo estado del equipo",
                            name: "state",
                        }),
                    ],
                })
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        result.data.append("_method", "put")
                        Request.post(`api/repairs/${item.id}/state`, result.data, () => {
                            this.$refs.table.onupdated([item.id], { state: result.data.get("state") }, "Se ha actualizado el estado del equipo")
                        })
                    }
                })
            },
            onready(ids) {
                const data = new FormData()
                data.append("_method", "put")
                data.append("ids", ids)
                Request.post("api/repairs/ready", data).then(() => {
                    const message = ids.length == 1 ? "El equipo está listo para recoger ahora" : "Los equipos están listos para recoger ahora"
                    this.$refs.table.onupdated(ids, { state: "Listo para recoger" }, message)
                })
            },
        },
    }
</script>

<template>
    <Carousel ref="carousel" :title="title" :windows="windows">
        <template #content="content">
            <div class="carousel-item" style="padding-top: 2.5rem">
                <WorkshopForm @submit="onsubmit" :payTypes="columns.payType.options" />
            </div>
            <div class="carousel-item active">
                <CustomTable ref="table" @edit="onedit" @ready="onready" @state="onstate" id="workshop" :actions="actions" :config="config" :api="api" :columns="columns" />
            </div>
            <div class="carousel-item" style="padding-top: 2.5rem">
                <WorkshopForm @submit="onsubmit" :payTypes="columns.payType.options" :item="updating" />
            </div>
        </template>
    </Carousel>
</template>
