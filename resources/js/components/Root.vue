<script>
    import Request from "../Request.js"
    import Dashboard from "./native/dashboard/Dashboard.vue"

    export default {
        components: { Dashboard },
        data() {
            return {
                user: {},
                buttons: [
                    { href: "#home", name: "Dashboard", icon: "bi bi-house" },
                    { href: "#categories", name: "Categorías", icon: "bi bi-tags" },
                    { href: "#clients", name: "Clientes", icon: "bi bi-people" },
                    { href: "#providers", name: "Proveedores", icon: "bi bi-building" },
                    { href: "#store", name: "Productos de la tienda", icon: "bi bi-boxes" },
                    { href: "#inventory", name: "Inventario", icon: "bi bi-cpu" },
                    { href: "#sales", name: "Ventas realizadas", icon: "bi bi-cart-check" },
                    { href: "#shopping", name: "Compras realizadas", icon: "bi bi-basket2" },
                    { href: "#workshop", name: "Taller", icon: "bi bi-tools" },
                    { href: "#admins", name: "Administradores", icon: "bi bi-person-bounding-box" },
                    { href: "#quotations", name: "Cotizaciones", icon: "bi bi-calculator" },
                    { href: "#chats", name: "Soporte técnico", icon: "bi bi-headset" },
                    { href: "#reviews", name: "Reseñas", icon: "bi bi-chat-square-heart" },
                ],
            }
        },
        created() {
            Request.get("api/user").then((response) => {
                this.user = response.data
            })
        },
    }
</script>

<template>
    <Dashboard :buttons="buttons" :user="user" />
</template>
