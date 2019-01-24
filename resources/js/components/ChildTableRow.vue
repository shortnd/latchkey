<template>
    <tr>
        <td>
            <a :href="this.route">{{ fullname() }}</a>
        </td>
        <td>
            <span v-if="!this.kid.today_checkin.am_checkin">
                <form @submit.prevent="">
                    <label for="am_checkin">Checkin &nbsp;<input type="checkbox" v-model="this.kid.today_checkin.am_checkin"/></label>
                </form>
            </span>
            <span v-else>
                Checked in at {{this.kid.today_checkin.am_checkin_time}}
            </span>
            <!-- <div v-if="this.kid.today_checkin.am_checkin === 0">
                something
            </div>
            <div v-else>
                Checked in at {{ child.today_checkin.am_checkin_time }}
            </div> -->
        </td>
    </tr>
</template>

<script>
export default {
    props: {
        child: String,
        route: String
    },
    data() {
        return {
            kid: JSON.parse(this.child)
        }
    },
    methods: {
        fullname: function () {
            return `${this.kid.first_name} ${this.kid.last_name}`
        },
        amCheckinForm: (route) => {
            axios.put(route, {
                am_checkin: this.kid.today_checkin.am_checkin
            })
        },
        amChecked: () => this.kid.today_checkin.am_checkin ? 'checked' : ''
    },
    computed: {
    }
}
</script>

<style>

</style>
