<template>
    <tbody>
                <tr v-for="employee in employees">
                    <td>{{employee.id }}</td>
                    <td></td>
                    <td>{{ employee.position }}</td>
                    <td>{{ employee.hired_at }}</td>
                    <td>{{ employee.salary }}</td>
                    <td> {{employee.parent ? employee.parent.name : ""}}</td>

                </tr>


    </tbody>
</template>

<script>
    export default {
        data: function(){
           return {
               employees: [],
               isRefreshing: false,
               // countPages: 0,
               // i: 0,
           }
        },
        methods: {
            showmore: function(){
                axios.get('ajaxlist/more').then((responce) => {
                    console.log(responce.data);
                    this.employees = responce.data.employees;
                    this.countPages = responce.data.countPages;
                })
            }
        },
    }
</script>


