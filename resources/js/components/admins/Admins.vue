<script>
    import Request from "../../Request.js"
    import BasicMixin from "../../mixins/Basic.js"
    import Column from "../native/Column.js"
    import Action from "../native/action-buttons/Action.js"
    import ApiAction from "../native/table/ApiAction.js"

    import AdminForm from "./AdminForm.vue"

    export default {
        mixins: [BasicMixin],
        components: { AdminForm },
        data() {
            return {
                title: "Administradores",
                api: {
                    index: new ApiAction({
                        url: "api/users",
                    }),
                    store: new ApiAction({
                        url: "api/users",
                        message: () => {
                            return "El administrador fue creado correctamente"
                        },
                    }),
                    update: new ApiAction({
                        type: "post",
                        url: (id, item) => {
                            return `api/users/${id}`
                        },
                        message: () => {
                            return "Los datos del administrador fueron actualizados correctamente"
                        },
                    }),
                    destroy: new ApiAction({
                        url: "api/users",
                        message: (ids) => {
                            return ids.length == 1 ? "El administrador fue eliminado correctamente" : "Los administradores seleccionados fueron eliminados correctamente"
                        },
                    }),
                    state: new ApiAction({
                        url: "api/users/state",
                        message: (ids) => {
                            return ids.length == 1 ? "El administrador fue bloqueado correctamente" : "Los administradores seleccionados fueron bloqueados correctamente"
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
                            return `<img src="src/img/avatars/${item.avatar}" />${item.name} ${item.lastName}`
                        },
                    }),
                    gender: new Column({
                        id: "gender",
                        type: "radio",
                        name: "Género",
                        icon: "bi bi-gender-ambiguous",
                        visible: false,
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
                    }),
                    username: new Column({
                        id: "username",
                        type: "text",
                        name: "Nombre de usuario",
                        icon: "bi bi-envelope-fill",
                    }),
                    phone: new Column({
                        id: "phone",
                        type: "phone",
                        name: "Teléfono",
                        icon: "bi bi-telephone-fill",
                        classes: "text-center",
                    }),
                    level: new Column({
                        id: "level",
                        type: "radio",
                        name: "Rol de usuario",
                        icon: "bi bi-toggles",
                        classes: "text-center",
                        options: [
                            { value: "Administrador", label: "Administrador" },
                            { value: "Usuario", label: "Usuario" },
                        ],
                        html(item) {
                            if (item.level == "Administrador") {
                                return '<span class="badge bg-success">Administrador</span>'
                            } else {
                                return '<span class="badge bg-secondary">Usuario</span>'
                            }
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
                    permissions: {
                        id: "permissions",
                        type: "tags",
                        name: "Permisos",
                        icon: "bi bi-tags",
                        classes: "text-center",
                        visible: false,
                        content: (item) => {
                            const permissions = []
                            for (let permission of item.permissions) {
                                permissions.push(permission.permission.name)
                            }
                            return permissions.join(",")
                        },
                        html(item) {
                            let result = ""
                            for (let permission of item.permissions) {
                                result += `<span class="badge bg-secondary me-1">${permission.permission.name}</span>`
                            }
                            return result
                        },
                    },
                },
            }
        },
        methods: {
            onunlock(item) {
                const data = new FormData()
                data.append("_method", "put")
                Request.post(`api/users/${item.id}/state/Activa`, data).then(() => {
                    this.$refs.table.onupdated([item.id], { state: "Activa" }, "El registro ha sido desbloqueado")
                })
            },
        },
    }
</script>

<template>
    <Carousel ref="carousel" :title="title" :windows="windows">
        <template #content="content">
            <div class="carousel-item" style="padding-top: 2.5rem">
                <AdminForm @submit="onsubmit" />
            </div>
            <div class="carousel-item active">
                <CustomTable ref="table" @edit="onedit" @unlock="onunlock" id="admins" :config="config" :api="api" :columns="columns" :actions="actions" />
            </div>
            <div class="carousel-item" style="padding-top: 2.5rem">
                <AdminForm @submit="onsubmit" :item="updating" />
            </div>
        </template>
    </Carousel>
</template>
