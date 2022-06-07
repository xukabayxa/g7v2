@if (Auth::check())
<script>
    class DATATABLE {
    constructor(id, options = {}) {
        this.id = id;
        this.options = options;
        this.datatable = this.initDatatable();
        this.typeVehicle = @json(App\Model\Common\VehicleType::where('status',1)->get());
        this.vehicleCategory = @json(\App\Model\Common\VehicleCategory::where('status',1)->get());
    }

    static mergeSearch(object, context) {
        let id = context.nTable.id;
        $(`#${id}_wrapper .search-column [data-column]`).each(function() {
            if ($(this).data('column')) {
                let column = $(this).data('column');
                object[column] = $(this).val();
            }
        })
        object.startDate = $(`#${id}_wrapper .search-column .startDate`).val() ? moment($(`#${id}_wrapper .search-column .startDate`).val(), 'DD/MM/YYYY').format('YYYY-MM-DD') : '';
        object.endDate = $(`#${id}_wrapper .search-column .endDate`).val() ? moment($(`#${id}_wrapper .search-column .endDate`).val(), 'DD/MM/YYYY').format('YYYY-MM-DD') : '';
    }

    resetSearch() {
        let id = this.id;
        $(`#${id}_wrapper .search-column [data-column]`).each(function() {
            $(this).val('');
        })
        $(`#${id}_wrapper .search-column .startDate`).val('');
        $(`#${id}_wrapper .search-column .endDate`).val('');
        triggerSelect2();
    }

    saveSearch() {
        let object = {};
        let id = this.id;
        $(`#${id}_wrapper .search-column [data-column]`).each(function() {
            if ($(this).data('column')) {
                let column = $(this).data('column');
                object[column] = $(this).val();
            }
        })
        object.page = this.datatable.page();
        localStorage.setItem(id + "-" + window.location.href, JSON.stringify(object))
    }

    restoreSearch(object) {
        let id = this.id;
        Object.keys(object).forEach((key) => {
            $(`#${id}_wrapper .search-column [data-column=${key}]`).val(object[key]);
        })
        triggerSelect2();
        if (object.page) this.datatable.page(object.page);
        setTimeout(() => this.datatable.draw('page'));
    }

    getSavedSearch() {
        return JSON.parse(localStorage.getItem(this.id + '-' + window.location.href) || '{}');
    }

    datatableInitComplete(self, saved_search) {
        return function () {
            let options = self.options;
            let table = this.api();
            let table_id = this[0].id;
            let html = `<div class="row search-column mb-3">`;
            if (options.search_by_time) {
                html += `<div class="col-md-3 mb-3">
                    <input type="text" class="form-control startDate date" placeholder="Từ ngày">
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" class="form-control endDate date" placeholder="Đến ngày">
                </div>`;
            }

            let has_column_search = false;
            options.search_columns.forEach(col => {
                if (col.search_type) {
                    has_column_search = true;
                    if (col.search_type == 'text') {
                        html += `<div class="col-md-3 mb-3">
                            <input type="text" class="form-control" data-column="${col.data}" placeholder="${col.placeholder}">
                        </div>`;
                    } else if (col.search_type == 'select') {
                        html += `<div class="col-md-3 mb-3">
                            <div class="form-group custom-group">
                            <label>${col.placeholder}</label>
                            <select class="form-control select2-dynamic" data-column="${col.data}">
                                <option value="">${col.placeholder}</option>`;
                        (col.column_data || []).forEach(function (el) {
                            if (typeof el == 'string') html += '<option value="' + el + '">' + el + '</option>';
                            else html += '<option value="' + el.id + '">' + el.name + '</option>';
                        });
                        html += `</select></div></div>`;
                    }
                }
            })

            if (options.search_by_time || has_column_search || options.create_link) {
                html += `<div class="col-md-3 mb-3">`;
                if (options.search_by_time || has_column_search) {
                    html += `<button class="btn btn-primary search-button mr-1"><i class="fa fa-search"></i></button>
                    <button class="btn btn-success refresh-button mr-1"><i class="fas fa-sync"></i></button>`;
                }
                if (options.create_link) {
                    html += `<a class="btn btn-info" href="${options.create_link}"><i class="fa fa-plus"></i> Tạo mới</a>`;
                }
                if (options.create_modal) {
                    html += `<a class="btn btn-info" href="javascript:void(0)" data-toggle="modal" data-target="#${options.create_modal}">
                        <i class="fa fa-plus"></i> Tạo mới
                    </a>`;
                }
                if (options.sync_service) {
                    html += `<a class="btn btn-warning" onclick="syncService();" style="margin-left: 5px; color:#fff" ><i class="fab fa-ups"></i> Lấy dịch vụ</a>`;
                }
                html += `</div>`;
            }
            html += "</div>";
            $(`#${table_id}_wrapper`).prepend(html);
            $(`#${table_id}_wrapper .search-column`).on('change', 'select', function () {
                if(this.value.length >= 3) {
                    table.draw();
                }

            });

            $(`#${table_id}_wrapper [data-column="object"]`).on('change', function() {
                let payer_name_select = document.querySelector(`#${table_id}_wrapper [data-column="payer_name"]`);
                if (payer_name_select) {
                    if ($(this).val() == 1)  {
                        self.setOptions(payer_name_select, CUSTOMERS, "Khách hàng");
                    } else if ($(this).val() == 2)  {
                        self.setOptions(payer_name_select, USERS, "Nhân viên");
                    } else if ($(this).val() == 3)  {
                        self.setOptions(payer_name_select, SUPPLIER, "Nhà cung cấp");
                    } else self.setOptions(payer_name_select, [], "");
                }
            });

            $(`#${table_id}_wrapper [data-column="manufact"]`).on('change', function() {
                let vehicle_type_select = document.querySelector(`#${table_id}_wrapper [data-column="vehicle_type"]`);
                if (vehicle_type_select) {
                    let typeVehicle = self.typeVehicle;
                    if ($(this).val()) typeVehicle = typeVehicle.filter(val => val.vehicle_manufact_id == $(this).val());
                    self.setOptions(vehicle_type_select, typeVehicle, "Loại xe");
                }
            });

			$(`#${table_id}_wrapper .search-column`).on('blur', 'input', function () {
                if(this.value.length >= 3) {
                    table.draw();
                }
            });

            // self.restoreSearch(saved_search);
        }
    }

    initDatatable() {
        let self = this;
        let tableElement = $(`#${this.id}`);
        tableElement.addClass('table table-hover table-condensed table-responsive table-bordered table-head-border');
        let saved_search = this.getSavedSearch();
        let datatable = tableElement.DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            targets: 'no-sort',
            bSort: false,
            order: [],
            sDom: 'ltrip',
            language: i18nDataTable,
            bLengthChange: false,
            initComplete: this.datatableInitComplete(self, saved_search),
            drawCallback: function() {
                self.saveSearch();
            },
            ...this.options
        });

        $(`#${this.id}_wrapper`).parent().on('click', '.search-button, #search-button', function() {
            datatable.draw();
        })

        $(`#${this.id}_wrapper`).parent().on('click', '.refresh-button, #refresh-button', function() {
            self.resetSearch();
            datatable.draw();
        })

        return datatable;
    }

    setOptions(select, options, holder) {
        $(select).html('');
        let html = `<option value="">${holder}</option>`;
        options.forEach(o => {
            html += `<option value="${o.id}">${o.name}</option>`;
        })
        $(select).html(html);
        $(select).val('');
        $(select).trigger('change');
    }
}
</script>
@endIf
