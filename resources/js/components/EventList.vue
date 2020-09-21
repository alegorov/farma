<template>
    <div>
        <ul>
            <li v-for="event in events0">
                {{ event }}
            </li>
        </ul>
        <h1>HackerPair Events {{ events1.length }}</h1>
        <table class="table table-striped table-responsive">
            <thead>
            <tr>
                <th>Name</th>
                <th>City</th>
                <th>State</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <event-item v-for="event in events1"
                        :event="event"
                        :key="event.id"></event-item>
            </tbody>
        </table>
        <h1>HackerPair Events {{ events.length }}</h1>
        {{ error }}
        <table class="table table-striped table-responsive">
            <thead>
            <tr>
                <th>Name</th>
                <th>City</th>
                <th>State</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <event-item v-for="event in events"
                        :event="event"
                        :key="event.id"></event-item>
            </tbody>
        </table>
        <pagination :data="events_response" @pagination-change-page="getEvents">
            <span slot="prev-nav">&lt; Previous</span>
            <span slot="next-nav">Next &gt;</span>
        </pagination>
    </div>
</template>
<script>
    export default {
        created() {
            this.getEvents()
        },
        data() {
            return {
                events0: [
                    'Laravel and Coffee',
                    'The Wonders of IoT',
                    'All About ES6',
                    'Introducing Vue'
                ],
                events1: [
                    {
                        id: 1,
                        name: 'Laravel and Coffee',
                        city: 'Dublin, Ohio'
                    },
                    {
                        id: 2,
                        name: 'The Wonders of IoT',
                        city: 'New York City'
                    },
                    {
                        id: 3,
                        name: 'All About ES6',
                        city: 'Miami'
                    },
                    {
                        id: 4,
                        name: 'Introducing Vue',
                        city: 'San Juan'
                    }
                ],
                error: '',
                events: [],
                events_response: {},
            }
        },
        methods: {
            getEvents(page = 1) {
                axios.get('/api/events?page=' + page)
                    .then(response => {
                        this.events = response.data.data;
                        this.events_response = response.data;
                        //$('.pagination .page-item a').attr('onclick', 'return false;');
                    })
                    .catch(e => {
                        this.error = "An error has occurred.";
                    });
            }
        }
    }
</script>
