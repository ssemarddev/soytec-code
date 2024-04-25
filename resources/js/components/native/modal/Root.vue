<script>
    import CustomModal from "./Modal.vue"
    export default {
        components: { CustomModal },
    }
</script>

<template>
    <CustomModal :config="config" @accept="accept" @cancel="cancel" />
</template>
