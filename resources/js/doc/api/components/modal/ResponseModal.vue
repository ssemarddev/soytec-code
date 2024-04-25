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
        <div class="mb-2">
            <span class="badge me-2" :class="{'bg-success': response.request.status == 200, 'bg-danger': response.request.status !== 200 }">Status: {{ response.request.status }}</span>
            <span class="badge" :class="{'bg-success': response.request.status == 200, 'bg-danger': response.request.status !== 200 }">Status Text: {{ response.request.statusText }}</span>
        </div>
        <div class="d-flex align-items-center" data-bs-toggle="collapse" data-bs-target="#headers">
            <button class="btn btn-sm btn-secondary me-2">Headers: </button>
            <span style="line-height: 1.1em;font-size: .75em;">{{ response.headers.toString().substring(0, 200) }}...</span>
        </div>
        <div class="collapse mt-1 px-2 py-1 border rounded" id="headers">
            <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">access-control-allow-origin:</a> {{
                response.headers['access-control-allow-origin'] }}</p>
            <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">cache-control:</a> {{
                response.headers['cache-control'] }}</p>
            <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">connection:</a> {{
                response.headers['connection'] }}</p>
            <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">content-type:</a> {{
                response.headers['content-type'] }}</p>
            <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">date:</a> {{ response.headers['date'] }}
            </p>
            <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">host:</a> {{ response.headers['host'] }}
            </p>
            <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">x-powered-by:</a> {{
                response.headers['x-powered-by'] }}</p>
            <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">x-ratelimit-limit:</a> {{
                response.headers['x-ratelimit-limit'] }}</p>
            <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">x-ratelimit-remaining:</a> {{
                response.headers['x-ratelimit-remaining'] }}</p>
        </div>
        <div class="d-flex align-items-center mt-3" data-bs-toggle="collapse" data-bs-target="#response">
            <button class="btn btn-sm btn-secondary me-2">Response: </button>
            <span style="line-height: 1.1em;font-size: .75em;">{{ response.request.responseText.substring(0, 150)
            }}...</span>
        </div>
        <div class="collapse mt-1 px-2 py-1 border rounded" id="response">
            <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">responseText:</a> {{
            response.request['responseText'].substring(0, 200) }} <button class="btn btn-sm btn-primary py-0 px-2"><i
                    class="bi bi-envelope"></i></button></p>
        <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">responseType:</a> {{
            response.request['responseType'] }}</p>
        <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">responseURL:</a> {{
            response.request['responseURL'] }}</p>
        <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">status:</a> {{ response.request['status']
            }}</p>
        <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">statusText:</a> {{
            response.request['statusText'] }}</p>
        <p class="mb-0" style="font-size: .9em;"><a href="#" class="text-info">timeout:</a> {{
            response.request['timeout'] }}</p>
    </div>
</CustomModal></template>
