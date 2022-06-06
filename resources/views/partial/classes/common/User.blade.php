<script>
    class User extends BaseClass {
        no_set = [];

        before(form) {
            this.types = USER_TYPES.filter(val => arrayInclude(@json(Auth::user()->getAccessTypes()), val.id));
			this.all_roles = @json(\App\Model\Common\Role::getForSelect());
            this.all_g7s = @json(\App\Model\Uptek\G7Info::getForSelect());
            this.image = {};
        }

        after(form) {
            if (!this.id) {
                this.password = "111111";
                this.password_confirm = "111111";
            }
        }

        get type()
        {
            return this._type;
        }

        set type(value)
        {
            this._type = Number(value);
        }

		get available_roles() {
			return this.all_roles.filter(val => val.type == this.type);
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
                email: this.email,
                password: this.password,
                password_confirm: this.password_confirm,
                type: this.type,
                g7_id: this.g7_id,
                g7_ids: this.g7_ids,
                roles: this.roles,
                status: this.status
            }

            data = jsonToFormData(data);
            let image = this.image.submit_data;
            if (image) data.append('image', image);
            return data;
        }
    }
</script>