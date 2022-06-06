<script>
    class Product extends BaseClass {
        no_set = [];
        all_categories = @json(\App\Model\Common\ProductCategory::getForSelect());
        all_units = @json(\App\Model\Common\Unit::getForSelect());

        before(form) {
            this.image = {};
        }

        after(form) {

        }

        get price() {
            return this._price ? this._price.toLocaleString('en') : '';
        }

        set price(value) {
            value = parseNumberString(value);
            this._price = value;
        }

        get points() {
            return this._points;
        }

        set points(value) {
            this._points = Number(value);
        }

        get image() {
            return this._image;
        }

        set image(value) {
            this._image = new Image(value, this);
        }

		clearImage() {
			if (this.image) this.image.clear();
		}

        get submit_data() {
            let data = {
                name: this.name,
                barcode: this.barcode,
                status: this.status,
                product_category_id: this.product_category_id,
                note: this.note,
                points: this._points,
                price: this._price,
                unit_id: this.unit_id,
                unit_name: this.unit_name
            }

            data = jsonToFormData(data);
            let image = this.image.submit_data;
            if (image) data.append('image', image);
            return data;
        }
    }
</script>
