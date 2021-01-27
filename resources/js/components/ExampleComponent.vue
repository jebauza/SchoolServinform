<template>
    <div class="card">
        <div class="card-header">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="#" role="button" class="btn btn-danger mx-1">Courses</a>
                <a href="#" role="button" class="btn btn-danger mx-1">Students</a>
            </div>
        </div>

        <div class="card-body">


        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
            this.seeders();
        },
        data() {
            return {

            }
        },
        methods: {
            seeders() {
                const url = 'api/students'

                axios.get(url)
                .then(res => {
                    console.log(res)
                })
                .catch(err => {
                    console.error(err);
                })
            }
        },
    }
</script>
