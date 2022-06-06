<table class="no-border" style="width:100%">
    <tbody>
        <tr>
            <td style="width:100%">{{invoice_header}}</td>
        </tr>
    </tbody>
</table>

<div> 
    <table class="no-border" style="table-layout:fixed; width:100%">
        <tbody>
            <tr>
                <td colspan="3" style="text-align:center"><span style="font-size:20px"><strong>H&Oacute;A ĐƠN B&Aacute;N</strong></span><br />
                    <em>No: {{SO_PHIEU}}</em></td>
            </tr>
            <tr>
                <td>Số phiếu: <strong>{{SO_PHIEU}}</strong></td>
                <td>Loại phiếu: <strong>{{LOAI_PHIEU}}</strong></td>
                <td>Ngày ghi nhận:<strong>{{NGAY_GHI_NHAN}}</strong></td>
            </tr>
            <tr>
                <td>Người lập: <strong>{{NGUOI_LAP}}</strong></td>
                <td>Trạng thái: <strong>{{TRANG_THAI}}</strong></td>
                <td>Đối tượng trả:<strong>{{DOI_TUONG_TRA}}</strong></td>
            </tr>
            <tr>
                <td>Người trả: <strong>{{NGUOI_TRA}}</strong></td>
                <td>Tổng giá trị: <strong>{{TONG_GIA_TRI}}</strong></td>
                <td>Số hóa đơn mua:<strong>{{SO_HOA_DON}}</strong></td>
            </tr>
            <tr>
                <td colspan="3">Ghi chú: <strong>{{GHI_CHU}}</strong></td>
            </tr>
        </tbody>
    </table>
    <div>
        <br />
        <div class="col-md-12 detail-info mb-3">
            {{CHI_TIET_HOA_DON}}
        </div>
        <h4>THÔNG TIN THANH TOÁN</h4>
        <div class="col-md-12 sumary-info">
            {{TONG_HOP}}
        </div>
        <style type="text/css">
            td {
                border: 1px solid black;
            }

            table {
                border-collapse: collapse;
            }
        </style>
    </div>
</div>