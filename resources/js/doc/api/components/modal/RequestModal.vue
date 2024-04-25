<script>
import CustomModal from "../../../../components/native/modal/Modal.vue"
import Path from "./Path.vue"

export default {
    components: { CustomModal, Path },
    data() {
        return {
            url: ''
        }
    },
}
</script>

<template>
    <CustomModal :config="config" @accept="accept" @cancel="cancel">
        <p class="mb-1">{{ route.description }}</p>
        <div class="text-center mt-2">
            <span class="badge bg-secondary mb-2">Cabecera</span>
            <Path @change="(value) => url = value" :route="route" />
        </div>
        <hr />
        <div class="mt-2 text-center">
            <span class="badge bg-secondary mb-2">Cuerpo</span>
            <form id="requestForm">
                <input type="hidden" name="url" :value="url" />
                <template v-for="param in route.params">
                    <div class="form-floating mb-3" v-if="!param.head">
                        <input type="text" class="form-control" :name="param.name" :placeholder="param.name"
                            :required="param.required" />
                        <label>{{ param.name }} <i v-if="param.required" class="bi bi-check-all"></i></label>
                    </div>
                </template>
            </form>
        </div>
    </CustomModal>
</template>
