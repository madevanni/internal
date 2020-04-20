var url;
function newItem() {
    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'New Item');
    $('#fm').form('clear');
    url = 'save_item.php';
}
function editItem() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit Item');
        $('#fm').form('load', row);
        url = 'update_item.php?id=' + row.id;
    }
}
function saveItem() {
    $('#fm').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (result) {
            var result = eval('(' + result + ')');
            if (result.errorMsg) {
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            } else {
                $('#dlg').dialog('close');		// close the dialog
                $('#dg').datagrid('reload');	// reload the item data
            }
        }
    });
}
function destroyItem() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirm', 'Are you sure you want to destroy this item?', function (r) {
            if (r) {
                $.post('destroy_item.php', { id: row.id }, function (result) {
                    if (result.success) {
                        $('#dg').datagrid('reload');	// reload the item data
                    } else {
                        $.messager.show({	// show error message
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    }
                }, 'json');
            }
        });
    }
}