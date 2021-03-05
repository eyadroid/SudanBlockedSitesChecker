
<template>
    <li class="website-item" v-bind:class="(this.website.last_request == null || !this.website.last_request.available) ? 'unavailable' : 'available'">
        <div class="website-item-status">
            <div class="website-item-status-circle" ></div>
            <span class="website-item-status-text" v-if="this.website.last_request">
                {{this.website.last_request.available ? "Available" : "Blocked"}}
            </span>
        </div>
        
        <div class="website-item-informations">
            <div class="website-item-name">
                <p>{{this.website.name}}</p>
            </div>
            <div class="website-item-url">
                <h4 v-on:click='openWebist()'>{{this.website.url}}</h4>
                <p v-if="this.website.last_request != null">Last checked: {{this.lastChecked()}} ago</p>
            </div>
        </div>

        <div class="website-item-check-status-btn">
            <div class="cont-text-date" v-on:click="checkStatus()">
                <p v-if="this.$root.checkingwebsite != this.website.id">check status</p>
                <p v-if="this.$root.checkingwebsite == this.website.id">
                    Checking...
                    <i class="fas fa-circle-notch fa-spin"></i>
                </p>
            </div>
        </div>
    </li>
</template>
<script>

export default {
    props: ['website'],
    methods: {
        openWebist() {
            window.open(this.website.url, '_blank')
        },
        checkStatus() {
            this.$root.checkWebsiteStatus(this.website);
        },
        lastChecked() {
            const date = new Date(this.website.last_request.created_at);
            var seconds = Math.floor((new Date() - date) / 1000);

            var interval = seconds / 31536000;

            if (interval > 1) {
                return Math.floor(interval) + " years";
            }
            interval = seconds / 2592000;
            if (interval > 1) {
                return Math.floor(interval) + " months";
            }
            interval = seconds / 86400;
            if (interval > 1) {
                return Math.floor(interval) + " days";
            }
            interval = seconds / 3600;
            if (interval > 1) {
                return Math.floor(interval) + " hours";
            }
            interval = seconds / 60;
            if (interval > 1) {
                return Math.floor(interval) + " minutes";
            }
            return Math.floor(seconds) + " seconds";
            }
    }
}
</script>