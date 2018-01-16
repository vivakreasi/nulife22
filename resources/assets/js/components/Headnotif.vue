<template id="notifBlock">
    <!--notification info start-->
    <li id="notifli">
        <a href="javascript:;" onclick="$('#notifli').addClass('open');" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="badge bg-danger">4</span>
        </a>

        <div class="dropdown-menu dropdown-title">

            <div class="title-row">
                <h5 class="title"> <!-- add color class to add arrow accent on top -->
                    You have 4 New Notification
                </h5>
                <a href="javascript:;" class="btn-info btn-view-all">View all</a>
            </div>
            <div class="notification-list-scroll sidebar" v-for="notif in notifs">
                <div class="notification-list mail-list not-list">
                    <a href="javascript:;" class="single-mail">
                        <span class="icon bg-info">
                            <i class="fa fa-user"></i>
                        </span>
                        <strong>You have new Plan-C downline @{{notif.subject}}</strong>
                        <p>
                            <small>@{{notif.time}}</small>
                        </p>
                        <span class="un-read tooltips" data-original-title="Mark as Read" data-toggle="tooltip" data-placement="left">
                            <i class="fa fa-circle"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </li>
    <!--notification info end-->
</template>

<script>
    export default {
        data () {
            return{
                notifs: []
            }
          },
        ready: function () {
            this.fetchNotifs();
        },

        methods: {
            fetchNotifs () {
              this.$http.get('/admin/getNotifs')
                .success(function (notifs) {
                  alert(notifs);
                  this.notifs = notifs;
                })
                .error(function (err) {
                  notifs.log(err);
                });
            },
        }
    }
</script>
