<script>
    class Config extends BaseClass {
        no_set = [];

        before(form) {

        }

        after(form) {

        }

        get submit_data() {
            return {
                date_reminder: this.date_reminder,
            }
        }
    }
</script>