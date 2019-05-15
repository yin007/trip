define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'equipment/equipment/index',
                    add_url: 'equipment/equipment/add',
                    edit_url: 'equipment/equipment/edit',
                    del_url: 'equipment/equipment/del',
                    multi_url: 'equipment/equipment/multi',
                    table: 'equipment',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        //{field: 'id', title: __('Id')},
                        {field: 'category.name', title: __('EquipmentCategory.name')},
                        {field: 'shop.name', title: __('Shop.name')},
                        {field: 'title', title: __('Title')},
                        {field: 'logoimage', title: __('Logoimage'), formatter: Table.api.formatter.image},
                        {field: 'detailimages', title: __('Detailimages'), formatter: Table.api.formatter.images},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'depositprice', title: __('Depositprice'), operate:'BETWEEN'},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        {field: 'stock', title: __('Stock')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},

                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});