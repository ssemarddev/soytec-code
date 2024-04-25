<template>
    <form @submit.prevent="save">
        <input name="title" class="form-control" type="text" placeholder="Título del chat" v-model="name" />
        <div class="w-100 d-flex justify-content-center mt-2">
            <button type="button" class="btn btn-secondary btn-sm me-1" @click="close">Cancelar</button>
            <button class="btn btn-success btn-sm ms-1">Crear chat</button>
        </div>
    </form>
</template>
