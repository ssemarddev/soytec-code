<script>
    import BasicMixin from "../../mixins/Basic.js"
    import Request from "../../Request.js"
    import Column from "../native/Column.js"
    import Action from "../native/action-buttons/Action.js"
    import ApiAction from "../native/table/ApiAction.js"

    import ClientForm from "./ClientForm.vue"

    export default {
        mixins: [BasicMixin],
        components: { ClientForm },
        data() {
            return {
                title: "Clientes",
                item: {},
                config: {
                    rows: 10,
                    page: 0,
                },
                api: {
                    index: new ApiAction({
                        url: "api/clients",
                    }),
                    store: new ApiAction({
                        url: "api/clients",
                        message: (item) => {
                            return "El cliente ha sido registrado correctamente"
                        },
                    }),
                    destroy: new ApiAction({
                        url: "api/clients",
                        message: (ids) => {
                            return ids.length == 1 ? "El cliente fue eliminado correctamente" : "Los clientes seleccionados fueron eliminados correctamente"
                        },
                    }),
                    state: new ApiAction({
                        url: "api/clients/state",
                        message: (ids) => {
                            return ids.length == 1 ? "El cliente fue bloqueado correctamente" : "Los clientes seleccionados fueron bloqueados correctamente"
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
                        event: "state",
                        name: "Bloquear",
                        icon: "bi bi-toggle2-off",
                    }),
                    new Action({
                        event: "unlock",
                        name: "Desbloquear",
                        icon: "bi bi-toggle2-on",
                        single: true,
                    }),
                ],
                columns: {
                    name: new Column({
                        id: "name",
                        type: "text",
                        name: "Nombre",
                        icon: "bi bi-person-circle",
                        content(item) {
                            return `${item.name} ${item.lastName}`
                        },
                        html(item) {
                            let avatar = ""
                            if (item.avatar == null || item.avatar == undefined) {
                                avatar = `<div class='avatar'>${item.name.at(0).toUpperCase()}</div>`
                            } else {
                                avatar = `<img class="me-2" src="${item.avatarPath}" />`
                            }
                            return `<img class="me-2" src="${item.avatar}" /> ${item.name} ${item.lastName}`
                        },
                    }),
                    gender: new Column({
                        id: "gender",
                        type: "radio",
                        name: "Género",
                        icon: "bi bi-gender-ambiguous",
                        visible: false,
                        classes: "text-center",
                        options: [
                            { value: "Masculino", label: "Masculino" },
                            { value: "Femenino", label: "Femenino" },
                            { value: "Otro", label: "Otro" },
                        ],
                    }),
                    email: new Column({
                        id: "email",
                        type: "email",
                        name: "Email",
                        icon: "bi bi-envelope-fill",
                        html(item) {
                            return item.email
                        },
                    }),
                    phone: new Column({
                        id: "phone",
                        type: "phone",
                        name: "Teléfono",
                        icon: "bi bi-telephone-fill",
                    }),
                    address: new Column({
                        id: "address",
                        type: "text",
                        name: "Dirección",
                        icon: "bi bi-map-fill",
                        visible: false,
                        content(item) {
                            return `${item.address}. ${item.city}, ${item.province}`
                        },
                        html(item) {
                            return `${item.address}. ${item.city}, ${item.province}`
                        },
                    }),
                    state: new Column({
                        id: "state",
                        type: "radio",
                        name: "Estado",
                        icon: "bi bi-toggles",
                        classes: "text-center",
                        options: [
                            { value: "Activa", label: "Activa" },
                            { value: "Bloqueada", label: "Bloqueada" },
                        ],
                        html(item) {
                            if (item.state == "Activa") {
                                return '<span class="badge bg-success">Activa</span>'
                            } else {
                                return '<span class="badge bg-danger">Bloqueada</span>'
                            }
                        },
                    }),
                },
            }
        },
        methods: {
            onunlock(item) {
                const data = new FormData()
                data.append("_method", "put")
                Request.post(`api/clients/${item.id}/state/Activa`, data).then(() => {
                    this.$refs.table.onupdated([item.id], { state: "Activa" }, "El cliente ha sido desbloqueado")
                })
            },
        },
    }
</script>

<template>
    <Carousel :title="title" :windows="windows" ref="carousel">
        <template #content="content">
            <div class="carousel-item" style="padding-top: 2.5rem">
                <ClientForm @submit="onsubmit" />
            </div>
            <div class="carousel-item active">
                <CustomTable ref="table" @unlock="onunlock" id="clients" :config="config" :api="api" :columns="columns" :actions="actions" />
            </div>
        </template>
    </Carousel>
</template>
