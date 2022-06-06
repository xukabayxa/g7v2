@include('partial.classes.g7.WarehouseExportDetail')
<script>
    class WarehouseExport extends BaseClass {

        before(form) {
            this.no_set = [];
			this.type = 1;
			this.types = @json(App\Model\G7\WarehouseExport::TYPES);
        }

        after(form) {
            if(form.bill) this.useBill(form.bill);
            if(form.details) this.details = form.details;
        }

		useBill(bill) {
			this.bill = bill;
			this.details = bill.export_products;
            this.customer_name = bill.customer_name;
            this.bill_date = bill.bill_date;
            this.bill_note = bill.note;
		}

        // useWarehouseExport(w) {
        //     this.code = w.code;
        //     this.type = w.type;
        //     this.note
        // }

        get details() {
            return this._details || [];
        }
        set details(value) {
            this._details = (value || []).map(val => new WarehouseExportDetail(val, this));
        }

		addDetail(product) {
            if (!this._details) this._details = [];
            let exist = this.details.find(val => val.product_id == product.product_id);
            if (exist) exist.qty++;
            else this._details.push(new WarehouseExportDetail({product, product_id: product.product_id}, this));
        }

        removeDetail(index) {
            this._details.splice(index, 1);
        }

        get submit_data() {
            return {
				type: this.type,
				bill_id: (this.bill || {}).id,
                details: this.details.map(val => val.submit_data),
                note: this.note,
            }
        }
    }
</script>
