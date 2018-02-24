<template>
    <div>
        {{ exampleProperty }}
    </div>
</template>

<script>
    export default {

        props: [
            'exampleProperty'
        ],

        data: () => ({
            exampleData: [],
        }),

        mounted() {
          //  axios.get(`/api/v1/route`).then(response => {
          //      this.exampleData = response.data;
          //  });

          //  Echo.channel('channelName').listen('EventClassName', eventPayload => {
          //
          //  });
        },

        methods: {

            exampleFunction: function (string) {
                return string;
            },

        }

    }
</script>