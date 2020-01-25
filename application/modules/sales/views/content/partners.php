<div class="row">
    <!--Datagrid partners-->
    <table id="dgCustomers" toolbar="#toolbarCustomer" class="easyui-datagrid" fit="true" singleSelect="true" fitColumns="true" 
           rowNumbers="false" pagination="true" url="<?= site_url('admin/content/sales/getPartners') ?>" 
           pageSize="50" pageList="[25,50,75,100,125,150,200]" nowrap="false">
        <thead>
            <tr>
                <th field="t_bpid" width="80">Customer Number</th>
                <th field="t_nama" width="100">Customer Name</th>
                <th field="t_clan" width="100">Language</th>
                <th field="t_ccur" width="100">Currency</th>
            </tr>
        </thead>
    </table>
    <div id="toolbarCustomer">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newCustomer()">New</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editCustomer()">Edit</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroyCustomer()">Destroy</a>
        <input  id="searchCustomer" class="easyui-searchbox" data-options="prompt:'Please Input Value',searcher:doSearchCustomer,
                inputEvents: $.extend({}, $.fn.searchbox.defaults.inputEvents, {
                keyup: function(e){
                var t = $(e.data.target);
                var opts = t.searchbox('options');
                t.searchbox('setValue', $(this).val());
                opts.searcher.call(t[0],t.searchbox('getValue'),t.searchbox('getName'));
                }
                })" style="width:50%;"></input>
    </div>
    <?php var_dump($data); ?>
    <!--end of Datagrid partners-->
    <div id="dlgCustomer" class="easyui-dialog" style="width: 780px; height: auto; padding: 10px;" modal="true" closed="true" buttons="#dlgCustomerBtn">
        <form id="fmCustomer" method="post">
            <div class="col-sm-12 justify-content-sm-center">
                <div class="row" style="width: 100%">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="">Customer Number</label>
                            <input type="text" name="t_bpid" class="easyui-textbox" style="width: 100%;">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="">Customer Name</label>
                            <input type="text" name="t_nama" class="easyui-textbox" style="width: 100%;"></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="">Language</label>
                            <input type="text" name="t_clan" class="easyui-textbox" style="width: 100%;"></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="">Currency</label>
                            <input type="text" name="t_ccur" class="easyui-textbox" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="dlgCustomerBtn">
        <a href="javascript:void(0)" id="btn_save" class="easyui-linkbutton" iconCls="icon-ok-a" onclick="saveCustomer()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-del-a" onclick="javascript:$('#dlgCustomer').dialog('close');
                $('#fmEmployee').form(clear)
           " style="width:90px">Cancel</a>
    </div>
</div>