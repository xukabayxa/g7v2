<script>
    class Post extends BaseClass {

        statuses = @json(\App\Model\Uptek\Post::STATUSES);
        no_set = [];

        before(form) {
            this.image = {};
            this.status = 0;
        }

        after(form) {

        }

        get image() {
            return this._image;
        }

        set image(value) {
            this._image = new Image(value, this);
        }

        get submit_data() {
            let data = {
                name: this.name,
                intro: this.intro,
                body: this.body,
                status: this.status
            }

            data = jsonToFormData(data);
            let image = $(`#${this.image.element_id}`).get(0).files[0];
            if (image) data.append('image', image);
            return data;
        }
    }
</script>