<table id="dg" title="Forecast" style="min-height:350px" toolbar="#toolbar" pagination="true" idField="id" rownumbers="true" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="model" width="50" editor="{type:'validatebox'}">Model</th>
            <th field="item" width="50" editor="{type:'validatebox',options:{required:true}}">Item</th>
            <th field="item_desc" width="50">Description</th>
            <th field="qty" width="50" editor="{type:'validatebox',options:{required:true}}">Quantity</th>
            <th field="1" width="50" editor="{type:'validatebox'}">1</th>
            <th field="2" width="50" editor="{type:'validatebox'}">2</th>
            <th field="3" width="50" editor="{type:'validatebox'}">3</th>
            <th field="4" width="50" editor="{type:'validatebox'}">4</th>
            <th field="5" width="50" editor="{type:'validatebox'}">5</th>
            <th field="6" width="50" editor="{type:'validatebox'}">6</th>
            <th field="7" width="50" editor="{type:'validatebox'}">7</th>
            <th field="8" width="50" editor="{type:'validatebox'}">8</th>
            <th field="9" width="50" editor="{type:'validatebox'}">9</th>
            <th field="10" width="50" editor="{type:'validatebox'}">10</th>
            <th field="11" width="50" editor="{type:'validatebox'}">11</th>
            <th field="12" width="50" editor="{type:'validatebox'}">12</th>
        </tr>
    </thead>
</table>
<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg').edatagrid('addRow')">New</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:$('#dg').edatagrid('destroyRow')">Destroy</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('saveRow')">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancel</a>
</div>