<template>

    <div class="card-header">
        <div class="btn-group" role="group" aria-label="Basic example">
            <router-link :to="{path: 'students'}" role="button" class="btn btn-primary mx-1">Students</router-link>
            <router-link :to="{path: 'courses'}" role="button" class="btn btn-primary mx-1">Courses</router-link>
            <router-link :to="{path: 'events'}" role="button" class="btn btn-primary mx-1">Events API</router-link>
        </div>
        <button type="button" class="btn btn-success btn-sm float-right" @click="loadData">Load data</button>
    </div>

</template>

<script>
export default {
    props: ['basepath'],
    mounted() {

    },
    data() {
        return {

        }
    },
    methods: {
        loadData() {
            const url = '/api/seeders';
            const loading = this.$vs.loading({
                type: 'points',
                color: 'blue',
                // background: '#7a76cb',
                text: 'Loading Data...'
            });

            axios.get(url)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                EventBus.$emit('coursesLoad');
                EventBus.$emit('studentsLoad');
            })
            .catch(err => {
                loading.close();
                console.error(err);
            })
        }
    }
}
</script>

<style>

</style>
