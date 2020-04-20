<table class="easyui-datagrid" title="Sales - Projects" style="height: 500px" toolbar="#toolbar" pagination="true" rownumber="true" singleSelect="true" fitColumns="true" url=<?php echo site_url(SITE_AREA.'/content/sales/getModels')?>>
    <thead>
        <tr>
            <th align="center" field="id" hidden>ID</th>
            <th align="center" field="model">Model</th>
            <th align="center" field="created_by">Created by</th>
            <th align="center" field="modified_on">Modified on</th>
        </tr>
    </thead>
</table>
<div id="toolbar">
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newModel()">New Model</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editModel()">Edit Model</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyModel()">Remove Model</a>
</div>