<script>
    class G7UpdatePass extends BaseClass {
        no_set = [];

        before(form) {

        }

        after(form) {

        }

        get submit_data() {
            return {
                old_password: this.old_password,
                password: this.password,
                password_confirm: this.password_confirm,
            }
        }
    }
</script>