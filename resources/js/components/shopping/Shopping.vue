<script>
    import BasicMixin from "../../mixins/Basic.js"
    import Column from "../native/Column.js"
    import Action from "../native/action-buttons/Action.js"
    import ApiAction from "../native/table/ApiAction.js"

    import Utils from "../../Utils.js"

    import ShoppingForm from "./ShoppingForm.vue"

    export default {
        mixins: [BasicMixin],
        components: { ShoppingForm },
        data() {
            return {
                api: {
                    index: new ApiAction({
                        url: "api/shopping",
                    }),
                    store: new ApiAction({
                        url: "api/shopping",
                        message: () => {
                            return "La entrada fue creada correctamente"
                        },
                    }),
                    destroy: new ApiAction({
                        url: "api/shopping",
                        message: (ids) => {
                            return ids.length == 1 ? "La entrada fue eliminada correctamente" : "Las entradas seleccionadas fueron eliminadas correctamente"
                        },
                    }),
                },
                actions: [
                    new Action({
                        event: "remove",
                        name: "Eliminar",
                        icon: "bi bi-trash-fill",
                    }),
                ],
                columns: {
                    piece: new Column({
                        id: "piece",
                        type: "text",
                        name: "Pieza o herramienta",
                        icon: "bi bi-person-wrench",
                        content(item) {
                            return `${item.piece.name} (${item.piece.model})`
                        },
                        html(item) {
                            return `${item.piece.name} (${item.piece.model})`
                        },
                    }),
                    user: new Column({
                        id: "user",
                        type: "text",
                        name: "Administrador",
                        icon: "bi bi-person-circle",
                        content(item) {
                            return `${item.user.name} ${item.user.lastName}`
                        },
                        html(item) {
                            return `<img src="src/img/avatars/${item.user.avatar}" />${item.user.name} ${item.user.lastName}`
                        },
                    }),
                    provider: new Column({
                        id: "provider",
                        type: "text",
                        name: "Proveedor",
                        icon: "bi bi-building",
                        content(item) {
                            return item.provider.name
                        },
                        html(item) {
                            return item.provider.name
                        },
                    }),
                    quantity: new Column({
                        id: "quantity",
                        type: "text",
                        name: "Cantidad",
                        icon: "bi bi-boxes",
                        classes: "text-center",
                        content: (item) => {
                            return `${item.quantity} ${item.piece.unit}`
                        },
                        html(item) {
                            return `${item.quantity} ${item.piece.unit}`
                        },
                    }),
                    cost: new Column({
                        id: "cost",
                        type: "range",
                        name: "Costo",
                        icon: "bi bi-cash-stack",
                        classes: "text-center",
                    }),
                    created_at: new Column({
                        id: "created_at",
                        type: "date",
                        name: "Fecha de compra",
                        icon: "bi bi-calendar-day",
                        classes: "text-center",
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
            onsubmit(data) {
                this.$refs.table.onsubmit(data).then(() => {
                    this.$refs.carousel.goPageById("list")
                    this.emitter.emit(`inventory-invalidate-cache`)
                })
            },
            onremove(ids) {
                this.$refs.table.onremove(ids).then(() => {
                    this.emitter.emit(`inventory-invalidate-cache`)
                })
            },
        },
    }
</script>

<template>
    <Carousel title="Compras realizadas" ref="carousel" :windows="windows">
        <template #content="content">
            <div class="carousel-item" style="padding-top: 2.5rem">
                <ShoppingForm @submit="onsubmit" :columns="columns" />
            </div>
            <div class="carousel-item active">
                <CustomTable @edit="onedit" @remove="onremove" ref="table" id="shopping" :config="config" :api="api" :columns="columns" :actions="actions" />
            </div>
            <div class="carousel-item" style="padding-top: 2.5rem"></div>
        </template>
    </Carousel>
</template>
