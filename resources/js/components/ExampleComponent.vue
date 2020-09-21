<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component. (0)
                    </div>
                </div>
            </div>
        </div>
        <div>
            {{ greeting0 }}<br />
            <button @click="updateTimestamp">Update</button><br />
            {{ greeting }}
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                greeting0: "Click the button to view the latest date and time!"
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            updateTimestamp() {
                this.greeting0 = new Date().toLocaleString();
                this.greeting = 'HackerPair';
            }
        },
        props: {
            greeting: String
        }
    }
</script>
