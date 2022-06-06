@include('partial.classes.uptek.ServiceVehicleCategoryGroupProduct')
<script>
  class ServiceVehicleCategoryGroup extends BaseChildClass {

    after() {
    }

    get rowspan() {
        return this.products.length + 2;
    }

    get service_price() {
        return this._service_price ? this._service_price.toLocaleString('en') : '';
    }

    set service_price(value) {
        this._service_price = parseNumberString(value);
    }

	get points() {
        return this._points ? this._points.toLocaleString('en') : 0;
    }

    set points(value) {
        this._points = parseNumberString(value);
    }

    get products() {
        return this._products || []
    }

    set products(value) {
        this._products = (value || []).map(val => new ServiceVehicleCategoryGroupProduct(val, this));
    }

    addProduct(product) {
        if (!this._products) this._products = [];
        let exist = this.products.find(val => val.product_id == product.product_id);
        if (exist) exist.qty++;
        else this._products.push(new ServiceVehicleCategoryGroupProduct({product, product_id: product.product_id}, this));
    }

    removeProduct(index) {
        this._products.splice(index, 1);
    }

    get submit_data() {
        return {
			id: this.id,
            name: this.name,
            service_price: this._service_price,
			points: this._points || 0,
            products: this.products.map(val => val.submit_data)
        }
    }

  }
</script>
