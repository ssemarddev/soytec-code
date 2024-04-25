<script>
import Route from './Route.vue';
export default {
    components: { Route },
    props: {
        title: String,
        routes: Array,
    },
    data() {
        return {

        }
    }
}
</script>
<template>
    <div class="p-2">
        <h3>{{ title }}</h3>
        <Route v-for="route in routes" :route="route" />
    </div>
</template>
