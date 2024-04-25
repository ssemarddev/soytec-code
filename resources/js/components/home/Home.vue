<script>
    import Job from "./jobs/Job.vue"
    import Tarjets from "./tarjets/Tarjets.vue"
    import Sales from "./sales/Sales.vue"

    export default {
        components: { Job, Tarjets, Sales },
    }
</script>

<style scoped>
    .container-fluid {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    @media (max-width: 1000px) {
        .container-fluid {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
    }
</style>

<template>
    <div class="container-fluid">
        <Tarjets />
        <Sales />
        <Job />
    </div>
</template>
