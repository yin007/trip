define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'order/index',
                    add_url: 'order/add',
                    edit_url: 'order/edit',
                    del_url: 'order/del',
                    multi_url: 'order/multi',
                    table: 'order',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'order_sn',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        //{field: 'id', title: __('Id')},
                        {field: 'order_sn', title: __('Order_sn')},
                        //{field: 'user_id', title: __('User_id')},
                        //{field: 'equipment_id', title: __('Equipment_id')},
                        //{field: 'equipmentname', title: __('Equipmentname')},
                        {field: 'user.username', title: __('User.username')},
                        {field: 'user.mobile', title: __('User.mobile')},
                        {field: 'title', title: __('Equipment.title')},
                        {field: 'shop.name', title: __('Shop.name')},
                        {field: 'start_city', title: __('Start_city')},
                        {field: 'destination_city', title: __('Destination_city')},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'depositprice', title: __('Depositprice'), operate:'BETWEEN'},
                        {field: 'allprice', title: __('Allprice'), operate:'BETWEEN'},
                        //{field: 'createdtime', title: __('Createdtime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'starttime', title: __('Starttime'), operate:'RANGE', addclass:'datetimerange',formatter: Table.api.formatter.datetime},
                        {field: 'paytime', title: __('Paytime'), operate:'RANGE', addclass:'datetimerange',formatter: Table.api.formatter.datetime},
                        {field: 'endtime', title: __('Endtime'), operate:'RANGE', addclass:'datetimerange',formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"1":__('Status 1'),"2":__('Status 2'),"3":__('Status 3'),"4":__('Status 4'),"5":__('Status 5'),"6":__('Status 6')}, formatter: Table.api.formatter.status},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        //{field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table,
                            events: Table.api.events.operate,
                            buttons: [{
                                name: 'detail',
                                text: __('Refund'),
                                icon: 'fa fa-list',
                                classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                url: 'order/refund'
                            }],
                            //formatter: Table.api.formatter.operate
                            formatter: function (value, row, index) {
                                var table = this.table;
                                if(row.status !== 4){
                                    this.buttons = [];
                                }else{
                                    this.buttons =[{
                                        name: 'detail',
                                        text: __('Refund'),
                                        icon: 'fa fa-list',
                                        classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                        url: 'order/refund'
                                    }];
                                }
                                // 操作配置
                                var options = table ? table.bootstrapTable('getOptions') : {};
                                // 默认按钮组
                                var buttons = $.extend([], this.buttons || []);
                                // 所有按钮名称
                                var names = [];
                                buttons.forEach(function (item) {
                                    names.push(item.name);
                                });
                                if (options.extend.dragsort_url !== '' && names.indexOf('dragsort') === -1) {
                                    buttons.push({
                                        name: 'dragsort',
                                        icon: 'fa fa-arrows',
                                        title: __('Drag to sort'),
                                        extend: 'data-toggle="tooltip"',
                                        classname: 'btn btn-xs btn-primary btn-dragsort'
                                    });
                                }
                                if (options.extend.edit_url !== '' && names.indexOf('edit') === -1) {
                                    buttons.push({
                                        name: 'edit',
                                        icon: 'fa fa-pencil',
                                        title: __('Edit'),
                                        extend: 'data-toggle="tooltip"',
                                        classname: 'btn btn-xs btn-success btn-editone',
                                        url: options.extend.edit_url
                                    });
                                }
                                if (options.extend.del_url !== '' && names.indexOf('del') === -1) {
                                    buttons.push({
                                        name: 'del',
                                        icon: 'fa fa-trash',
                                        title: __('Del'),
                                        extend: 'data-toggle="tooltip"',
                                        classname: 'btn btn-xs btn-danger btn-delone'
                                    });
                                }
                                return Table.api.buttonlink(this, buttons, value, row, index, 'operate');
                            }
                        }
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
        refund: function () {
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