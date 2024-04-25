<script>
    import CustomModal from "../native/modal/Modal.vue"
    import QuotationDetails from "./QuotationDetails.vue"

    export default {
        components: { CustomModal, QuotationDetails },
    }
</script>

<template>
    <CustomModal :config="config" @accept="accept" @cancel="cancel">
        <QuotationDetails :quotation="quotation" />
    </CustomModal>
</template>
