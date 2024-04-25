<script>
    import Request from "../../Request.js"
    import BasicMixin from "../../mixins/Basic.js"
    import Column from "../native/Column.js"
    import Action from "../native/action-buttons/Action.js"
    import ApiAction from "../native/table/ApiAction.js"
    import CarouselPage from "../native/carousel/CarouselPage.js"

    import Utils from "../../Utils.js"

    export default {
        mixins: [BasicMixin],
        data() {
            return {
                title: "Ventas",
                api: {
                    index: new ApiAction({
                        url: "api/sales",
                    }),
                    destroy: new ApiAction({
                        url: "api/sales",
                        message: (ids) => {
                            return ids.length == 1 ? "La vbenta fue eliminada del registro correctamente" : "Las ventas seleccionadas fueron eliminadas del registro correctamente"
                        },
                    }),
                },
                actions: [
                    new Action({
                        event: "remove",
                        name: "Eliminar",
                        icon: "bi bi-trash-fill",
                    }),
                    new Action({
                        event: "delivered",
                        name: "Entregado",
                        icon: "bi bi-toggle2-off",
                    }),
                    new Action({
                        event: "undelivered",
                        name: "Por entregar",
                        icon: "bi bi-toggle2-on",
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
                    price: new Column({
                        id: "price",
                        type: "text",
                        name: "Precio + impuesto",
                        icon: "bi bi-cash",
                        classes: "text-center",
                        content(item) {
                            return `${item.price} + ${item.tax}`
                        },
                        html(item) {
                            return `${item.price} + ${item.tax}`
                        },
                    }),
                    total: new Column({
                        id: "total",
                        type: "range",
                        name: "Total",
                        icon: "bi bi-cash-coin",
                        classes: "text-center",
                    }),
                    payType: new Column({
                        id: "payType",
                        type: "radio",
                        name: "Tipo de pago",
                        icon: "bi bi-credit-card-fill",
                        options: [
                            { value: "Efectivo", label: "Efectivo" },
                            { value: "Paypal", label: "Paypal" },
                            { value: "Mercado Pago", label: "Mercado Pago" },
                            { value: "Stripe", label: "Stripe" },
                        ],
                    }),
                    created_at: new Column({
                        id: "created_at",
                        type: "date",
                        name: "Fecha de venta",
                        icon: "bi bi-calendar-day",
                        classes: "text-center",
                        content(item) {
                            return Utils.localeDateTimeString(item.created_at)
                        },
                        html(item) {
                            return Utils.localeDateTimeString(item.created_at)
                        },
                    }),
                    state: new Column({
                        id: "state",
                        type: "radio",
                        name: "Estado",
                        icon: "bi bi-toggles",
                        classes: "text-center",
                        options: [
                            { value: "Entregado", label: "Entregado" },
                            { value: "Por entregar", label: "Por entregar" },
                        ],
                        html(item) {
                            if (item.state == "Entregado") {
                                return '<span class="badge bg-success">Entregado</span>'
                            } else {
                                return '<span class="badge bg-danger">Por entregar</span>'
                            }
                        },
                    }),
                },
                windows: [
                    new CarouselPage({
                        id: "list",
                        name: "Ventas realizadas",
                        active: true,
                    }),
                ],
            }
        },
        methods: {
            ondelivered(ids) {
                const data = new FormData()
                data.append("_method", "put")
                data.append("ids", ids)
                Request.post("api/sales/delivered", data).then(() => {
                    const message = ids.length == 1 ? "El registro está entregado ahora" : "Los registros están entregados ahora"
                    this.$refs.table.onupdated(ids, { state: "Entregado" }, message)
                })
            },
            onundelivered(ids) {
                const data = new FormData()
                data.append("_method", "put")
                data.append("ids", ids)
                Request.post("api/sales/undelivered", data).then(() => {
                    const message = ids.length == 1 ? "El registro está por entregar ahora" : "Los registros están por entregar ahora"
                    this.$refs.table.onupdated(ids, { state: "Por entregar" }, message)
                })
            },
        },
    }
</script>

<template>
    <Carousel ref="carousel" :title="title" :windows="windows">
        <template #content="content">
            <div class="carousel-item active">
                <CustomTable ref="table" @delivered="ondelivered" @undelivered="onundelivered" id="sales" :config="config" :api="api" :columns="columns" :actions="actions" />
            </div>
        </template>
    </Carousel>
</template>
