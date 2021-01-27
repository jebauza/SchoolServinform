<template>
    <div class="card">
        <Navbar :basepath="basepath"></Navbar>

        <Content :basepath="basepath"></Content>

    </div>
</template>

<script>
import Navbar from './layouts/Navbar';
import Content from './layouts/Content';


export default {
    components: {Navbar,Content},
    props: ['basepath'],
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
            const url = 'api/events'

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

<style>

</style>
