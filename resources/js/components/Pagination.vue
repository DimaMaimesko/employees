<template>

</template>

<script>
    export default {
        props: [
            'pages'
        ],
        data: function () {
            return {
                current: 1,
            }
        },
        methods: {
            changed: function (event) {
                // console.log(event.target.text);
                this.current = event.target.text;
                Event.$emit('pageChanged', this.current);
            }
        },

    }
</script>


