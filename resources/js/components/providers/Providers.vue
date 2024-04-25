<script>
    import BasicMixin from "../../mixins/Basic.js"
    import Column from "../native/Column.js"
    import Action from "../native/action-buttons/Action.js"
    import ApiAction from "../native/table/ApiAction.js"

    import ProviderForm from "./ProviderForm.vue"

    export default {
        mixins: [BasicMixin],
        components: { ProviderForm },
        data() {
            return {
                api: {
                    index: new ApiAction({
                        url: "api/providers",
                    }),
                    store: new ApiAction({
                        url: "api/providers",
                        message: () => {
                            return "El proveedor fue creado correctamente"
                        },
                    }),
                    update: new ApiAction({
                        type: "post",
                        url: (id, item) => {
                            return `api/providers/${id}`
                        },
                        message: () => {
                            return "El proveedor fue actualizado correctamente"
                        },
                    }),
                    destroy: new ApiAction({
                        url: "api/providers",
                        message: (ids) => {
                            return ids.length == 1 ? "El proveedor fue eliminado correctamente" : "Los proveedores seleccionados fueron eliminados correctamente"
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
                        icon: "bi bi-building",
                    }),
                    address: new Column({
                        id: "address",
                        type: "text",
                        name: "Dirección postal",
                        icon: "bi bi-geo-alt-fill",
                    }),
                    email: new Column({
                        id: "email",
                        type: "email",
                        name: "Email",
                        icon: "bi bi-envelope",
                    }),
                    phone: new Column({
                        id: "phone",
                        type: "tel",
                        name: "Número de teléfono",
                        icon: "bi bi-telephone-fill",
                    }),
                    website: new Column({
                        id: "website",
                        type: "url",
                        name: "Página web",
                        icon: "bi bi-wifi",
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
    <Carousel title="Proveedores" ref="carousel" :windows="windows">
        <template #content="content">
            <div class="carousel-item" style="padding-top: 2.5rem">
                <ProviderForm @submit="onsubmit" :columns="columns" />
            </div>
            <div class="carousel-item active">
                <CustomTable @edit="onedit" ref="table" id="providers" :config="config" :api="api" :columns="columns" :actions="actions" />
            </div>
            <div class="carousel-item" style="padding-top: 2.5rem">
                <ProviderForm @submit="onsubmit" :item="updating" />
            </div>
        </template>
    </Carousel>
</template>
