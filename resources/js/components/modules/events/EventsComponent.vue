<template>
    <div class="card border-primary mb-4">
        <div class="card-header">
            <h3 class="card-title text-primary font-weight-bold">Events API</h3>
        </div>

        <div class="card-body">

            <div class="row table-responsive">
                <table v-if="events.length" class="table table-striped">
                    <thead>
                        <tr class="bg-info">
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr v-for="(event, index) in events" :key="index">
                            <td><a :href="event.sameAs" target="_blank">{{event.title}}</a></td>
                            <td v-html="event.description"></td>
                            <td class="w-25">
                                <img :src="event.image" class="img-fluid img-thumbnail" :alt="event.title">
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>


    </div>
</template>

<script>
export default {
    created() {
        this.getEvents();
    },
    data() {
        return {
            events: [],
        }
    },
    methods: {
        getEvents() {
            const url = `/api/events`;
            const loading = this.$vs.loading({
                type: 'points',
                color: 'blue',
                // background: '#7a76cb',
                text: 'Loading...'
            });

            axios.get(url)
            .then(res => {
                this.events = res.data;
                loading.close();
            }).catch(err => {
                loading.close();
                console.error(err);
            });
        },
    },

}
</script>

<style>

</style>
