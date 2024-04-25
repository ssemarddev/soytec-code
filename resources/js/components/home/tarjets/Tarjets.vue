<script>
    import Tarjet from "./Tarjet.vue"
    
    export default {
        components: { Tarjet },
    }
</script>

<style scoped>
    .tarjets {
        display: flex;
        flex-wrap: wrap;
        grid-column-gap: 0.75rem;
        padding-left: 3rem;
        padding-right: 3rem;
    }

    @media (max-width: 1000px) {
        .tarjets {
            display: flex;
            flex-wrap: wrap;
            grid-column-gap: 0.75rem;
            padding-left: .5rem;
            padding-right: .5rem;
        }
    }

    .tarjets>div {
        width: calc(25% - 0.75rem);
    }

    .tarjets>div:last-child {
        width: 25%;
    }

    @media (max-width: 860px) {

        .tarjets {
            grid-row-gap: 0.75rem;
            padding-left: 4rem;
            padding-right: 4rem;
        }

        .tarjets>div:nth-child(1),
        .tarjets>div:nth-child(3) {
            width: calc(50% - 0.75rem);
        }

        .tarjets>div:nth-child(2),
        .tarjets>div:nth-child(4) {
            width: 50%;
        }
    }

    @media (max-width: 772px) {
        .tarjets {
            padding-left: 2rem;
            padding-right: 2rem;
        }
    }

    @media (max-width: 672px) {
        .tarjets {
            padding-left: .5rem;
            padding-right: .5rem;
        }
    }
</style>

<template>
    <div class="tarjets">
        <div>
            <Tarjet :icon="'bi bi-eye'" :value="500" :name="'Vistas'" />
        </div>
        <div>
            <Tarjet :icon="'bi bi-chat-square-heart'" :value="53" :name="'Reseñas'" />
        </div>
        <div>
            <Tarjet :icon="'bi bi-people'" :value="145" :name="'Clientes'" />
        </div>
        <div>
            <Tarjet :icon="'bi bi-cart4'" :value="12" :name="'Ofertas'" />
        </div>
    </div>
</template>