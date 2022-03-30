<template>
    <div class="row">
        <div class="col-12">
            <nested-draggable :items="changeable" :nesting="nesting - 1" v-on:changed="checkMove" />

            <button class="btn btn-success mb-3"
                    v-if="weightChanged"
                    @click="changeOrder"
                    :disabled="loading"
                    :class="weightChanged ? 'animated bounceIn' : ''">
                Сохранить структуру
            </button>
        </div>
    </div>
</template>

<script>
    import nestedDraggable from "./GroupItemComponent";
    export default {
        name: "admin-group-nested",
        components: {
            nestedDraggable
        },
        props: {
            structure: {
                type: Array,
                required: true,
            },
            updateUrl: {
                type: String,
                required: true,
            },
            nesting: {
                type: Number,
                default: 3
            }
        },
        data() {
            return {
                changeable: [],
                weightChanged: false,
                loading: false,
            };
        },
        created() {
            this.changeable = this.structure;
        },
        methods: {
            checkMove() {
                this.weightChanged = true;
            },

            changeOrder() {
                this.loading = true;
                axios
                    .put(this.updateUrl, {
                        items: this.changeable
                    })
                    .then(response => {
                        let result = response.data;
                        this.weightChanged = false;
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: result,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    })
                    .catch(error => {
                        let data = error.response.data;
                        let message = "Упс что то пошло не так";
                        if (data.hasOwnProperty("message")) {
                            message = data.message;
                        }
                        console.log(data);
                        Swal.fire({
                            position: 'top-end',
                            type: 'error',
                            title: message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            }
        }
    };
</script>
<style scoped></style>