<!-- <table class="easyui-datagrid" title="Business partners information" style="height: 500px" toolbar="#toolbar" data-options="pagination:true,rownumbers:true,singleSelect:true,url:'http://localhost/api/sales/partners?X-API-KEY=1234',method:'get',fitColumns:true">
    <thead>
        <tr>
            <th align="center" data-options="field:'id'" hidden>ID</th>
            <th align="left" data-options="field:'partners'" sortable="true">Business partners</th>
            <th align="left" data-options="field:'address'">Address</th>
            <th align="center" data-options="field:'zipcode'">Zipcode</th>
            <th align="center" data-options="field:'city'">City</th>
            <th align="center" data-options="field:'telephone'">Telephone</th>
            <th align="center" data-options="field:'country'">Country</th>
            <th align="center" data-options="field:'currency'">Currency</th>
            <th align="center" data-options="field:'role'">Role</th>
            <th align="center" data-options="field:'status'">Status</th>
        </tr>
    </thead>
</table>
<div id="toolbar">
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newPartner()">New Partner</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editPartner()">Edit Partner</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyPartner()">Remove Partner</a>
</div> -->
<table id="dg" title="Business Partners" class="easyui-datagrid" style="width:100%;height:250px" url="<?php echo site_url('/admin/content/sales/getPartners'); ?>" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="id" width="50" hidden>ID</th>
            <th field="partners" width="50">Partners</th>
            <th field="address" width="50">Address</th>
            <th field="zipcode" width="50">Zipcode</th>
            <th field="city" width="50">City</th>
            <th field="telephone" width="50">Telephone</th>
            <th field="country" width="50">Country</th>
            <th field="currency" width="50">Currency</th>
            <th field="role" width="50">Role</th>
            <th field="status" width="50">Status</th>
        </tr>
    </thead>
</table>