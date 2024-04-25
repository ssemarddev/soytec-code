<script>
    import BasicMixin from "../../mixins/Basic.js"
    import Column from "../native/Column.js"

    import CategoryForm from "./CategoryForm.vue"
    import ApiAction from "../native/table/ApiAction.js"

    export default {
        mixins: [BasicMixin],
        components: { CategoryForm },
        data() {
            return {
                api: {
                    index: new ApiAction({
                        url: "api/categories",
                    }),
                    store: new ApiAction({
                        url: "api/categories",
                        message: () => {
                            return "La categoría fue creada correctamente"
                        },
                    }),
                    update: new ApiAction({
                        type: "post",
                        url: (id, item) => {
                            return `api/categories/${id}`
                        },
                        message: () => {
                            return "La categoría fue actualizada correctamente"
                        },
                    }),
                    destroy: new ApiAction({
                        url: "api/categories",
                        message: (ids) => {
                            return ids.length == 1 ? "La categoría fue eliminada correctamente" : "Las categorías seleccionadas fueron eliminadas correctamente"
                        },
                    }),
                    state: new ApiAction({
                        url: "api/categories/state",
                        message: (ids) => {
                            return ids.length == 1 ? "La categoría fue inactivada" : "Las categorías seleccionadas fueron inactivadas"
                        },
                    }),
                },
                columns: {
                    name: new Column({
                        id: "name",
                        type: "text",
                        name: "Nombre",
                        icon: "bi bi-tag-fill",
                    }),
                    description: new Column({
                        id: "description",
                        type: "text",
                        name: "Descripción",
                        icon: "bi bi-receipt",
                    }),
                    state: new Column({
                        id: "state",
                        type: "radio",
                        name: "Estado",
                        icon: "bi bi-toggles",
                        options: [
                            { value: "Activa", label: "Activa" },
                            { value: "Inactiva", label: "Inactiva" },
                        ],
                        classes: "text-center",
                        html(item) {
                            if (item.state == "Activa") {
                                return '<span class="badge bg-success">Activa</span>'
                            } else {
                                return '<span class="badge bg-danger">Inactiva</span>'
                            }
                        },
                    }),
                },
            }
        },
        mounted() {
            this.$emit("example")
        },
    }
</script>

<template>
    <Carousel title="Categorías" ref="carousel" :windows="windows">
        <template #content="content">
            <div class="carousel-item" style="padding-top: 2.5rem">
                <CategoryForm @submit="onsubmit" :columns="columns" />
            </div>
            <div class="carousel-item active">
                <CustomTable @edit="onedit" ref="table" id="categories" :config="config" :api="api" :columns="columns" />
            </div>
            <div class="carousel-item" style="padding-top: 2.5rem">
                <CategoryForm @submit="onsubmit" :item="updating" />
            </div>
        </template>
    </Carousel>
</template>
