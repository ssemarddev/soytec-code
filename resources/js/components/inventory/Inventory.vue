<script>
    import BasicMixin from "../../mixins/Basic.js"
    import Column from "../native/Column.js"
    import Action from "../native/action-buttons/Action.js"
    import ApiAction from "../native/table/ApiAction.js"

    import InventoryForm from "./InventoryForm.vue"

    export default {
        mixins: [BasicMixin],
        components: { InventoryForm },
        data() {
            return {
                api: {
                    index: new ApiAction({
                        url: "api/pieces",
                    }),
                    store: new ApiAction({
                        url: "api/pieces",
                        message: () => {
                            return "La entrada fue creada correctamente"
                        },
                    }),
                    update: new ApiAction({
                        type: "post",
                        url: (id, item) => {
                            return `api/pieces/${id}`
                        },
                        message: () => {
                            return "La entrada fue actualizada correctamente"
                        },
                    }),
                    destroy: new ApiAction({
                        url: "api/pieces",
                        message: (ids) => {
                            return ids.length == 1 ? "La entrada fue eliminada correctamente" : "Las entradas seleccionadas fueron eliminadas correctamente"
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
                ],
                columns: {
                    name: new Column({
                        id: "name",
                        type: "text",
                        name: "Nombre",
                        icon: "bi bi-cpu",
                    }),
                    model: new Column({
                        id: "model",
                        type: "text",
                        name: "Modelo",
                        icon: "bi bi-badge-tm",
                    }),
                    description: new Column({
                        id: "description",
                        type: "text",
                        name: "Descripcion",
                        icon: "bi bi-book-fill",
                    }),
                    stock: new Column({
                        id: "stock",
                        type: "text",
                        name: "Stock",
                        icon: "bi bi-boxes",
                        classes: "text-center",
                        content: (item) => {
                            return `${item.stock} (${item.unit})`
                        },
                        html(item) {
                            return `${item.stock} (${item.unit})`
                        },
                    }),
                    model: new Column({
                        id: "model",
                        type: "text",
                        name: "Modelo",
                        icon: "bi bi-badge-tm",
                    }),
                },
            }
        },
    }
</script>

<template>
    <Carousel title="Categorías" ref="carousel" :windows="windows">
        <template #content="content">
            <div class="carousel-item" style="padding-top: 2.5rem">
                <InventoryForm @submit="onsubmit" :columns="columns" />
            </div>
            <div class="carousel-item active">
                <CustomTable @edit="onedit" ref="table" id="inventory" :config="config" :api="api" :columns="columns" :actions="actions" />
            </div>
            <div class="carousel-item" style="padding-top: 2.5rem">
                <InventoryForm @submit="onsubmit" :item="updating" />
            </div>
        </template>
    </Carousel>
</template>
